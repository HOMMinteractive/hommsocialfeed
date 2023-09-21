<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\services;

use Craft;
use craft\base\Component;
use craft\helpers\StringHelper;
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

        return Craft::$app->elements->saveElement($socialFeed);
    }

    /**
     * Insert new feeds, update existing, delete non existing
     *
     * @return array|true
     */
    public function fetch()
    {
        $client = new JuicerClient();
        $response = $client->getSocialFeeds();
        $posts = json_decode($response->getBody())->posts->items; // TODO: extend the Guzzle ResponseInterface

        $errors = [];
        $socialFeeds = SocialFeed::find()->status(null)->where(['feedId' => array_column($posts, 'id')])->all();
        $feedIds = array_column($socialFeeds, 'feedId');
        foreach ($posts as $post) {
            $socialFeed = new SocialFeed();
            if (in_array($post->id, $feedIds)) {
                $socialFeed = SocialFeed::find()->status(null)->where(['feedId' => $post->id])->one();
            }

            $attributes = [
                'feedId' => $post->id,
                'feedDateCreated' => date('Y-m-d H:i:s', strtotime($post->external_created_at)),
                'feedUrl' => $post->full_url,
                'externalUrl' => $post->external,
                'source' => $post->source->source,
                'sourceOptions' => $post->source->options,
                'message' => StringHelper::encodeMb4($post->message),
                'likeCount' => $post->like_count,
                'image' => $post->image,
                'additionalPhotos' => $post->additional_photos,
                'video' => $post->video ?? null,
                'posterName' => $post->poster_name,
            ];

            if (!$this->update($socialFeed, $attributes)) {
                $errors[$socialFeed->id] = $socialFeed->getErrors();
                Craft::error($errors[$socialFeed->id]);
                continue;
            }
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }
}
