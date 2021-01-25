<?php
/**
 * HOMMSocialFeed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\api;

use homm\hommsocialfeed\HOMMSocialFeed;

/**
 * @author    Benjamin Ammann
 * @package   HOMMSocialFeed
 * @since     0.0.1
 */
abstract class AbstractApiClient extends \GuzzleHttp\Client
{
    public function __construct(array $config = [])
    {
        $config['base_uri'] = HOMMSocialFeed::$plugin->getSettings()->socialFeedBaseUrl;
        parent::__construct($config);
    }

    public function getSocialFeeds(): \Psr\Http\Message\ResponseInterface
    {
        return parent::get($this->getApiPath());
    }

    protected function getApiPath(): string
    {
        $apiPath = HOMMSocialFeed::$plugin->getSettings()->apiPath;

        if (!$apiPath) {
            throw new \Exception('The API path is not provided. Please check your plugin settings.');
        }

        return $apiPath;
    }
}
