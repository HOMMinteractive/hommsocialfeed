<?php
/**
 * HOMMSocialFeed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\services;

use craft\base\Component;
use homm\hommsocialfeed\api\JuicerClient;
use homm\hommsocialfeed\elements\SocialFeed;

/**
 * @author    Benjamin Ammann
 * @package   HOMMSocialFeed
 * @since     0.0.1
 */
class SocialFeedService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Update attributes of a specific feed and validate them
     *
     * @return bool|null
     */
    public function update(SocialFeed $socialFeed, $attributes = [])
    {
        if (empty($attributes)) {
            return null;
        }

        foreach ($attributes as $attribute => $value) {
            $socialFeed->{$attribute} = $value;
        }

        if (!$socialFeed->validate()) {
            return false;
        }
        return \Craft::$app->elements->saveElement($socialFeed);
    }

    /**
     * Insert new feeds, update existing, delete non existing
     *
     * @return void
     */
    public function fetch()
    {
        $client = new JuicerClient();
        $response = $client->getSocialFeeds();
        $posts = json_decode($response->getBody())->posts->items; // TODO: extend the Guzzle ResponseInterface

        $errors = [];
        $success = true;
        $socialFeeds = SocialFeed::find()->where(['feedId' => array_column($posts, 'id')])->all();
        foreach ($posts as $post) {
            $socialFeed = new SocialFeed();
            if (in_array($post->id, array_column($socialFeeds, 'feedId'))) {
                $socialFeed = SocialFeed::findOne(['feedId' => $post->id]);
            }

            $socialFeed->feedId = $post->id;
            $socialFeed->feedDateCreated = $post->external_created_at;
            $socialFeed->feedUrl = $post->full_url;
            $socialFeed->externalUrl = $post->external;
            $socialFeed->source = $post->source->source;
            $socialFeed->sourceOptions = $post->source->options;
            $socialFeed->message = $post->message;
            $socialFeed->likeCount = $post->like_count;
            $socialFeed->image = $post->image;
            $socialFeed->video = $post->video ?? null;

            if (!$socialFeed->validate()) {
                \Craft::error($socialFeed->getErrors());
                continue;
            }

            if (!\Craft::$app->elements->saveElement($socialFeed)) {
                $success = false;
            }
        }

        if (!empty($errors)) {
            return $errors;
        }

        return $success;
    }
}
