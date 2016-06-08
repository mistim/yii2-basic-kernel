<?php

namespace mistim\models\search;

use mistim\modules\setting\models\Setting;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use mistim\models\Message;

/**
 * Class MessageSearch
 * @package mistim\models\search
 */
class MessageSearch extends Message
{
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['language', 'translation', 'sourceMessage.message', 'sourceMessage.category'], 'safe'],
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['sourceMessage.message', 'sourceMessage.category']);
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
        $query = Message::find();

		$query->joinWith('sourceMessage');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

		$dataProvider->sort->attributes['sourceMessage.message'] = [
			'asc' => ['source_message.message' => SORT_ASC],
			'desc' => ['source_message.message' => SORT_DESC],
		];

		$dataProvider->sort->attributes['sourceMessage.category'] = [
			'asc' => ['source_message.category' => SORT_ASC],
			'desc' => ['source_message.category' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'source_message.category' => 'admin'
        ]);

        $query->andFilterWhere(['like', 'language', Setting::getValue('languageAdminPanel')])
            ->andFilterWhere(['like', 'translation', $this->translation])
            ->andFilterWhere(['like', 'source_message.message', $this->getAttribute('sourceMessage.message')])
			->andFilterWhere(['like', 'source_message.category',  $this->getAttribute('sourceMessage.category')]);

        return $dataProvider;
    }
}
