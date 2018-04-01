<?php

namespace experience\entitle\config;

class ProtectedWords
{
    /**
     * @var array
     */
    protected static $customWords = [];

    /**
     * @var array
     */
    protected static $defaultWords = [
        'a',
        'an',
        'and',
        'at',
        'but',
        'by',
        'for',
        'in',
        'nor',
        'of',
        'on',
        'or',
        'so',
        'the',
        'to',
        'up',
        'yet',
    ];

    /**
     * Is a word protected?
     *
     * @param string $word
     *
     * @return bool
     */
    public static function isProtected(string $word): bool
    {
        return static::isDefault($word) || static::isCustom($word);
    }

    /**
     * Is a word a default protected word?
     *
     * @param string $word
     *
     * @return bool
     */
    public static function isDefault(string $word): bool
    {
        return in_array(strtolower($word), static::$defaultWords);
    }

    /**
     * Is a word a custom protected word?
     *
     * @param string $word
     *
     * @return bool
     */
    public static function isCustom(string $word): bool
    {
        return in_array($word, static::$customWords);
    }

    /**
     * Revert to the default list of protected words
     *
     * @return array
     */
    public static function reset(): array
    {
        static::$customWords = [];

        return static::all();
    }

    /**
     * Supplement the list of protected words
     *
     * @param array|string $words
     *
     * @return array
     */
    public static function supplement($words): array
    {
        if (!is_array($words)) {
            $words = [$words];
        }

        static::$customWords = array_unique(array_merge(
            static::$customWords,
            array_values($words)
        ));

        return static::all();
    }

    /**
     * Get an array of protected words
     *
     * @return array
     */
    public static function all(): array
    {
        return array_unique(array_merge(
            static::$defaultWords,
            static::$customWords
        ));
    }
}
