<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190202_083025_create_extras
 */
class m190202_083025_create_extras extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('module', 'extras', Schema::TYPE_JSON);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('module', 'extras');
    }
}
