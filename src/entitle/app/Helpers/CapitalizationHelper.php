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
        array_walk(
            $words,
            function ($word) {
                return trim($word);
            }
        );

        $this->customProtectedWords = $words;
    }

    public function capitalize($string)
    {
        return $this->createStringFromWords(
            $this->processWords($this->splitStringIntoWords($string))
        );
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
            $word = $words[$index];

            // The first and last words are always capitalised.
            if ($index == 0 or $index == $length) {
                $processed[] = $this->processFirstLastWord($word);
            } else {
                $processed[] = $this->processWord($word);
            }
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
