<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed;

use Craft;
use craft\base\Plugin;
use craft\console\Application as ConsoleApplication;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\services\Elements;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use homm\hommsocialfeed\elements\SocialFeed;
use homm\hommsocialfeed\models\Settings;
use homm\hommsocialfeed\services\SocialFeedService;
use homm\hommsocialfeed\variables\SocialFeedVariable;
use yii\base\Event;

/**
 * Class HOMMSocialFeed
 *
 * @author    Benjamin Ammann
 * @package   HOMMSocialFeed
 * @since     0.0.1
 *
 * @property  SocialFeedService $socialFeedService
 */
class HOMMSocialFeed extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var HOMMSocialFeed
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public string $schemaVersion = '2.1.1';

    /**
     * @var bool
     */
    public bool $hasCpSettings = true;

    /**
     * @var bool
     */
    public bool $hasCpSection = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'socialFeedService' => SocialFeedService::class,
        ]);

        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'homm\hommsocialfeed\console\controllers';
        }

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['hommsocialfeed/update'] = 'hommsocialfeed/social-feeds/update';
            }
        );

        Event::on(
            Elements::class,
            Elements::EVENT_REGISTER_ELEMENT_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = SocialFeed::class;
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('socialFeed', SocialFeedVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'hommsocialfeed',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    public function getCpNavItem(): ?array
    {
        $item = parent::getCpNavItem();
        $item['label'] = Craft::t('hommsocialfeed', 'Social Feed');
        return $item;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?\craft\base\Model
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate(
            'hommsocialfeed/settings',
            ['settings' => $this->getSettings()]
        );
    }
}
