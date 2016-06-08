<?php

use yii\db\Schema;
use yii\db\Migration;

class m151109_095129_new_table_message extends Migration
{
    public function up()
    {
        $this->createTable('message', [
            'id'          => $this->integer(),
            'language'    => $this->string(16)->notNull(),
            'translation' => $this->text(),
            'PRIMARY KEY (id, language)'
        ]);

        $this->createIndex('message_source_message', '{{%message}}', ['id', 'language']);
        $this->addForeignKey('fk_message_source_message', '{{%message}}', ['id'], '{{%source_message}}', ['id'], 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%message}}');
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
