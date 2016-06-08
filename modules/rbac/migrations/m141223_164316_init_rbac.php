<?php

use yii\db\Schema;
use yii\db\Migration;

class m141223_164316_init_rbac extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%auth_rule}}', [
            'name'       => Schema::TYPE_STRING . '(64) NOT NULL',
            'data'       => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->createTable('{{%auth_item}}', [
            'name'        => Schema::TYPE_STRING . '(64) NOT NULL',
            'type'        => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'rule_name'   => Schema::TYPE_STRING . '(64)',
            'data'        => Schema::TYPE_TEXT,
            'created_at'  => Schema::TYPE_INTEGER,
            'updated_at'  => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . '{{%auth_rule}}' . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);
        $this->createIndex('idx-auth_item-type', '{{%auth_item}}', 'type');

        $this->createTable('{{%auth_item_child}}', [
            'parent' => Schema::TYPE_STRING . '(64) NOT NULL',
            'child'  => Schema::TYPE_STRING . '(64) NOT NULL',
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . '{{%auth_item}}' . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES ' . '{{%auth_item}}' . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%auth_assignment}}', [
            'item_name'  => Schema::TYPE_STRING . '(64) NOT NULL',
            'user_id'    => Schema::TYPE_STRING . '(64) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . '{{%auth_item}}' . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->addAdministrator();
    }

    protected function addAdministrator()
    {
        $this->insert('auth_item', [
            'name'        => 'Administrator',
            'type'        => '1',
            'description' => 'Супер-пользователь, доступ ко всему, создание пользователей и назначение ролей',
            'rule_name'   => null,
            'data'        => null,
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $this->insert('auth_item', [
            'name'        => 'Guest',
            'type'        => '1',
            'description' => 'Неавторизованный пользователь',
            'rule_name'   => null,
            'data'        => null,
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $this->insert('auth_item', [
            'name'        => 'Admin area full',
            'type'        => '2',
            'description' => 'Полный доступ в админку',
            'rule_name'   => null,
            'data'        => null,
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $this->insert('auth_item', [
            'name'        => 'Login to admin area',
            'type'        => '2',
            'description' => 'Авторизация в админ-панели',
            'rule_name'   => null,
            'data'        => null,
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $this->insert('auth_item', [
            'name'        => 'Logout fron admin area',
            'type'        => '2',
            'description' => 'Выход из админ-панели',
            'rule_name'   => null,
            'data'        => null,
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $this->insert('auth_item', [
            'name'        => '/admin/*',
            'type'        => '2',
            'description' => null,
            'rule_name'   => null,
            'data'        => null,
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $this->insert('auth_item', [
            'name'        => '/admin/rbac/*',
            'type'        => '2',
            'description' => null,
            'rule_name'   => null,
            'data'        => null,
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $this->insert('auth_item', [
            'name'        => '/admin/main/login',
            'type'        => '2',
            'description' => null,
            'rule_name'   => null,
            'data'        => null,
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $this->insert('auth_item', [
            'name'        => '/admin/main/logout',
            'type'        => '2',
            'description' => null,
            'rule_name'   => null,
            'data'        => null,
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);

        $this->insert('auth_assignment', [
            'item_name'  => 'Administrator',
            'user_id'    => 1,
            'created_at' => time(),
        ]);

        $this->insert('auth_item_child', [
            'parent' => 'Admin area full',
            'child' => '/admin/*',
        ]);

        $this->insert('auth_item_child', [
            'parent' => 'Admin area full',
            'child' => '/admin/rbac/*',
        ]);

        $this->insert('auth_item_child', [
            'parent' => 'Login to admin area',
            'child' => '/admin/main/login',
        ]);

        $this->insert('auth_item_child', [
            'parent' => 'Logout fron admin area',
            'child' => '/admin/main/logout',
        ]);

        $this->insert('auth_item_child', [
            'parent' => 'Administrator',
            'child' => 'Admin area full',
        ]);

        $this->insert('auth_item_child', [
            'parent' => 'Guest',
            'child' => 'Login to admin area',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%auth_item_child}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_rule}}');
    }
}
