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


-----