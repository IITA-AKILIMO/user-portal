<?php
/**
 * Created by PhpStorm.
 * User: MAS
 * Date: 3/7/2019
 * Time: 10:03 PM
 */

namespace app\common\migration;

use Yii;

/**
 * Class BaseMigration
 * @package app\common\migration
 *
 * @property string $tableName
 * @property array $tableOptions
 * @property array $excludedTables
 * @property-read array|string[] $tables
 * @property-read array $fullTables
 * @property string $filePath
 */
class BaseMigration extends \yii\db\Migration
{
    public $tableOptions;

    public $tableName;

    public $filePath;

    public $excludedTables = [
        'migration', 'migration_functions', 'migration_view', 'users', 'user', 'user_type', 'authorization_codes', 'access_tokens',
        'audit_trail', 'app_cache', 'app_session', 'auth_item', 'auth_assignment', 'auth_item_child', 'auth_rule'
    ];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->filePath = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;

        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }

    /**
     * @return array|string[]
     */
    public function getTables()
    {
        $cleanedTables = [];
        $connection = Yii::$app->db;
        $dbSchema = $connection->schema;
        if ($this->db->driverName === 'mysql') {
            $tables = $this->getFullTables();
        } else {
            $tables = $dbSchema->getTableNames();
        }

        foreach ($tables as $tableName) {
            $noPrefix = str_replace($connection->tablePrefix, '', $tableName);
            if (!in_array($noPrefix, $this->excludedTables)) { //dont add the migration tracking table
                $cleanedTables[] = "{{%{$noPrefix}}}";
            }
        }
        return $cleanedTables;
    }


    protected function getFullTables()
    {
        $schemaTables = [];
        $sql = <<<SQL
SHOW FULL TABLES WHERE TABLE_TYPE LIKE 'BASE TABLE'
SQL;

        $data = $this->db->createCommand($sql)->queryColumn();
        foreach ($data as $key => $tableName) {
            $schemaTables[] = $tableName;
        }
        return $schemaTables;
    }
}
