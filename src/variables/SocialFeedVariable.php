<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\variables;

use craft\base\ElementInterface;
use craft\elements\db\ElementQueryInterface;
use homm\hommsocialfeed\elements\SocialFeed;
use homm\hommsocialfeed\HOMMSocialFeed;

class SocialFeedVariable
{
    /**
     * Get the resulting posts.
     *
     * This method is deprecated and will be removed in the next release.
     * Use [[SocialFeedVariable::posts()]] instead.
     *
     * @param array $conditions Some additional query conditions.
     * @param ?int $limit If not provided, use the limit from the settings.
     * @param ?array $orderBy If not provided, order by the feed date created.
     * @return array<ElementInterface>
     */
    public function all($conditions = [], $limit = null, $orderBy = ['homm_socialfeeds.feedDateCreated' => SORT_DESC]): array
    {
        return $this->posts($conditions, $limit, $orderBy)->all();
    }

    /**
     * Get the social feeds query
     *
     * @param array $conditions Some additional query conditions.
     * @param ?int $limit If not provided, use the limit from the settings.
     * @param ?array $orderBy If not provided, order by the feed date created.
     * @return ElementQueryInterface
     */
    public function posts($conditions = [], $limit = null, $orderBy = ['homm_socialfeeds.feedDateCreated' => SORT_DESC]): ElementQueryInterface
    {
        $firstKey = array_key_first($conditions);
        $query = SocialFeed::find();
        $limit = $limit ?? HOMMSocialFeed::$plugin->getSettings()->numberOfFeeds;

        foreach ($conditions as $key => $condition) {
            if ($key == $firstKey) {
                $query = $query->where($condition);
                continue;
            }
            $query = $query->andWhere($condition);
        }

        $query = $query->limit($limit);

        if ($orderBy !== null) {
            $query = $query->orderBy($orderBy);
        }

        return $query;
    }
}
