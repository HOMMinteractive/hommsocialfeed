<?php

namespace homm\hommsocialfeed\migrations;

use Craft;
use craft\db\Migration;

/**
 * m220912_113843_add_poster_name migration.
 */
class m220912_113843_add_poster_name extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%homm_socialfeeds}}', 'posterName', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%homm_socialfeeds}}', 'posterName');
    }
}
