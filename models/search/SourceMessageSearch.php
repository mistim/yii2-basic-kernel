<?php

namespace mistim\models\search;

use mistim\models\Language;
use mistim\models\SourceMessage;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SourceMessageSearch
 * @package mistim\models\search
 */
class SourceMessageSearch extends SourceMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['message', 'category', 'translation'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SourceMessage::find()->groupBy('source_message.id');

        $query->joinWith('messages');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'       => $this->id,
            'category' => 'app'
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        $langs = Language::getAllActive();

        foreach ($langs as $lang) {
            $query->andFilterWhere(['like', 'translation', $this->translations[$lang->varCode]]);
        }

        return $dataProvider;
    }
}
