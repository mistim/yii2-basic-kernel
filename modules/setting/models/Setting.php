<?php

namespace mistim\modules\setting\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $intSettingID
 * @property string $varKey
 * @property string $varValue
 * @property integer $isActive
 */
class Setting extends \yii\db\ActiveRecord
{
    const CACHE_KAY = 'modelSetting_';
    const CACHE_DURATION = 0; // 0 means never expire.
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['varKey'], 'required'],
            [['isActive'], 'integer'],
            [['varKey'], 'string', 'max' => 50],
            [['varValue'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intSettingID' => Yii::t('app', 'ID'),
            'varKey'       => Yii::t('app', 'Key'),
            'varValue'     => Yii::t('app', 'Value'),
            'isActive'     => Yii::t('app', 'Is active'),
        ];
    }

    /**
     * @param $key
     * @return string
     */
    public static function getValue($key)
    {
        $keyCache = self::CACHE_KAY . $key;
        $data = Yii::$app->cache->get($keyCache);

        if (!$data) {
            $setting = self::findOne([
                'varKey'   => $key,
                'isActive' => Setting::STATUS_ACTIVE
            ]);
            Yii::$app->cache->set($keyCache, $data, self::CACHE_DURATION);
        }

		return (isset($setting) && isset($setting->varValue)) ? $setting->varValue : '';
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if (!$this->isNewRecord)
            {
                if ($this->varKey === 'extensionUploadFile')
                {
                    $this->varValue = strtolower($this->varValue);
                }
            }

            return true;
        }
        else
        {
            return false;
        }
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
