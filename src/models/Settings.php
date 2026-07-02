<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\models;

use craft\base\Model;

/**
 * @author    Benjamin Ammann
 * @package   HOMMSocialFeed
 * @since     0.0.1
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string Social Feed base URL. Supports environment variables (e.g. '$JUICER_BASE_URL').
     */
    public $socialFeedBaseUrl = 'https://www.juicer.io';

    /**
     * @var array Possible colors as 'handle' => 'color' (CSS readable)
     *
     * Note: only the handle will be saved in the feeds.
     */
    public $colors = [
        'reset' => null,
        'muted' => '#F0F0F1',
        'highlight' => '#DD1460',
        'dark' => '#313131',
    ];

    /**
     * @var string API path for fetching feeds (e.g. '/api/feeds/company-name'). Supports environment variables (e.g. '$JUICER_API_PATH').
     */
    public $apiPath;

    /**
     * @var int Number of feeds to show by default
     */
    public $numberOfFeeds = 15;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['apiPath', 'numberOfFeeds'], 'required'],
        ];
    }
}
