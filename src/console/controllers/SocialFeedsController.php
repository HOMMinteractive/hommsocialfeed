<?php
/**
 * HOMMSocialFeed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\console\controllers;

use homm\hommsocialfeed\HOMMSocialFeed;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * SocialFeeds Command
 *
 * @author    Benjamin Ammann
 * @package   HOMMSocialFeed
 * @since     0.0.1
 */
class SocialFeedsController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Fetch and import all social feeds.
     *
     * @return mixed
     */
    public function actionUpdate()
    {
        Console::output('Fetch and import all feeds.');

        $result = HOMMSocialFeed::$plugin->socialFeedService->fetch();

        if ($result !== true) {
            Console::error('Could not correctly update feeds.');
            Console::error(print_r($result, true));
            return ExitCode::UNSPECIFIED_ERROR;
        }

        Console::output('Successfully updated.');
        return ExitCode::OK;
    }
}
