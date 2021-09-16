<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\assetbundles\hommsocialfeedcp;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Benjamin Ammann
 * @package   HOMMSocialFeed
 * @since     0.0.1
 */
class HOMMSocialFeedCPAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@homm/hommsocialfeed/assetbundles/hommsocialfeedcp/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/HOMMSocialFeedCP.js',
        ];

        $this->css = [
            'css/HOMMSocialFeedCP.css',
        ];

        parent::init();
    }
}
