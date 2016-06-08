<?php

use yii\db\Schema;
use yii\db\Migration;

class m151109_095105_new_table_source_message extends Migration
{
    public function up()
    {
        $this->createTable('source_message', [
            'id'       => $this->primaryKey(),
            'category' => $this->string(32)->notNull(),
            'message'  => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%source_message}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
