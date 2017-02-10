<?php namespace Experience\Entitle\App\ServiceProviders;

use Craft\WebApp;
use Experience\Entitle\App\Helpers\CapitalizationHelper;
use League\Container\ContainerInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Experience\Entitle\App\Utilities\Logger;

class PluginServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = ['CapitalizationHelper', 'Logger'];

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var WebApp
     */
    protected $craft;

    /**
     * Constructor.
     *
     * @param WebApp $craft
     */
    public function __construct(WebApp $craft)
    {
        $this->craft = $craft;
    }

    /**
     * Registers items with the container.
     */
    public function register()
    {
        $this->initializeLogger();
         $this->initializeCapitalizationHelper();
    }

    /**
     * Initialises the logger.
     */
    protected function initializeLogger()
    {
        $this->container->add('Logger', new Logger);
    }

    /**
     * Initialises the capitalisation helper.
     */
    protected function initializeCapitalizationHelper()
    {
        $settings = $this->craft->plugins->getPlugin('entitle')->getSettings();

        $protectedWords = $this->prepProtectedWords(
            $settings->getAttribute('protectedWords'));

        $this->container->add(
            'CapitalizationHelper',
            new CapitalizationHelper($protectedWords)
        );
    }

    /**
     * Converts the given protected words string to an array of words.
     *
     * @param string $string
     *
     * @return string[]
     */
    protected function prepProtectedWords($string)
    {
        return explode(',', $string);
    }
}
