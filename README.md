Codeception Extension: Saucelabs Metadata
============================

Codeception extension that provides metadata to Saucelabs when running tests.

## Requirements

* A Saucelabs account
* A Codeception acceptance testing suite that is configured to run tests against Saucelabs
* Codeception >= 2.0.2

## Installation

1. Install [Codeception](http://codeception.com) via Composer
2. Add  `neam/codeception-saucelabs-metadata: "*"` to your `composer.json`
3. Run `composer update neam/codeception-saucelabs-metadata`.
4. Include the extension into `codeception.yml` configuration:

Sample:

``` yaml
paths:
    tests: tests
    log: tests/_log
    data: tests/_data
    helpers: tests/_helpers
extensions:
    enabled:
      - Codeception\Extension\SaucelabsMetadata
    config:
      Codeception\Extension\SaucelabsMetadata:
          username: "foouser"
          accesskey: "secretavbcde1234"
          build: "Shows up in the Build column in the Saucelabs dashboard"
          tags: "shows up,in the tags column,in the saucelabs dashboard"

## Testing this extension

1. Run the following from the same directory as this README (change the access details accordingly):

    composer install
    vendor/bin/codecept bootstrap
    vendor/bin/codecept generate:cept acceptance ExampleTest

    export SAUCE_USERNAME="changeme"
    export SAUCE_ACCESS_KEY="changeme"
    export SAUCE_METADATA_BUILD="foo"
    export SAUCE_METADATA_TAGS="foo,bar,zoo"
    export SELENIUM_HOST=$SAUCE_USERNAME:$SAUCE_ACCESS_KEY@ondemand.saucelabs.com
    export SELENIUM_PORT=80

    erb extension-testing/codeception.yml.erb > codeception.yml
    erb extension-testing/acceptance.suite.yml.erb > tests/acceptance.suite.yml
    cp extension-testing/*Cept.php tests/acceptance/

    vendor/bin/codecept run acceptance

2. Verify in your Saucelabs dashboard that the tests show up properly

-----