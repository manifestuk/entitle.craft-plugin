<?php

namespace experience\entitle\web\twig;

use Craft;
use experience\entitle\Entitle;
use Twig_Extension;
use Twig_Markup;
use Twig_SimpleFilter;

class Extension extends Twig_Extension
{
    /**
     * @var Entitle
     */
    protected static $plugin;

    /**
     * Initialise the extension
     */
    public function __construct()
    {
        if (is_null(static::$plugin)) {
            static::$plugin = Entitle::getInstance();
        }
    }

    /**
     * The Twig filters provided by this extension
     *
     * @return array
     */
    public function getFilters(): array
    {
        return [
            'entitle' => new Twig_SimpleFilter(
                'entitle', [$this, 'entitleFilter'])
        ];
    }

    /**
     * Capitalise a string
     *
     * Usage:
     * {{ 'of mice and men'|entitle }}
     *
     * @param string $input The string to parse.
     *
     * @return string
     */
    public function entitleFilter(string $input): string
    {
        return new Twig_Markup(
            $this->capitalize($input),
            $this->getTwigCharset()
        );
    }

    /**
     * Capitalise a string
     *
     * @param string $input
     *
     * @return string
     */
    protected function capitalize(string $input): string
    {
        return static::$plugin->entitle->capitalize($input);
    }

    /**
     * Return the Twig character set
     *
     * @return string
     */
    protected function getTwigCharset(): string
    {
        return Craft::$app->view->getTwig()->getCharset();
    }
}
