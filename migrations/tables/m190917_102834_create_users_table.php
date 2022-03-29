<?php

use app\common\migration\BaseMigration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m190917_102834_create_users_table extends BaseMigration
{
    public $tableName = '{{%user}}';

    public function safeUp()
    {

        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(11),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'change_password' => $this->boolean(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'user_type' => $this->string(20)->notNull()->comment('User type'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
