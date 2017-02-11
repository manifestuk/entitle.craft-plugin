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

    public function testItHandlesSingleQuotedWords()
    {
        $input = "of 'mice' and men";
        $expected = "Of 'Mice' and Men";
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItHandlesSingleQuotedCustomExcludedWords()
    {
        $input = "'MySQL' the database engine";
        $expected = "'MySQL' the Database Engine";
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItHandlesCurlyQuotes()
    {
        $input = "“sad!”, said ‘president’ trump";
        $expected = "“Sad!”, Said ‘President’ Trump";
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItHandlesDoubleQuotedCustomExcludedWords()
    {
        $input = 'The database engine known as "MySQL"';
        $expected = 'The Database Engine Known As "MySQL"';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItRemovesLeadingWhitespace()
    {
        $input = '   example title';
        $expected = 'Example Title';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItRemovesTrailingWhitespace()
    {
        $input = 'example title   ';
        $expected = 'Example Title';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItCollapsesInterwordWhitespace()
    {
        $input = 'example    title';
        $expected = 'Example Title';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItNormalizesWhitespaceAroundCommas()
    {
        $input = 'and now   ,the end is near';
        $expected = 'And Now, the End Is Near';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItNormalizesWhitespaceAroundColons()
    {
        $input = 'and now:the end is near';
        $expected = 'And Now: the End Is Near';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItNormalizesWhitespaceAroundSemiColons()
    {
        $input = 'and now ; the end is near';
        $expected = 'And Now; the End Is Near';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItNormalizedWhitespaceAroundAmpersands()
    {
        $input = 'of mice&men';
        $expected = 'Of Mice & Men';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItNormalizedWhitespaceAroundPlusSigns()
    {
        $input = 'of mice+men';
        $expected = 'Of Mice + Men';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItNormalizedWhitespaceAroundAsterisks()
    {
        $input = 'width*height';
        $expected = 'Width * Height';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItHandlesCapitalizationWithForwardSlashes()
    {
        $input = 'this/that/other';
        $expected = 'This/That/Other';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }
}
