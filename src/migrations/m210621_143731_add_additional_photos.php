<?php
/**
 * HOMMSocialFeed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\migrations;

use craft\db\Migration;

/**
 * m210621_143731_add_additional_photos migration.
 */
class m210621_143731_add_additional_photos extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%homm_socialfeeds}}', 'additionalPhotos', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%homm_socialfeeds}}', 'additionalPhotos');
    }
}
