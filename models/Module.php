<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property int $version
 * @property int $is_active
 * @property string $package
 * @property string $extras
 * @property string $created_at
 * @property string $updated_at
 * @property UploadedFile $data
 */
class Module extends ActiveRecord
{
    /**
     * @var null|UploadedFile
     */
    public $uploadedFile = null;
    /**
     * @var null|string
     */
    public $extrasStr = null;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
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
            [['uploadedFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jar, txt, jpeg, jpg, png'],
            [['data', 'extrasStr'], 'string'],
            [['extras', 'extrasStr'], 'safe'],
            [['package'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'version' => 'Version',
            'is_active' => 'Is Active',
            'package' => 'Package',
            'data' => 'Data',
            'extras' => 'Extras',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        $file = UploadedFile::getInstance($this, 'uploadedFile');
        if (!is_null($file)) {
            $this->data = file_get_contents($file->tempName);
        }

        if ($insert) {
            $this->version = self::find()
                ->where(['package' => $this->package])
                ->count();
        }

        if ($this->is_active) {
            self::updateAll(
                ['is_active' => false],
                ['package' => $this->package]
            );
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        $this->extrasStr = empty($this->extras) ? '[]' : Json::encode($this->extras);
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete()
    {
        if ($this->is_active) {
            $packageVersions = self::find()->where([
                'package' => $this->package,
            ])->count();

            if ($packageVersions > 0) {
                /** @var Module|null $latestVersion */
                $latestVersion = self::find()
                    ->where(['package' => $this->package])
                    ->andWhere(['<>', 'id', $this->id])
                    ->orderBy(['version' => SORT_DESC])
                    ->one();

                if ($latestVersion) {
                    self::updateAll(['is_active' => true], ['id' => $latestVersion->id]);
                }
            }
        }

        return true;
    }
}
