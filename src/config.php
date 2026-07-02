<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

/**
 * HOMMSocialFeed config.php
 *
 * This file exists only as a template for the HOMMSocialFeed settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'hommsocialfeed.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    // Social Feed base URL. Supports environment variables (e.g. '$JUICER_BASE_URL').
    // 'socialFeedBaseUrl' => 'https://www.juicer.io',

    // API path for fetching feeds. Supports environment variables (e.g. '$JUICER_API_PATH').
    // 'apiPath' => '/api/feeds/your-feed-name',

    // Number of posts to fetch per request.
    // 'numberOfFeeds' => 15,

    // Available colors for tagging feed items ('handle' => CSS color value).
    // Note: only the handle is stored per feed item.
    // 'colors' => [
    //     'muted'     => '#F0F0F1',
    //     'highlight' => '#DD1460',
    //     'dark'      => '#313131',
    // ],
];
