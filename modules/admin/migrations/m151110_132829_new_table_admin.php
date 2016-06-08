    <?php

use yii\db\Schema;
use yii\db\Migration;

class m151110_132829_new_table_admin extends Migration
{
    public function up()
    {
        $this->createTable('admin', [
            'intAdminID'    => $this->primaryKey(),
            'varName'       => $this->string(32)->notNull(),
            'varEmail'      => $this->string(64)->notNull(),
            'varPassword'   => $this->string(64)->notNull(),
            'intStatus'     => $this->boolean()->notNull(), // == tinyint(1)
            'dateCreated'   => $this->dateTime()->notNull(),
            'dateLastEnter' => $this->dateTime(),
        ]);

        $this->insert('admin', [
            'intAdminID'  => 1,
            'varName'     => 'admin',
            'varEmail'    => 'admin@miritec.com',
            'varPassword' => '$2y$13$o/xR6EtWj.qLiJgwLlMuNOcQfjfi509/AbVCnKJ3FCR3lrsWQ2D62', //admin@miritec.com1
            'intStatus'   => '1',
            'dateCreated' => Yii::$app->formatter->asDate('now', 'yyyy-MM-dd H:i:s'),
        ]);
    }

    public function down()
    {
        $this->dropTable('admin');
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
