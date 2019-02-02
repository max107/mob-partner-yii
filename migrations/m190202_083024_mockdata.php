<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m190202_083024_mockdata
 */
class m190202_083024_mockdata extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('device', [
            'id' => 'i-love-work-at-saturday',
        ]);
        $this->insert('module', [
            'version'    => 1,
            'package'    => 'com.mob.ad',
            'data'       => base64_encode('hello world ad 1'), // Just for example
            'is_active'  => true,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
        ]);
        $this->insert('module', [
            'version'    => 2,
            'package'    => 'com.mob.ad',
            'data'       => base64_encode('hello world ad 2'), // Just for example
            'is_active'  => false,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
        ]);
        $this->insert('module', [
            'version'    => 1,
            'package'    => 'com.mob.proxy',
            'data'       => base64_encode('hello world proxy'), // Just for example
            'is_active'  => false,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
        ]);
        $this->insert('device_module_through', [
            'device_id' => 1,
            'module_id' => 1,
        ]);
        $this->insert('device_module_through', [
            'device_id' => 1,
            'module_id' => 3,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190202_083024_mockdata cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190202_083024_mockdata cannot be reverted.\n";

        return false;
    }
    */
}
