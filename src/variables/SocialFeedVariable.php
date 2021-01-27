<?php
/**
 * HOMMSocialFeed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\variables;

use homm\hommsocialfeed\HOMMSocialFeed;

class SocialFeedVariable
{
    public function all($conditions = [])
    {
        return HOMMSocialFeed::$plugin->socialFeedService->get($conditions);
    }
}
