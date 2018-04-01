<?php

namespace experience\entitle;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use experience\entitle\models\Settings;
use experience\entitle\services\Entitle as EntitleService;
use experience\entitle\web\twig\Extension;
use yii\base\Event;

class Entitle extends Plugin
{
    /**
     * @inheritdoc
     */
    public $hasCpSettings = true;

    /**
     * Initialise the plugin
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->registerServices();
        $this->registerTemplateVariables();
        $this->registerTwigExtensions();
    }

    /**
     * Register the plugin services
     *
     * @throws \yii\base\InvalidConfigException
     */
    protected function registerServices()
    {
        $this->set('entitle', function () {
            $protected = explode(',', $this->getSettings()->protectedWords);

            return new EntitleService($protected);
        });
    }

    /**
     * Register the plugin template variables
     */
    protected function registerTemplateVariables()
    {
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $event->sender->set('entitle', $this->get('entitle'));
            }
        );
    }

    /**
     * Register the plugin Twig extensions
     */
    protected function registerTwigExtensions()
    {
        if (Craft::$app->request->getIsSiteRequest()) {
            Craft::$app->view->registerTwigExtension(new Extension);
        }
    }

    /**
     * Create a new settings model instance
     *
     * @return Settings
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings;
    }

    /**
     * Render the settings template
     *
     * @return null|string
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    protected function settingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('entitle/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
