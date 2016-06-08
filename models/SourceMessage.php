<?php

namespace mistim\kernel\models;

use Yii;

/**
 * This is the model class for table "source_message".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $messages
 */
class SourceMessage extends \yii\db\ActiveRecord
{
    public $translations = [];
    public $translation;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('admin', 'ID'),
            'category'    => Yii::t('admin', 'Category'),
            'message'     => Yii::t('admin', 'Key'),
            'translation' => Yii::t('admin', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function prepareTranslation()
    {
        foreach ($this->messages as $item)
        {
            $this->translations[$item->language] = $item->translation;
        }
    }

    /**
     * @return array
     */
    public function addTranslation()
    {
        $langs = Language::getAllActive();
        $data = [];

        foreach ($langs as $lang) {
            $data[$lang->varCode] = $this->translations[$lang->varCode];
        }

        return $data;
    }
}
