<?php

namespace mistim\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property string $intLanguageID
 * @property string $varCode
 * @property string $varName
 * @property integer $isDefault
 * @property integer $isActive
 */
class Language extends \yii\db\ActiveRecord
{
    const CACHE_KAY = 'modelLanguage_';
    const CACHE_DURATION = 0; // 0 means never expire.
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['varCode', 'varName'], 'required'],
            [['isDefault', 'isActive'], 'integer'],
            [['varCode'], 'string', 'max' => 2],
            [['varName'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intLanguageID' => Yii::t('admin', 'ID'),
            'varCode'       => Yii::t('admin', 'Code'),
            'varName'       => Yii::t('admin', 'Name'),
            'isDefault'     => Yii::t('admin', 'Is default'),
            'isActive'      => Yii::t('admin', 'Is active'),
        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->clearCache('all');
        $this->clearCache('default');
    }

    /**
     * @return mixed|static[]
     */
    public static function getAllActive()
    {
        $keyCache = self::CACHE_KAY . 'all';
        $data = Yii::$app->cache->get($keyCache);

        if (!$data) {
            $data = self::findAll(['isActive' => self::STATUS_ACTIVE]);
            Yii::$app->cache->set($keyCache, $data, self::CACHE_DURATION);
        }

        return $data;
    }

    /**
     * @return mixed|null|static
     */
    public static function getDefaultLanguage()
    {
        $keyCache = self::CACHE_KAY . 'default';
        $data = Yii::$app->cache->get($keyCache);

        if (!$data) {
            $data = self::findOne(['isActive' => self::STATUS_ACTIVE]);
            Yii::$app->cache->set($keyCache, $data, self::CACHE_DURATION);
        }

        return $data;
    }

    /**
     * @param string|integer $subKey
     * @return bool
     *
     * delete all: $subKey = "all"
     * delete default: $subKey = "default"
     * delete one: $subKey = $model->getPrimaryKey
     */
    public static function clearCache($subKey)
    {
        $keyCache = self::CACHE_KAY . $subKey;
        return Yii::$app->cache->delete($keyCache);
    }
}
