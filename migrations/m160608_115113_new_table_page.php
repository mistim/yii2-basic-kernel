<?php

use yii\db\Migration;

class m160608_115113_new_table_page extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `page` (
                `intPageID`  int UNSIGNED NOT NULL AUTO_INCREMENT ,
                `varTitle`  varchar(255) NOT NULL ,
                `varTeaser`  varchar(255) NULL ,
                `varText`  text NOT NULL ,
                `isActive`  tinyint(1) NULL DEFAULT 1 ,
                PRIMARY KEY (`intPageID`)
            );
        ");
    }

    public function down()
    {
        $this->dropTable('page');
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
