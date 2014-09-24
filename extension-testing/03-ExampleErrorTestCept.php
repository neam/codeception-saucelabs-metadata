<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('execute a test that runs into an unexpected error');
$I->amOnPage('/test/guinea-pig');
$I->fooBar(""); // Should cause an error