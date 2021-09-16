<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\assetbundles\settings;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Benjamin Ammann
 * @package   HOMMSocialFeed
 * @since     0.0.1
 */
class SettingsAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@homm/hommsocialfeed/assetbundles/settings/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Settings.js',
        ];

        $this->css = [
            'css/Settings.css',
        ];

        parent::init();
    }
}
