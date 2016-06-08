<?php

namespace mistim\modules\setting\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use mistim\modules\setting\models\Setting;

/**
 * SettingSearch represents the model behind the search form about `mistim\models\Setting`.
 */
class SettingSearch extends Setting
{
    public $parameterName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intSettingID', 'isActive'], 'integer'],
            [['varKey', 'varValue', 'parameterName'], 'safe'],
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
        $query = Setting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'intSettingID' => $this->intSettingID,
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'varKey', $this->varKey])
            ->andFilterWhere(['like', 'varValue', $this->varValue]);

        return $dataProvider;
    }
}
