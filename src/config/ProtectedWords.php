<?php

namespace experience\entitle\config;

class ProtectedWords
{
    /**
     * Custom protected words, as defined by the user
     *
     * @var array
     */
    protected $customWords;

    /**
     * The default protected words, as defined by the AP
     *
     * @var array
     */
    protected $defaultWords;

    /**
     * Constructor.
     *
     * @param array $customWords
     */
    public function __construct(array $customWords = [])
    {
        $this->initializeDefaultWords();
        $this->initializeCustomWords($customWords);
    }

    /**
     * Initialise the default protected words
     */
    protected function initializeDefaultWords()
    {
        $this->defaultWords = explode(
            ' ', 'a an and at but by for in nor of on or so the to up yet');
    }

    /**
     * Set the custom protected words
     *
     * @param array $customWords
     */
    protected function initializeCustomWords(array $customWords)
    {
        $this->customWords = array_map('trim', array_values($customWords));
    }

    /**
     * Is a word protected?
     *
     * @param string $word
     *
     * @return bool
     */
    public function isProtected(string $word): bool
    {
        return $this->isDefault($word) || $this->isCustom($word);
    }

    /**
     * Is a word a default protected word?
     *
     * @param string $word
     *
     * @return bool
     */
    public function isDefault(string $word): bool
    {
        return in_array(strtolower($word), $this->defaultWords);
    }

    /**
     * Is a word a custom protected word?
     *
     * @param string $word
     *
     * @return bool
     */
    public function isCustom(string $word): bool
    {
        return in_array($word, $this->customWords);
    }

    /**
     * Get an array of protected words
     *
     * @return array
     */
    public function all(): array
    {
        return array_unique(array_merge(
            $this->defaultWords,
            $this->customWords
        ));
    }
}
