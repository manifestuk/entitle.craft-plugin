<?php namespace Experience\Entitle\Tests\App\Helpers;

use Experience\Entitle\App\Helpers\CapitalizationHelper;
use Experience\Entitle\Tests\BaseTest;

class CapitalizationHelperTest extends BaseTest
{
    /**
     * @var CapitalizationHelper
     */
    protected $subject;

    public function setUp()
    {
        $customExclusions = ['iPhone', 'NATO', 'MySQL'];
        $this->subject = new CapitalizationHelper($customExclusions);
    }

    public function testItCapitalizesTheFirstWord()
    {
        $input = 'of mice and men';
        $output = $this->subject->capitalize($input);
        $this->assertEquals('O', substr($output, 0, 1));
    }

    public function testItCapitalizesTheLastWord()
    {
        $input = 'of mice and men';
        $output = $this->subject->capitalize($input);
        $this->assertEquals('M', substr($output, -3, 1));
    }

    public function testItDoesNotCapitalizeStandardExcludedWords()
    {
        $input = 'a an and at but by for in nor of on or so the to up yet';
        $expected = 'A an and at but by for in nor of on or so the to up Yet';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItFixesMixedCaseWords()
    {
        $input = 'oF mIce AnD mEN';
        $expected = 'Of Mice and Men';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItDoesNotCapitalizeCustomExcludedWords()
    {
        $input = 'The iPhone should run MySQL for NATO';
        $expected = 'The iPhone Should Run MySQL for NATO';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }
}
