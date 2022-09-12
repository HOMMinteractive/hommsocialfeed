<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\elements\db;

use craft\elements\db\ElementQuery;

class SocialFeedQuery extends ElementQuery
{
    /**
     * @var int Social Feed ID
     */
    public $feedId;

    /**
     * @var \DateTime Social Feed Date Created
     */
    public $feedDateCreated;

    /**
     * @var string The URL to the feed
     */
    public $feedUrl;

    /**
     * @var string|null External URL provided from the feed
     */
    public $externalUrl = null;

    /**
     * @var string|null Name of the social media provider
     */
    public $source = null;

    /**
     * @var string|null Source options
     *
     * If the source has checkboxes that customize the type
     * of response you get back they will be included here.
     * E.g. "retweets".
     */
    public $sourceOptions = null;

    /**
     * @var string Feed text or title (as HTML)
     */
    public $message;

    /**
     * @var string Like Count
     */
    public $likeCount = 0;

    /**
     * @var string|null Image URL
     */
    public $image = null;

    /**
     * @var array|null Additional photos URL
     */
    public $additionalPhotos = null;

    /**
     * @var string|null Video URL
     */
    public $video = null;

    /**
     * @var string The Poster's name
     */
    public $posterName = '';

    /**
     * @var bool Hide the media or not
     */
    public $isMediaHidden = false;

    /**
     * Set the Social Feed ID
     *
     * @param int $value
     * @return $this
     */
    public function feedId($value)
    {
        $this->feedId = $value;
        return $this;
    }

    /**
     * Set the Social Feed Date Created
     *
     * @param \DateTime $value
     * @return $this
     */
    public function feedDateCreated($value)
    {
        $this->feedDateCreated = $value;
        return $this;
    }

    /**
     * Set the URL to the feed
     *
     * @param string $value
     * @return $this
     */
    public function feedUrl($value)
    {
        $this->feedUrl = $value;
        return $this;
    }

    /**
     * Set the external URL provided from the feed
     *
     * @param string|null $value
     * @return $this
     */
    public function externalUrl($value = null)
    {
        $this->externalUrl = $value;
        return $this;
    }

    /**
     * Set the name of the social media provider
     *
     * @param string|null $value
     * @return $this
     */
    public function source($value = null)
    {
        $this->source = $value;
        return $this;
    }

    /**
     * Set the source options
     *
     * @param string|null $value
     * @return $this
     *
     * If the source has checkboxes that customize the type
     * of response you get back they will be included here.
     * E.g. "retweets".
     */
    public function sourceOptions($value = null)
    {
        $this->sourceOptions = $value;
        return $this;
    }

    /**
     * Set the feed text or title (as HTML)
     *
     * @param string $value
     * @return $this
     */
    public function message($value)
    {
        $this->message = $value;
        return $this;
    }

    /**
     * Set the Like Count
     *
     * @param int $value
     * @return $this
     */
    public function likeCount($value = 0)
    {
        $this->likeCount = $value;
        return $this;
    }

    /**
     * Set the image URL
     *
     * @param string|null $value
     * @return $this
     */
    public function image($value = null)
    {
        $this->image = $value;
        return $this;
    }

    /**
     * Set the additional photos URLs
     *
     * @param array|null $value
     * @return $this
     */
    public function additionalPhotos($value = null)
    {
        $this->additionalPhotos = $value;
        return $this;
    }

    /**
     * Mark the media as hidden or not
     *
     * @param bool $value
     * @return $this
     */
    public function isMediaHidden($value = false)
    {
        $this->isMediaHidden = $value;
        return $this;
    }

    /**
     * Set the video URL
     *
     * @param string|null $value
     * @return $this
     */
    public function video($value = null)
    {
        $this->video = $value;
        return $this;
    }

    /**
     * Set the poster's name
     *
     * @param string $value
     * @return $this
     */
    public function posterName($value)
    {
        $this->posterName = $value;
        return $this;
    }

    /**
     * Set a custom color
     *
     * @param string|null $value Color handle
     * @return $this
     */
    public function color($value = null)
    {
        $this->color = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function beforePrepare(): bool
    {
        $this->joinElementTable('homm_socialfeeds');

        $this->query->select(
            [
                'homm_socialfeeds.id',
                'homm_socialfeeds.feedId',
                'homm_socialfeeds.feedDateCreated',
                'homm_socialfeeds.feedUrl',
                'homm_socialfeeds.externalUrl',
                'homm_socialfeeds.source',
                'homm_socialfeeds.sourceOptions',
                'homm_socialfeeds.message',
                'homm_socialfeeds.likeCount',
                'homm_socialfeeds.image',
                'homm_socialfeeds.additionalPhotos',
                'homm_socialfeeds.video',
                'homm_socialfeeds.posterName',
                'homm_socialfeeds.isMediaHidden',
                'homm_socialfeeds.color',
                'homm_socialfeeds.dateCreated',
                'homm_socialfeeds.dateUpdated',
                'homm_socialfeeds.uid',
            ]
        );

        return parent::beforePrepare();
    }
}
