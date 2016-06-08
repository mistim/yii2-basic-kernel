<?php
namespace mistim\kernel\components;

use Yii;
use yii\helpers\Json;

/**
 * Class ApiTranslation
 * @package mistim\kernel\components
 */
class ApiTranslation
{
    protected $params;

    public function __construct($language = 'ru')
    {
        $this->params = Yii::$app->params['translation'];
        $this->params['lang'] .= $language;
    }

    /**
     * @param $text
     * @return bool
     */
    public function run($text)
    {
        // инициализация сеанса
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl($text));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        //проверка ошибок
        if(curl_errno($ch))
        {
            return null;
            //echo 'Curl error: '.curl_errno($ch).' - '.curl_error($ch); exit;
            // перенаправление на страницу с ошибкой!
        }
        // завершение сеанса и освобождение ресурсов
        curl_close($ch);

        $data = Json::decode($result);

        //print_r($data); exit;
        return $data['text'][0];
    }

    /**
     * @param $text
     * @return string
     */
    protected function getUrl($text)
    {
        return $this->params['url'] . '?' . http_build_query([
            'key'    => $this->params['api_key'],
            'text'   => $text,
            'lang'   => $this->params['lang'],
            'format' => $this->params['format'],
        ]);
    }
}