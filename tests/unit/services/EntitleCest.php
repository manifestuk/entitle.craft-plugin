<?php

namespace experience\entitle\tests\unit\services;

use experience\entitle\services\Entitle;
use UnitTester;

class EntitleCest
{
    public function capitalizeFirstWord(UnitTester $I)
    {
        $I->wantToTest('it capitalises the first word in a string');

        $input = 'of mice and men';
        $output = (new Entitle)->capitalize($input);

        $I->assertSame('O', substr($output, 0, 1));
    }

    public function capitalizeLastWord(UnitTester $I)
    {
        $I->wantToTest('it capitalises the last word in a string');

        $input = 'of mice and men';
        $output = (new Entitle)->capitalize($input);

        $I->assertSame('M', substr($output, -3, 1));
    }

    public function capitalizeFirstWordInSentence(UnitTester $I)
    {
        $I->wantToTest('it capitalises the first word in a sentence');

        $input = '"tricky," said he. "indeed," said i';
        $expected = '"Tricky," Said He. "Indeed," Said I';

        $I->assertSame($expected, (new Entitle)->capitalize($input));
    }

    public function preserveDefaultProtectedWords(UnitTester $I)
    {
        $I->wantToTest('it does not capitalise default protected words');

        $input = 'a an and at but by for in nor of on or so the to up yet';
        $expected = 'A an and at but by for in nor of on or so the to up Yet';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function preserveCustomProtectedWords(UnitTester $I)
    {
        $I->wantToTest('it does not capitalise custom protected words');

        $subject = new Entitle(['iPhone', 'MySQL', 'CIA']);

        $input = 'The iPhone should run MySQL for the CIA';
        $expected = 'The iPhone Should Run MySQL for the CIA';

        $I->assertEquals($expected, $subject->capitalize($input));
    }

    public function normalizeMixedCaseWords(UnitTester $I)
    {
        $I->wantToTest('it normalises mixed-case words');

        $input = 'oF mIce AnD mEN';
        $expected = 'Of Mice and Men';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function singleQuoteWords(UnitTester $I)
    {
        $I->wantToTest('it handles words surrounded by single quotes');

        $input = "of 'mice' and men";
        $expected = "Of 'Mice' and Men";

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function singleQuoteCustomProtectedWords(UnitTester $I)
    {
        $I->wantToTest('it handles custom protected words surrounded by single quotes');

        $subject = new Entitle(['MySQL']);

        $input = "'MySQL' the database engine";
        $expected = "'MySQL' the Database Engine";

        $I->assertEquals($expected, $subject->capitalize($input));
    }

    public function curlyQuotes(UnitTester $I)
    {
        $I->wantToTest('it handles curly quotes');

        $input = "“sad!”, said ‘president’ trump";
        $expected = "“Sad!”, Said ‘President’ Trump";

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function doubleQuoteWords(UnitTester $I)
    {
        $I->wantToTest('it handles words surrounded by double quotes');

        $input = 'of "mice" and men';
        $expected = 'Of "Mice" and Men';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function doubleQuoteCustomProtectedWords(UnitTester $I)
    {
        $I->wantToTest('it handles custom protected words surrounded by double quotes');

        $subject = new Entitle(['MySQL']);

        $input = 'The database engine known as "MySQL"';
        $expected = 'The Database Engine Known As "MySQL"';

        $I->assertEquals($expected, $subject->capitalize($input));
    }

    public function trimLeadingWhitespace(UnitTester $I)
    {
        $I->wantToTest('it removes leading whitespace');

        $input = '   example title';
        $expected = 'Example Title';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function trimTrailingWhitespace(UnitTester $I)
    {
        $I->wantToTest('it removes trailing whitespace');

        $input = 'example title   ';
        $expected = 'Example Title';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function collapseInterWordWhitespace(UnitTester $I)
    {
        $I->wantToTest('it collapses inter-word whitespace');

        $input = 'example    title';
        $expected = 'Example Title';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function normalizeCommaWhitespace(UnitTester $I)
    {
        $I->wantToTest('it normalises whitespace around commas');

        $input = 'and now   ,the end is near';
        $expected = 'And Now, the End Is Near';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function normalizeColonWhitespace(UnitTester $I)
    {
        $I->wantToTest('it normalises whitespace around colons');

        $input = 'and now:the end is near';
        $expected = 'And Now: the End Is Near';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function normalizeSemiColonWhitespace(UnitTester $I)
    {
        $I->wantToTest('it normalises whitespace around semi-colons');

        $input = 'and now ; the end is near';
        $expected = 'And Now; the End Is Near';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function commaNoLetter(UnitTester $I)
    {
        $I->wantToTest('it handles commas not followed by a letter');

        $input = '"Tricky," said he.';
        $expected = '"Tricky," Said He.';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function forwardSlashes(UnitTester $I)
    {
        $I->wantToTest('it handles words separated by forward slashes');

        $input = 'this/that/other';
        $expected = 'This/That/Other';

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function versionNumbers(UnitTester $I)
    {
        $I->wantToTest('it handles version numbers');

        $subject = new Entitle(['Craft', 'MySQL']);

        $input = 'making craft play nicely with MySQL 5.7.5+';
        $expected = 'Making Craft Play Nicely With MySQL 5.7.5+';

        $I->assertEquals($expected, $subject->capitalize($input));
    }

    public function apostrophes(UnitTester $I)
    {
        $I->wantToTest('it handles apostrophes');

        $input = "We're all in this together";
        $expected = "We're All in This Together";

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function curlyApostrophes(UnitTester $I)
    {
        $I->wantToTest('it handles curly apostrophes');

        $input = "We’re all in this together";
        $expected = "We’re All in This Together";

        $I->assertEquals($expected, (new Entitle)->capitalize($input));
    }

    public function psr(UnitTester $I)
    {
        $I->wantToTest('it handles PSR strings');

        $subject = new Entitle(['PSR']);

        $input = "The code on this site complies with PSR-2.";
        $expected = "The Code on This Site Complies With PSR-2.";

        $I->assertEquals($expected, $subject->capitalize($input));
    }
}
