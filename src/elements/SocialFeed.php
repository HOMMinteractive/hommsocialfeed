<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\elements;

use Craft;
use craft\base\Element;
use craft\elements\actions\SetStatus;
use craft\elements\db\ElementQueryInterface;
use craft\validators\StringValidator;
use craft\web\View;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use homm\hommsocialfeed\assetbundles\hommsocialfeedcp\HOMMSocialFeedCPAsset;
use homm\hommsocialfeed\elements\actions\HideMedia;
use homm\hommsocialfeed\elements\actions\SetColor;
use homm\hommsocialfeed\elements\db\SocialFeedQuery;
use homm\hommsocialfeed\HOMMSocialFeed;

/**
 * Class SocialFeed
 *
 * @author    Benjamin Ammann
 * @package   HOMMSocialFeed
 * @since     0.0.1
 */
class SocialFeed extends Element
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
     * @var bool Hide the image or not
     */
    public $isMediaHidden = false;

    /**
     * @var string|null Color handle
     */
    public $color = null;

    /**
     * @var int|null Pseudo property to count feeds by source
     */
    public $socialfeedsCount = null;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return 'Social Feed';
    }

    /**
     * @inheritdoc
     */
    public static function pluralDisplayName(): string
    {
        return 'Social Feeds';
    }

    /**
     * @inheritdoc
     */
    public static function refHandle()
    {
        return 'socialfeed';
    }

    /**
     * @inheritdoc
     */
    public static function hasStatuses(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    protected static function defineTableAttributes(): array
    {
        return [
            'id' => ['label' => Craft::t('hommsocialfeed', 'ID')],
            'feedId' => ['label' => Craft::t('hommsocialfeed', 'Feed ID')],
            'feedDateCreated' => ['label' => Craft::t('hommsocialfeed', 'Feed Created')],
            'feedUrl' => ['label' => Craft::t('hommsocialfeed', 'Feed URL')],
            'externalUrl' => ['label' => Craft::t('hommsocialfeed', 'External URL')],
            'source' => ['label' => Craft::t('hommsocialfeed', 'Source')],
            'sourceOptions' => ['label' => Craft::t('hommsocialfeed', 'Source Options')],
            'message' => ['label' => Craft::t('hommsocialfeed', 'Message')],
            'likeCount' => ['label' => Craft::t('hommsocialfeed', 'Likes')],
            'image' => ['label' => Craft::t('hommsocialfeed', 'Image')],
            'additionalPhotos' => ['label' => Craft::t('hommsocialfeed', 'Additional photos')],
            'video' => ['label' => Craft::t('hommsocialfeed', 'Video')],
            'isMediaHidden' => ['label' => Craft::t('hommsocialfeed', 'Hide image/video')],
            'color' => ['label' => Craft::t('hommsocialfeed', 'Color')],
            'dateCreated' => ['label' => Craft::t('hommsocialfeed', 'Date Created')],
            'dateUpdated' => ['label' => Craft::t('hommsocialfeed', 'Date Updated')],
            'uid' => ['label' => Craft::t('hommsocialfeed', 'UID')],
        ];
    }

    /**
     * @inheritdoc
     */
    protected static function defineDefaultTableAttributes(string $source): array
    {
        return ['feedDateCreated', 'source', 'message', 'likeCount', 'image', 'video', 'color'];
    }

    /**
     * @inheritdoc
     */
    protected static function defineSources(string $context = null): array
    {
        $sources = [];

        $sources[] = [
            'key' => '*',
            'label' => Craft::t('hommsocialfeed', 'All feeds'),
            'badgeCount' => self::find()->anyStatus()->count(),
            'defaultSort' => ['feedDateCreated', 'desc'],
            'criteria' => [],
        ];

        /** @var SocialFeed<array> $socialFeeds */
        /* TODO: This filter does not work as expected -> implement later
        $socialFeeds = self::find()
            ->select(['homm_socialfeeds.source', 'COUNT(*) as socialfeedsCount'])
            ->groupBy('homm_socialfeeds.source')
            ->all();

        foreach ($socialFeeds as $socialFeed) {
            $sources[] = [
                'key' => strtolower($socialFeed->source),
                'label' => $socialFeed->source,
                'badgeCount' => $socialFeed->socialfeedsCount,
                'defaultSort' => ['feedDateCreated', 'desc'],
                'criteria' => ['source' => $socialFeed->source],
            ];
        }
        */

        return $sources;
    }

    /**
     * @inheritdoc
     *
     * @return SocialFeedQuery The newly created [[SocialFeedQuery]] instance.
     */
    public static function find(): ElementQueryInterface
    {
        return new SocialFeedQuery(static::class);
    }

    /**
     * @inheritdoc
     */
    protected static function defineSearchableAttributes(): array
    {
        return [
            'feedId',
            'feedDateCreated',
            'feedUrl',
            'externalUrl',
            'source',
            'sourceOptions',
            'message',
            'likeCount',
            'image',
            'additionalPhotos',
            'video',
            'color'
        ];
    }

    /**
     * @inheritdoc
     */
    protected static function defineActions(string $source = null): array
    {
        $actions = [];

        $actions[] = SetStatus::class;
        $actions[] = SetColor::class;
        $actions[] = HideMedia::class;

        return $actions;
    }

    /**
     * @inheritdoc
     */
    public function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [['feedId', 'feedDateCreated', 'feedUrl', 'message'], 'required'];
        $rules[] = [['feedId', 'likeCount'], 'number', 'integerOnly' => true];
        $rules[] = [['feedUrl', 'externalUrl', 'source', 'sourceOptions', 'message', 'image', 'video', 'color'], 'trim'];
        $rules[] = [
            ['feedUrl', 'externalUrl', 'source', 'sourceOptions', 'message', 'image', 'video', 'color'],
            StringValidator::class,
            'disallowMb4' => true
        ];
        $rules[] = [['feedUrl', 'externalUrl', 'sourceOptions', 'video'], 'string', 'max' => 1024];
        $rules[] = [['source'], 'string', 'max' => 255];
        $rules[] = [['message'], 'string', 'max' => 60000];
        $rules[] = [['color'], 'string', 'max' => 20];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave(bool $isNew): bool
    {
        if ($this->video) {
            try {
                (new GuzzleClient())->head($this->video);
            } catch (BadResponseException $e) {
                $this->video = null;
            }
        } else {
            $this->video = null;
        }

        if (!$this->image) {
            $this->image = null;
        }

        $this->additionalPhotos = !empty($this->additionalPhotos) ? json_encode($this->additionalPhotos) : null;

        return parent::beforeSave($isNew);
    }

    /**
     * @inheritdoc
     */
    public function afterSave(bool $isNew)
    {
        $attributes = [
            'feedId' => $this->feedId,
            'feedDateCreated' => $this->feedDateCreated,
            'feedUrl' => $this->feedUrl,
            'externalUrl' => $this->externalUrl,
            'source' => $this->source,
            'sourceOptions' => $this->sourceOptions,
            'message' => $this->message,
            'likeCount' => $this->likeCount,
            'image' => $this->image,
            'additionalPhotos' => $this->additionalPhotos,
            'video' => $this->video,
            'isMediaHidden' => $this->isMediaHidden,
            'color' => $this->color,
        ];

        if ($isNew) {
            $attributes = array_merge(['id' => $this->id], $attributes);
            Craft::$app->db->createCommand()
                ->insert('{{%homm_socialfeeds}}', $attributes)
                ->execute();
        } else {
            Craft::$app->db->createCommand()
                ->update('{{%homm_socialfeeds}}', $attributes, ['id' => $this->id])
                ->execute();
        }

        parent::afterSave($isNew);
    }

    /**
     * @inheritdoc
     */
    protected function tableAttributeHtml(string $attribute): string
    {
        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        Craft::$app->view->registerAssetBundle(HOMMSocialFeedCPAsset::class);

        switch ($attribute) {
            case 'source':
                return Craft::$app->formatter->asHtml('<a href="' . $this->feedUrl . '">' . $this->source . '</a>');

            case 'message':
                return Craft::$app->formatter->asHtml($this->message);

            case 'image':
                if (!$this->image) {
                    return '';
                }
                $opacity = $this->isMediaHidden ? 0.5 : 1;
                return Craft::$app->formatter->asImage($this->image, ['style' => "opacity: {$opacity};"]);

            case 'isMediaHidden':
                return Craft::$app->formatter->asBoolean($this->isMediaHidden);

            case 'video':
                if (!$this->video) {
                    return '-';
                }
                return Craft::$app->formatter->asHtml(
                    '<a href="' . $this->video . '">' . Craft::t('hommsocialfeed', 'Watch video') . '</a>'
                );

            case 'color':
                if (!$this->color) {
                    return '';
                }
                $colors = HOMMSocialFeed::$plugin->getSettings()->colors;
                return Craft::$app->formatter->asHtml(
                    '<span
                        class="status"
                        style="background: ' . ($colors[$this->color != 'reset' ? $this->color : 'unset'] ?? 'unset') . ';"
                        title="' . ucfirst($this->color != 'reset' ? $this->color : '') . '"
                    ></span>'
                );
        }

        return parent::tableAttributeHtml($attribute);
    }
}
