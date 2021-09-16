<?php
/**
 * HOMM Social Feed plugin for Craft CMS 3.x
 *
 * HOMM Social Feed Adapter for Juicer
 *
 * @link      https://github.com/HOMMinteractive
 * @copyright Copyright (c) 2021 Benjamin Ammann
 */

namespace homm\hommsocialfeed\migrations;

use craft\db\Migration;

/**
 * Install migration.
 */
class Install extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%homm_socialfeeds}}',
            [
                'id' => $this->primaryKey(),
                'feedId' => $this->integer()->unsigned()->notNull(),
                'feedDateCreated' => $this->dateTime()->notNull(),
                'feedUrl' => $this->string(1024)->notNull(),
                'externalUrl' => $this->string(1024),
                'source' => $this->string(),
                'sourceOptions' => $this->string(1024),
                'message' => $this->longText()->notNull(),
                'likeCount' => $this->integer()->unsigned()->notNull()->defaultValue(0),
                'image' => $this->string(1024),
                'additionalPhotos' => $this->text(),
                'video' => $this->string(1024),
                'isMediaHidden' => $this->boolean()->notNull()->defaultValue(false),
                'color' => $this->string(20),
                'dateCreated' => $this->dateTime()->notNull(),
                'dateUpdated' => $this->dateTime()->notNull(),
                'uid' => $this->uid(),
            ]
        );

        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%homm_socialfeeds}}', 'id'),
            '{{%homm_socialfeeds}}',
            'id',
            '{{%elements}}',
            'id',
            'CASCADE',
            null
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTableIfExists('{{%homm_socialfeeds}}');

        return true;
    }
}
