<?php namespace Craft;

use Twig_Extension;
use Twig_Markup;
use Twig_SimpleFilter;

class EntitleTwigExtension extends Twig_Extension
{
    /**
     * Returns the Twig extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'Entitle';
    }

    /**
     * Returns an associative array of Twig filters provided by the extension.
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            'entitle' => new Twig_SimpleFilter(
                'entitle', [$this, 'entitleFilter'])
        ];
    }

    /**
     * Capitalises the given string.
     *
     * Usage:
     * {{ 'of mice and men'|entitle }}
     *
     * @param string $input The string to parse.
     *
     * @return string
     */
    public function entitleFilter($input)
    {
        return new Twig_Markup($this->capitalize($input), $this->getCharset());
    }

    /**
     * Runs the given input string through the specified parsers.
     *
     * @param string $input
     *
     * @return string
     */
    protected function capitalize($input)
    {
        return craft()->entitle->capitalize($input);
    }

    /**
     * Returns the Twig character set.
     *
     * @return string
     */
    protected function getCharset()
    {
        return craft()->templates->getTwig()->getCharset();
    }
}
