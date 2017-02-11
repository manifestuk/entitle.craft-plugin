<?php namespace Experience\Entitle\App\Helpers;

class CapitalizationHelper
{
    /**
     * @var string[]
     */
    protected $standardProtectedWords;

    /**
     * @var string[]
     */
    protected $customProtectedWords;

    /**
     * Constructor.
     *
     * @param array $customProtectedWords
     */
    public function __construct(array $customProtectedWords = [])
    {
        $this->initializeStandardProtectedWords();
        $this->initializeCustomProtectedWords($customProtectedWords);
    }

    /**
     * Initialises the "standard protected words" array.
     */
    protected function initializeStandardProtectedWords()
    {
        $words = 'a an and at but by for in nor of on or so the to up yet';
        $this->standardProtectedWords = explode(' ', $words);
    }

    /**
     * Removes leading and trailing spaces for the given words, and assigns the
     * array to the "custom protected words" property.
     *
     * @param string[] $words
     */
    protected function initializeCustomProtectedWords(array $words)
    {
        $this->customProtectedWords = [];

        foreach ($words as $word) {
            $this->customProtectedWords[] = trim($word);
        }
    }

    /**
     * Capitalises the given string, according to AP rules.
     *
     * @param string $string
     *
     * @return string
     */
    public function capitalize($string)
    {
        $string = $this->normalizeInput($string);

        $string = $this->createStringFromWords(
            $this->processWords($this->splitStringIntoWords($string))
        );

        return $this->normalizeOutput($string);
    }

    /**
     * Normalises the given string, ready for capitalisation.
     *
     * @param string $string
     *
     * @return string
     */
    protected function normalizeInput($string)
    {
        $string = $this->normalizeInputWhitespace($string);
        $string = $this->normalizeInputSpecialCharacters($string);
        $string = $this->normalizeInputPunctuation($string);
        $string = $this->normalizeInputConjunctions($string);
        $string = $this->normalizeInputForwardSlashes($string);
        return $string;
    }

    /**
     * Joins the given array of words, and returns a string.
     *
     * @param string[] $words
     *
     * @return string
     */
    protected function createStringFromWords(array $words)
    {
        return implode(' ', $words);
    }

    /**
     * Processes the given array of words.
     *
     * @param string[] $words
     *
     * @return string[]
     */
    protected function processWords(array $words)
    {
        $processed = [];
        $length = count($words) - 1;

        for ($index = 0; $index <= $length; $index++) {
            list($prefix, $word, $suffix) = $this->splitWordIntoParts(
                $words[$index]);

            // The first and last words are always capitalised.
            $word = ($index == 0 or $index == $length)
                ? $this->processFirstLastWord($word)
                : $this->processWord($word);

            $processed[] = $prefix . $word . $suffix;
        }

        return $processed;
    }

    /**
     * Splits the given string into an array of words.
     *
     * @param string $string
     *
     * @return string[]
     */
    protected function splitStringIntoWords($string)
    {
        return explode(' ', $string);
    }

    /**
     * Normalises the given string, ready for output.
     *
     * @param string $string
     *
     * @return string
     */
    protected function normalizeOutput($string)
    {
        $string = $this->normalizeOutputForwardSlashes($string);
        return $string;
    }

    /**
     * Removes leading and trailing whitespace, and collapses all internal
     * whitespace to a single space.
     *
     * @param string $string
     *
     * @return string
     */
    protected function normalizeInputWhitespace($string)
    {
        return $this->replacePattern(trim($string), '/[\s]+/', ' ');
    }

    /**
     * Removes the following "special" characters from the given string.
     *
     * U+200B zero width space
     * U+200C zero width non-joiner Unicode code point
     * U+200D zero width joiner Unicode code point
     * U+FEFF zero width no-break space Unicode code point
     *
     * @param string $string
     *
     * @return string
     */
    protected function normalizeInputSpecialCharacters($string)
    {
        return $this->replacePattern($string, '/[\x{200B}-\x{200D}]+/u', '');
    }

    /**
     * Ensures that punctuation characters have no leading spaces, and one
     * trailing space.
     *
     * @param string $string
     *
     * @return string
     */
    protected function normalizeInputPunctuation($string)
    {
        return $this->replacePattern($string, '/\s?([,;:])\s?/', '$1 ');
    }

    /**
     * Ensures that "conjunction" characters (&, +, *) have one leading space,
     * and one trailing space.
     *
     * @param string $string
     *
     * @return string
     */
    protected function normalizeInputConjunctions($string)
    {
        return $this->replacePattern($string, '/\s?([&\+\*])\s?/', ' $1 ');
    }

    /**
     * Ensures that forwards slashes have one leading space, and one trailing
     * space. These spaces will be removed when preparing the string for
     * output, but are required for the word capitalisation to work correctly.
     *
     * @param string $string
     *
     * @return string
     */
    public function normalizeInputForwardSlashes($string)
    {
        return $this->replacePattern($string, '/\s?(\/)\s?/', ' $1 ');
    }

    /**
     * Splits the given word into an array with the following structure:
     * - Zero or more non-word characters (e.g. '“')
     * - Zero or more word characters (e.g. 'so-called')
     * - Zero or more non-word characters (e.g. '”')
     *
     * @param string $word
     *
     * @return string[]
     */
    protected function splitWordIntoParts($word)
    {
        preg_match('/^(\W*)(\w*)(\W*)$/', $word, $parts);
        return array_slice($parts, 1);
    }

    /**
     * Processes the first or last word in the sentence. The first and last
     * word should always be capitalised, _unless_ it is a custom protected
     * word.
     *
     * @param string $word
     *
     * @return string
     */
    protected function processFirstLastWord($word)
    {
        return $this->isCustomProtectedWord($word)
            ? $word
            : $this->capitalizeWord($word);
    }

    /**
     * Processes the given word.
     *
     * @param string $word
     *
     * @return string
     */
    protected function processWord($word)
    {
        if ($this->isStandardProtectedWord($word)) {
            return $this->lowercaseWord($word);
        }

        if ($this->isCustomProtectedWord($word)) {
            return $word;
        }

        return $this->capitalizeWord($word);
    }

    /**
     * Removes spaces around forward slashes, ready for output.
     *
     * @param string $string
     *
     * @return string
     */
    protected function normalizeOutputForwardSlashes($string)
    {
        return str_replace(' / ', '/', $string);
    }

    /**
     * Replaces all matches of the given regular expression pattern in the
     * given string with the given replacement. If an error occurs, returns the
     * original string.
     *
     * @param string $string
     * @param string $pattern
     * @param string $replacement
     *
     * @return string
     */
    protected function replacePattern($string, $pattern, $replacement)
    {
        $replaced = preg_replace($pattern, $replacement, $string);
        return is_null($replaced) ? $string : $replaced;
    }

    /**
     * Returns a boolean indicating whether the given word is a custom
     * protected word, which should not be modified.
     *
     * @param string $word
     *
     * @return bool
     */
    protected function isCustomProtectedWord($word)
    {
        return in_array($word, $this->customProtectedWords);
    }

    /**
     * Capitalises the given word.
     *
     * @param string $word
     *
     * @return string
     */
    protected function capitalizeWord($word)
    {
        return ucfirst($this->lowercaseWord($word));
    }

    /**
     * Returns a boolean indicating whether the given word is a standard
     * protected word, which should not be capitalised.
     *
     * @param string $word
     *
     * @return bool
     */
    protected function isStandardProtectedWord($word)
    {
        return in_array(strtolower($word), $this->standardProtectedWords);
    }

    /**
     * Lowercases the given word.
     *
     * @param string $word
     *
     * @return string
     */
    protected function lowercaseWord($word)
    {
        return strtolower($word);
    }
}
