<?php

use yii\db\Migration;

class m160606_134421_new_table_language extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `language` (
                `intLanguageID`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID' ,
                `varCode`  char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Code' ,
                `varName`  varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Name' ,
                `isDefault`  tinyint(1) NULL DEFAULT 0 COMMENT 'Is default' ,
                `isActive`  tinyint(1) NULL DEFAULT 1 COMMENT 'Is active' ,
                PRIMARY KEY (`intLanguageID`)
            )
            ENGINE=InnoDB
            DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
            ROW_FORMAT=COMPACT;
        ");

        $this->insert('admin', [
            'intLanguageID' => 1,
            'varCode'       => 'en',
            'varName'       => 'English',
            'isDefault'     => 1,
            'isActive'      => 1,
        ]);
    }

    public function down()
    {
        return $this->dropTable('language');
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
