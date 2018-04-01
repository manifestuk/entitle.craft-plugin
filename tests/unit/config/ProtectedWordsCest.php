<?php

namespace experience\entitle\tests\unit\config;

use experience\entitle\config\ProtectedWords;
use UnitTester;

class ProtectedWordsCest
{
    public function _before()
    {
        ProtectedWords::reset();
    }

    public function all(UnitTester $I)
    {
        $I->wantToTest('all returns an array of protected words');

        $words = ProtectedWords::all();

        $I->assertInternalType('array', $words);
        $I->assertGreaterThan(0, count($words));
    }

    public function reset(UnitTester $I)
    {
        $I->wantToTest('reset removes custom words');

        ProtectedWords::supplement(['craft']);
        ProtectedWords::reset();

        $I->assertFalse(in_array('craft', ProtectedWords::all()));
    }

    public function supplementArray(UnitTester $I)
    {
        $I->wantToTest('supplement adds an array of protected words');

        $words = ProtectedWords::supplement(['craft', 'cms']);

        $I->assertTrue(in_array('craft', $words));
        $I->assertTrue(in_array('cms', $words));
    }

    public function supplementString(UnitTester $I)
    {
        $I->wantToTest('supplement adds a single protected word');

        $words = ProtectedWords::supplement('craft');

        $I->assertTrue(in_array('craft', $words));
    }

    public function isProtectedDefault(UnitTester $I)
    {
        $I->wantToTest('is protected returns true for a default protected word');

        $word = ProtectedWords::all()[0];

        $I->assertTrue(ProtectedWords::isProtected($word));
    }

    public function isProtectedCustom(UnitTester $I)
    {
        $I->wantToTest('is protected returns true for a custom protected word');

        ProtectedWords::supplement('craft');

        $I->assertTrue(ProtectedWords::isProtected('craft'));
    }

    public function isProtectedFalse(UnitTester $I)
    {
        $I->wantToTest('is protected returns false for a non-protected word');

        $I->assertFalse(ProtectedWords::isProtected('craft'));
    }

    public function isDefault(UnitTester $I)
    {
        $I->wantToTest('is default returns true for a default protected word');

        $word = ProtectedWords::all()[0];

        $I->assertTrue(ProtectedWords::isDefault($word));
    }

    public function isDefaultIgnoreCase(UnitTester $I)
    {
        $I->wantToTest('is default ignores the case of the given word');

        $word = ucfirst(ProtectedWords::all()[1]);

        $I->assertTrue(ProtectedWords::isDefault($word));
    }

    public function isDefaultCustom(UnitTester $I)
    {
        $I->wantToTest('is default returns false for a custom protected word');

        ProtectedWords::supplement('craft');

        $I->assertFalse(ProtectedWords::isDefault('craft'));
    }

    public function isDefaultFalse(UnitTester $I)
    {
        $I->wantToTest('is default returns false for a non-protected word');

        $I->assertFalse(ProtectedWords::isDefault('craft'));
    }

    public function isCustom(UnitTester $I)
    {
        $I->wantToTest('is custom returns true for a custom protected word');

        ProtectedWords::supplement('craft');

        $I->assertTrue(ProtectedWords::isCustom('craft'));
    }

    public function isCustomPreserveCase(UnitTester $I)
    {
        $I->wantToTest('is custom preserves the case of the given word');

        ProtectedWords::supplement('Craft');

        $I->assertTrue(ProtectedWords::isCustom('Craft'));
        $I->assertFalse(ProtectedWords::isCustom('craft'));
    }

    public function isCustomDefault(UnitTester $I)
    {
        $I->wantToTest('is custom returns false for a default protected word');

        $word = ProtectedWords::all()[0];

        $I->assertFalse(ProtectedWords::isCustom($word));
    }

    public function isCustomFalse(UnitTester $I)
    {
        $I->wantToTest('is custom returns false for a non-protected word');

        $I->assertFalse(ProtectedWords::isCustom('craft'));
    }
}
