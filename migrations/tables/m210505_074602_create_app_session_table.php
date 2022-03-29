<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%app_session}}`.
 */
class m210505_074602_create_app_session_table extends \app\common\migration\BaseMigration
{
    public $tableName = '{{%app_session}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable($this->tableName, [
            'id' => $this->char(80),
            'user_id' => $this->bigInteger(),
            'username' => $this->string(20),
            'ip' => $this->string(50),
            'expire' => $this->integer(11),
            'data' => $this->text(),
        ], $this->tableOptions);


        $this->addPrimaryKey('pk-session-id', $this->tableName, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('pk-session-id', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
