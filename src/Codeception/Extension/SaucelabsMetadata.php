<?php
namespace Codeception\Extension;

require_once __DIR__ . '/../../../vendor/autoload.php';

class SaucelabsMetadata extends \Codeception\Platform\Extension
{

    static $events = array(
        'test.before' => 'beforeTest',
        'test.error' => 'testError',
        'test.fail' => 'testFailed',
        'test.success' => 'testSuccess',
    );

    protected $sauceApi;

    public function & sauceApi()
    {
        if (!($this->sauceApi instanceof \Sauce\Sausage\SauceAPI)) {
            $this->sauceApi = new \Sauce\Sausage\SauceAPI($this->config['username'], $this->config['accesskey']);
        }
        return $this->sauceApi;
    }

    /**
     * We currently assume that the firstmost job is the current test for which we should update metadata.
     * This is not always true, but at the moment there seems to be little to be done in this matter.
     *
     * @return array
     */
    protected function getCorrespondingSaucelabsJob()
    {
        $jobs = $this->sauceApi()->getJobs($from = 0, $to = null, $limit = 1, $skip = null, $username = null);
        return $jobs['jobs'][0];
    }

    public function beforeTest(\Codeception\Event\TestEvent $e)
    {
        $test = $e->getTest();
        $job = $this->getCorrespondingSaucelabsJob($e);
        try {
            $build = $this->config['build'];
        } catch (\Exception $e) {
            $build = date('d-M-Y');
        }
        $metadata = $this->gatherMetaData($test);
        $this->sauceApi()->updateJob($job['id'], array(
            'name' => $test->getName(),
            'build' => $build,
            'tags' => $metadata['tags'],
            'custom-data' => $metadata['custom-data'],
        ));
    }

    public function testError(\Codeception\Event\FailEvent $e)
    {
        $job = $this->getCorrespondingSaucelabsJob($e);
        $this->sauceApi()->stopJob($job['id']);
    }

    public function testFailed(\Codeception\Event\FailEvent $e)
    {
        $job = $this->getCorrespondingSaucelabsJob($e);
        $this->sauceApi()->updateJob($job['id'], array('passed' => false));
    }

    public function testSuccess(\Codeception\Event\TestEvent $e)
    {
        $job = $this->getCorrespondingSaucelabsJob($e);
        $this->sauceApi()->updateJob($job['id'], array('passed' => true));
    }

    /**
     * Gather metadata about the current test to send to saucelabs, making it easier to filter tests
     * @return array
     */
    protected function gatherMetaData($test)
    {
        $metadata = array(
            // Default tags from config
            'tags' => isset($this->config['tags']) ? explode(",", $this->config['tags']) : array(),
            // Default custom data is empty
            'custom-data' => array(),
        );

        // Tag with the current test string reference
        $metadata['tags'][] = "test:" . $test->toString();

        // Add codeception runtime options to custom-data
        $metadata['custom-data']['options'] = $this->options;

        return $metadata;
    }

}