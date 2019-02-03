<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190202_083025_create_extras
 */
class m190202_083026_fix_blob extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('module', 'data', 'LONGBLOB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
