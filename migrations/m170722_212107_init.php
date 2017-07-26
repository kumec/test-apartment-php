<?php

use yii\db\Schema;
use yii\db\Migration;

class m170722_212107_init extends Migration
{
    public function safeUp()
    {

        $this->createTable(
            '{{%apartment}}',
            [
                'id' => Schema::TYPE_PK,

                'count_rooms' => Schema::TYPE_SMALLINT . '(2) NOT NULL',
                'count_bathrooms' => Schema::TYPE_SMALLINT . '(2) NOT NULL',
                'square' => Schema::TYPE_SMALLINT . '(4) NOT NULL',
                'has_parking' => Schema::TYPE_BOOLEAN . ' NOT NULL',
                'comment' => Schema::TYPE_TEXT,

                'unit' => Schema::TYPE_STRING . '(10)',
                'building' => Schema::TYPE_STRING . '(10) NOT NULL',
                'street' => Schema::TYPE_STRING . '(50) NOT NULL',
                'city' => Schema::TYPE_STRING . '(50) NOT NULL',
                'region' => Schema::TYPE_STRING . '(50) NOT NULL',
                'country' => Schema::TYPE_STRING . '(50) NOT NULL',
                'zip_code' => Schema::TYPE_STRING . '(6) NOT NULL',

                'access_token' => Schema::TYPE_STRING . '(32) NOT NULL',
                'owner_email' => Schema::TYPE_STRING . '(255) NOT NULL',
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%apartment}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170722_212107_init cannot be reverted.\n";

        return false;
    }
    */
}
