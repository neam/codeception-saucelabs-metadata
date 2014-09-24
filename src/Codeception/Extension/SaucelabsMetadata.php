<?php
namespace Codeception\Extension;

require_once __DIR__ . '/../../../vendor/autoload.php';

class SaucelabsMetadata extends \Codeception\Platform\Extension
{

    static $events = array('todo' => 'todo');

    function todo($event)
    {

        // TODO

    }

}