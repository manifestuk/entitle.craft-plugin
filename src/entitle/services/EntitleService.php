<?php namespace Craft;

use Experience\Entitle\App\Helpers\CapitalizationHelper;

class EntitleService extends BaseApplicationComponent
{
    /**
     * @var CapitalizationHelper
     */
    protected $helper;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->helper = EntitlePlugin::$container->get('CapitalizationHelper');
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
        return $this->helper->capitalize($string);
    }
}
