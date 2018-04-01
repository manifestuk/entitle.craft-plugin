<?php

namespace experience\entitle\tests\unit\config;

use experience\entitle\config\ProtectedWords;
use UnitTester;

class ProtectedWordsCest
{
    public function constructWithCustomWords(UnitTester $I)
    {
        $I->wantToTest('the constructor accepts an array of custom words');

        $words = (new ProtectedWords(['craft', 'cms']))->all();

        $I->assertTrue(in_array('craft', $words));
        $I->assertTrue(in_array('cms', $words));
    }

    public function constructTrimsCustomWords(UnitTester $I)
    {
        $I->wantToTest('the constructor trims each custom word');

        $words = (new ProtectedWords(['  craft', 'cms  ']))->all();

        $I->assertTrue(in_array('craft', $words));
        $I->assertTrue(in_array('cms', $words));
    }

    public function all(UnitTester $I)
    {
        $I->wantToTest('all returns an array of protected words');

        $words = (new ProtectedWords)->all();

        $I->assertInternalType('array', $words);
        $I->assertGreaterThan(0, count($words));
    }

    public function isProtectedDefault(UnitTester $I)
    {
        $I->wantToTest('is protected returns true for a default protected word');

        $I->assertTrue((new ProtectedWords)->isProtected('and'));
    }

    public function isProtectedCustom(UnitTester $I)
    {
        $I->wantToTest('is protected returns true for a custom protected word');

        $I->assertTrue((new ProtectedWords(['craft']))->isProtected('craft'));
    }

    public function isProtectedFalse(UnitTester $I)
    {
        $I->wantToTest('is protected returns false for a non-protected word');

        $I->assertFalse((new ProtectedWords)->isProtected('craft'));
    }

    public function isDefault(UnitTester $I)
    {
        $I->wantToTest('is default returns true for a default protected word');

        $I->assertTrue((new ProtectedWords)->isDefault('and'));
    }

    public function isDefaultIgnoreCase(UnitTester $I)
    {
        $I->wantToTest('is default ignores the case of the given word');

        $I->assertTrue((new ProtectedWords)->isDefault('And'));
    }

    public function isDefaultCustom(UnitTester $I)
    {
        $I->wantToTest('is default returns false for a custom protected word');

        $I->assertFalse((new ProtectedWords(['craft']))->isDefault('craft'));
    }

    public function isDefaultFalse(UnitTester $I)
    {
        $I->wantToTest('is default returns false for a non-protected word');

        $I->assertFalse((new ProtectedWords)->isDefault('craft'));
    }

    public function isCustom(UnitTester $I)
    {
        $I->wantToTest('is custom returns true for a custom protected word');

        $I->assertTrue((new ProtectedWords(['craft']))->isCustom('craft'));
    }

    public function isCustomPreserveCase(UnitTester $I)
    {
        $I->wantToTest('is custom preserves the case of the given word');

        $subject = new ProtectedWords(['Craft']);

        $I->assertTrue($subject->isCustom('Craft'));
        $I->assertFalse($subject->isCustom('craft'));
    }

    public function isCustomDefault(UnitTester $I)
    {
        $I->wantToTest('is custom returns false for a default protected word');

        $I->assertFalse((new ProtectedWords)->isCustom('and'));
    }

    public function isCustomFalse(UnitTester $I)
    {
        $I->wantToTest('is custom returns false for a non-protected word');

        $I->assertFalse((new ProtectedWords)->isCustom('craft'));
    }
}
