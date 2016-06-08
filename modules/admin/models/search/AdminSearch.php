<?php

namespace mistim\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use mistim\modules\admin\models\AdminAuth;

/**
 * AdminSearch represents the model behind the search form about `common\models\Admin`.
 */
class AdminSearch extends AdminAuth
{
    /**
     * @var string role
     */
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intAdminID'], 'integer'],
            [['varName', 'varEmail', 'varPassword', 'dateCreated', 'dateLastEnter', 'role'], 'safe'],
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
        $query = AdminAuth::find();

        $query->joinWith('roles');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['role'] = [
            'asc'  => ['auth_assignment.item_name' => SORT_ASC],
            'desc' => ['auth_assignment.item_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'intAdminID' => $this->intAdminID,
            'intStatus'  => $this->intStatus,
        ]);

        $query->andFilterWhere(['like', 'varName', $this->varName])
            ->andFilterWhere(['like', 'varEmail', $this->varEmail])
            ->andFilterWhere(['like', 'dateCreated', $this->dateCreated])
            ->andFilterWhere(['like', 'dateLastEnter', $this->dateLastEnter])
            ->andFilterWhere(['like', 'auth_assignment.item_name', $this->role]);;

        return $dataProvider;
    }
}
