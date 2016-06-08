<?php

namespace mistim\kernel\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * @property SourceMessage $sourceMessage
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('admin', 'ID'),
            'language'    => Yii::t('admin', 'Language'),
            'translation' => Yii::t('admin', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceMessage()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }

    /**
     * @param $data
     * @param $language
     * @return mixed
     */
    public static function getTranslate($data, $language)
    {
        foreach ($data->messages as $item)
        {
            if ($item->language === $language)
            {
                return $item->translation;
            }
        }
    }

    /**
     * @param $id
     * @param array $data
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public static function addTranslate($id, array $data)
    {
        $transaction = self::getDb()->beginTransaction();

        try
        {
            foreach ($data as $language => $translation)
            {
                $model = self::findOne(['id' => $id, 'language' => $language]);

                if ($model)
                {
                    $model->translation = $translation;
                    $model->save();
                }
                else
                {
                    $model = new Message();
                    $model->id = $id;
                    $model->language = $language;
                    $model->translation = $translation;
                    $model->save();
                }
            }

            $transaction->commit();
        }
        catch(\Exception $e)
        {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }
}
