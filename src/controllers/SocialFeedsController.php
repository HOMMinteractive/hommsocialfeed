<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\controllers;

use craft\helpers\UrlHelper;
use craft\web\Controller;
use homm\hommsocialfeed\HOMMSocialFeed;

/**
 * @author    Benjamin Ammann
 * @package   HOMMSocialFeed
 * @since     0.0.1
 */
class SocialFeedsController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionUpdate()
    {
        \Craft::$app->session->setNotice(\Craft::t('hommsocialfeed', 'Successfully updated.'));
        if (!HOMMSocialFeed::$plugin->socialFeedService->fetch()) {
            \Craft::$app->session->setError(\Craft::t('hommsocialfeed', 'Could not update.'));
        }

        return $this->redirect(UrlHelper::cpUrl('settings/plugins/hommsocialfeed'));
    }
}
