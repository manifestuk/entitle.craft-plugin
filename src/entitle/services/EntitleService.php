<?php namespace Craft;

use Experience\Entitle\App\Helpers\CapitalizationHelper;
use Experience\Entitle\App\Utilities\Logger;

class EntitleService extends BaseApplicationComponent
{
    /**
     * @var CapitalizationHelper
     */
    protected $helper;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->helper = EntitlePlugin::$container->get('CapitalizationHelper');
        $this->logger = EntitlePlugin::$container->get('Logger');
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
        try {
            return $this->helper->capitalize($string);
        } catch (\Exception $e) {
            $this->logger->logError($e->getMessage());
            return $string;
        }
    }
}
