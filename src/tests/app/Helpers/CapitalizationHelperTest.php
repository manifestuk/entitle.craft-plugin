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
        $customExclusions = ['iPhone', 'CIA', 'MySQL', 'PSR'];
        $this->subject = new CapitalizationHelper($customExclusions);
    }

    public function testItCapitalizesTheFirstWordInTheString()
    {
        $input = 'of mice and men';
        $output = $this->subject->capitalize($input);
        $this->assertEquals('O', substr($output, 0, 1));
    }

    public function testItCapitalizesTheLastWordInTheString()
    {
        $input = 'of mice and men';
        $output = $this->subject->capitalize($input);
        $this->assertEquals('M', substr($output, -3, 1));
    }

    public function testItCapitalizesTheFirstWordInASentence()
    {
        $input = '"tricky," said he. "indeed," said i';
        $expected = '"Tricky," Said He. "Indeed," Said I';
        $this->assertEquals($expected, $this->subject->capitalize($input));
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
        $input = 'The iPhone should run MySQL for the CIA';
        $expected = 'The iPhone Should Run MySQL for the CIA';
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

    public function testItHandlesDoubleQuotedWords()
    {
        $input = 'of "mice" and men';
        $expected = 'Of "Mice" and Men';
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

    public function testItDoesNotAddASpaceAfterACommaNotFollowedByALetter()
    {
        $input = '"Tricky," said he.';
        $expected = '"Tricky," Said He.';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItHandlesCapitalizationWithForwardSlashes()
    {
        $input = 'this/that/other';
        $expected = 'This/That/Other';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItHandlesVersionNumbers()
    {
        $input = 'making craft play nicely with MySQL 5.7.5+';
        $expected = 'Making Craft Play Nicely With MySQL 5.7.5+';
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItHandlesApostrophes()
    {
        $input = "We're all in this together";
        $expected = "We're All in This Together";
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItHandlesCurlyApostrophes()
    {
        $input = "We’re all in this together";
        $expected = "We’re All in This Together";
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }

    public function testItHandlesPsrStrings()
    {
        $input = "The code on this site complies with PSR-2.";
        $expected = "The Code on This Site Complies With PSR-2.";
        $this->assertEquals($expected, $this->subject->capitalize($input));
    }
}
