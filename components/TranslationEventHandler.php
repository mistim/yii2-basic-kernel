<?php

namespace mistim\kernel\components;

use mistim\kernel\models\Language;
use mistim\kernel\models\SourceMessage;
use mistim\kernel\models\Message;
use mistim\kernel\modules\setting\models\Setting;
use yii\helpers\ArrayHelper;
use yii\i18n\MissingTranslationEvent;
use Yii;
use yii\db\Query;

/**
 * Class TranslationEventHandler
 * @package mistim\kernel\components
 */
class TranslationEventHandler
{
    public static $autoTranslate = false;

    public static function handleMissingTranslation(MissingTranslationEvent $event)
    {
        $allLanguage = ArrayHelper::map(Language::getAllActive(), 'varCode', 'varName');

        if ($event->category === 'admin') {
            Yii::$app->language = Setting::getValue('languageAdminPanel');
        }

        if (self::checkNeeded($event->category)) {
            $attributes = ['category' => $event->category, 'message' => $event->message];

            $query = (new Query())
                ->select('id, category, message')
                ->from(SourceMessage::tableName())
                ->where('category = :category AND BINARY message = :message');

            $data = $query->createCommand()
                ->bindValue('category', $event->category)
                ->bindValue('message', $event->message)
                ->queryOne();

            if (!$data) {
                $model = new SourceMessage();
                $model->attributes = $attributes;

                if ($model->save()) {
                    $attributes = ['id' => $model->id, 'language' => $event->language];
                    self::saveMessage($attributes, $event);

                    if ($event->category === 'app') {
                        foreach ($allLanguage as $language => $languageName) {
                            $attributes = ['id' => $model->id, 'language' => $language];
                            self::saveMessage($attributes, $event);
                        }
                    }
                }
            } else {
                /** @var Message $model */
                if (($model = Message::findOne(['id' => $data['id'], 'language' => $event->language])) === null) {
                    $attributes = ['id' => $data['id'], 'language' => $event->language];
                    self::saveMessage($attributes, $event);
                }

                if ($event->category === 'app') {
                    foreach ($allLanguage as $language => $languageName) {
                        $attributes = ['id' => $data['id'], 'language' => $language];
                        self::saveMessage($attributes, $event);
                    }
                }
            }

            return $event;
        }
    }

    /**
     * @param $attributes
     * @param MissingTranslationEvent $event
     * @return bool
     */
    protected static function saveMessage($attributes, MissingTranslationEvent $event)
    {
        /** @var Message $message */
        $message = Message::findOne([
            'language' => $attributes['language'],
            'id'       => $attributes['id']
        ]);

        if (!$message) {
            $message = new Message();
        }

        $message->attributes = $attributes;

        if ($event->category === 'app' && $attributes['language'] === Language::getDefaultLanguage()->varCode) {
            $message->translation = $event->message;
        } elseif ($event->category === 'admin') {
            $message->translation = self::$autoTranslate
                ? (new ApiTranslation($message->language))->run($event->message)
                : $event->message;
        }

        return $message->save();
    }

    /**
     * @param $category
     * @return bool
     */
    protected static function checkNeeded($category)
    {
        $allLanguage = ArrayHelper::map(Language::getAllActive(), 'varCode', 'varName');

        if ($category === 'admin' && array_key_exists(Setting::getValue('languageAdminPanel'), $allLanguage)) {
            return true;
        } elseif ($category === 'app' && array_key_exists(Yii::$app->language, $allLanguage)) {
            return true;
        } else {
            return false;
        }
    }
}