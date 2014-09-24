<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('execute a test that passes');
$I->amOnPage('/test/guinea-pig');
$I->see("I am some page content");