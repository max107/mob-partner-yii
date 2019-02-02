<?php

use yii\db\Migration;

/**
 * Class m190202_082008_initial
 */
class m190202_082008_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('module', [
            'id'         => $this->primaryKey(),
            'version'    => $this->integer()->notNull()->defaultValue(0),
            'is_active'  => $this->boolean()->notNull()->defaultValue(false),
            'package'    => $this->string()->notNull(),
            'data'       => $this->binary(4294967295),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
        $this->createIndex('version_package_uniq', 'module', ['package', 'version'], true);
        $this->createTable('device', [
            'id' => $this->string()->notNull(),
            'PRIMARY KEY(id)',
        ]);
        $this->createTable('device_module_through', [
            'device_id' => $this->integer()->notNull(),
            'module_id' => $this->integer()->notNull(),
            'PRIMARY KEY(device_id, module_id)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('device_module_through');
        $this->dropTable('device');
        $this->dropTable('module');
    }
}
