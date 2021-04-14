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
     * @param null $limit If not provided, use the limit from the settings.
     * @return ElementInterface
     */
    public function all($conditions = [], $limit = null): ElementInterface
    {
        return $this->posts($conditions, $limit)->all();
    }

    /**
     * Get the social feeds query
     *
     * @param array $conditions Some additional query conditions.
     * @param null $limit If not provided, use the limit from the settings.
     * @return ElementQueryInterface
     */
    public function posts($conditions = [], $limit = null): ElementQueryInterface
    {
        $firstKey = array_key_first($conditions);
        $query = SocialFeed::find();

        foreach ($conditions as $key => $condition) {
            if ($key == $firstKey) {
                $query = $query->where($condition);
                continue;
            }
            $query = $query->andWhere($condition);
        }

        return $query->limit($limit ?? HOMMSocialFeed::$plugin->getSettings()->numberOfFeeds);
    }
}
