<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('execute a test that fails');
$I->amOnPage('/test/guinea-pig');
$I->see("I am some page content that doesn't exist");