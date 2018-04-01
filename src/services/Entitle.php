<?php

namespace experience\entitle\services;

use experience\entitle\config\ProtectedWords;
use yii\base\Component;

class Entitle extends Component
{
    /**
     * @var ProtectedWords
     */
    protected $wordHelper;

    /**
     * Constructor.
     *
     * @param array $customWords Array of custom protected words
     * @param array $config      Configuration array, inherited from parent
     */
    public function __construct(array $customWords = [], array $config = [])
    {
        $this->wordHelper = new ProtectedWords($customWords);

        parent::__construct($config);
    }

    /**
     * Capitalise a string, according to AP rules
     *
     * @param string $input
     *
     * @return string
     */
    public function capitalize(string $input): string
    {
        $input = $this->normalize($input);
        $parts = $this->splitIntoParts($input);
        $parts = $this->processParts($parts);
        $parts = $this->processFirstSentenceWordsInParts($parts);
        $parts = $this->processLastWordInParts($parts);

        return $this->joinParts($parts);
    }

    /**
     * Normalise a string, ready for capitalisation
     *
     * @param string $input
     *
     * @return string
     */
    protected function normalize(string $input): string
    {
        $input = $this->normalizeWhitespace($input);
        $input = $this->normalizePunctuation($input);

        return $input;
    }

    /**
     * Split a string into parts, which may be processed separately
     *
     * @param string $input
     *
     * @return string[]
     */
    protected function splitIntoParts(string $input): array
    {
        return preg_split(
            "/([A-z]+[\-'’]{1}[A-z]+)|([A-z]+)/u",
            $input,
            null,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );
    }

    /**
     * Process parts
     *
     * @param array $parts
     *
     * @return array
     */
    protected function processParts(array $parts): array
    {
        array_walk($parts, function (&$part) {
            $part = $this->isWordLike($part) ? $this->processWord($part) : $part;
        });

        return $parts;
    }

    /**
     * Process the first words in any sentences within an array of parts
     *
     * @param array $parts
     *
     * @return array
     */
    protected function processFirstSentenceWordsInParts(array $parts): array
    {
        $length = count($parts);
        $isFirst = true;

        for ($index = 0; $index < $length; $index++) {
            $part = $parts[$index];

            if ($this->isWordLike($part)) {
                if ($isFirst) {
                    $parts[$index] = $this->processFirstLastWord($part);
                    $isFirst = false;
                }
                continue;
            }

            if ($this->isSentenceDelimiter($part)) {
                $isFirst = true;
            }
        }

        return $parts;
    }

    /**
     * Process the last word-like item in an array of parts
     *
     * @param array $parts
     *
     * @return array
     */
    protected function processLastWordInParts(array $parts): array
    {
        $parts = array_reverse($parts);
        $length = count($parts);

        for ($index = 0; $index < $length; $index++) {
            $part = $parts[$index];

            if ($this->isWordLike($part)) {
                $parts[$index] = $this->processFirstLastWord($part);
                break;
            }
        }

        return array_reverse($parts);
    }

    /**
     * Convert parts back into a string
     *
     * @param array $parts
     *
     * @return string
     */
    protected function joinParts(array $parts): string
    {
        return implode('', $parts);
    }

    /**
     * Remove leading and trailing whitespace, and collapse all internal
     * whitespace to a single space.
     *
     * @param string $input
     *
     * @return string
     */
    protected function normalizeWhitespace(string $input): string
    {
        return $this->replacePattern(trim($input), '/[\s]+/', ' ');
    }

    /**
     * Ensure that punctuation characters have no leading spaces, and one
     * trailing space.
     *
     * @param string $input
     *
     * @return string
     */
    protected function normalizePunctuation(string $input): string
    {
        return $this->replacePattern($input, '/\s*([,;:])\s*([A-z])/', '$1 $2');
    }

    /**
     * Does a string look like a word?
     *
     * @param string $input
     *
     * @return bool
     */
    protected function isWordLike(string $input): string
    {
        return (bool) preg_match(
            "/(^[A-z]+[\-'’]{1}[A-z]+$)|(^[A-z]+$)/u", $input);
    }

    /**
     * Process a word
     *
     * @param string $word
     *
     * @return string
     */
    protected function processWord(string $word): string
    {
        if ($this->wordHelper->isDefault($word)) {
            return $this->toLowercase($word);
        }

        if ($this->wordHelper->isCustom($word)) {
            return $word;
        }

        return $this->capitalizeWord($word);
    }

    /**
     * Process the first or last word in a sentence
     *
     * The first and last word should always be capitalised, _unless_ it is a
     * custom protected word.
     *
     * @param string $word
     *
     * @return string
     */
    protected function processFirstLastWord(string $word): string
    {
        return $this->wordHelper->isCustom($word)
            ? $word
            : $this->capitalizeWord($word);
    }

    /**
     * Is the string a sentence delimiter?
     *
     * @param string $input
     *
     * @return bool
     */
    protected function isSentenceDelimiter(string $input): bool
    {
        return $input === '.';
    }

    /**
     * Replace all matches of a regular expression pattern in a string
     *
     * If an error occurs, return the original string.
     *
     * @param string $input
     * @param string $pattern
     * @param string $replacement
     *
     * @return string
     */
    protected function replacePattern(
        string $input,
        string $pattern,
        string $replacement
    ): string {
        $output = preg_replace($pattern, $replacement, $input);

        return is_null($output) ? $input : $output;
    }

    /**
     * Convert a string to lowercase
     *
     * @param string $word
     *
     * @return string
     */
    protected function toLowercase(string $word): string
    {
        return strtolower($word);
    }

    /**
     * Capitalise a word
     *
     * @param string $word
     *
     * @return string
     */
    protected function capitalizeWord(string $word): string
    {
        return ucfirst(strtolower($word));
    }
}
