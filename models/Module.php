<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "module".
 *
 * @property int $id
 * @property int $version
 * @property int $is_active
 * @property string $package
 * @property string $created_at
 * @property string $updated_at
 * @property resource $data
 */
class Module extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package'], 'required'],
            [['version', 'is_active'], 'integer'],
            [['data'], 'string'],
            [['package'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'version'    => 'Version',
            'is_active'  => 'Is Active',
            'package'    => 'Package',
            'data'       => 'Data',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $this->version = self::find()->where([
                'package' => $this->package,
            ])->count();
        }

        if ($this->is_active) {
            self::updateAll(['is_active' => false], [
                'package' => $this->package,
            ]);
        }

        return true;
    }
}
