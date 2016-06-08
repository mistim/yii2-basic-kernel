<?php

use yii\db\Migration;

class m160329_080616_new_table_setting extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `setting` (
              `intSettingID` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `varKey` varchar(50) NOT NULL,
              `varValue` varchar(255) DEFAULT NULL,
              `isActive` tinyint(1) NOT NULL DEFAULT '1',
              PRIMARY KEY (`intSettingID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");

        $this->insert('setting', [
            'varKey'   => 'languageAdminPanel',
            'varValue' => \Yii::$app->getModule('admin')->language,
            'isActive' => 1
        ]);
    }

    public function down()
    {
        return $this->dropTable('setting');
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
