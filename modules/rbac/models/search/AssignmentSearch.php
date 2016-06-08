<?php

namespace mistim\modules\rbac\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;
use yii\rbac\Role;

/**
 * Class AssignmentSearch
 * @package mistim\modules\rbac\models\search
 */
class AssignmentSearch extends Model
{
    /**
     * @var string role
     */
    public $role;

    /**
     * @var integer id
     */
    public $id;

    /**
     * @var string username
     */
    public $username;

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'username', 'role'], 'safe'],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given an attribute
     * `firstName`, we can declare a label `First Name` which is more user-friendly and can
     * be displayed to end users.
     *
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'role'     => Yii::t('app', 'Role')
        ];
    }

    /**
     * Search
     * @param array $params
     * @param \yii\db\ActiveRecord $class
     * @param string $userFieldID
     * @param string $usernameField
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params, $class, $userFieldID, $usernameField)
    {
        $query = $class::find();
        $query->joinWith('roles');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['id'] = [
            'asc' => ['user.' . $userFieldID => SORT_ASC],
            'desc' => ['user.' . $userFieldID => SORT_DESC],
        ];

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.' . $usernameField => SORT_ASC],
            'desc' => ['user.' . $usernameField => SORT_DESC],
        ];

        $dataProvider->sort->attributes['role'] = [
            'asc' => ['auth_assignment.item_name' => SORT_ASC],
            'desc' => ['auth_assignment.item_name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([$userFieldID => $this->id]);
        $query->andFilterWhere(['like', 'auth_assignment.item_name', $this->role]);
        $query->andFilterWhere(['like', $usernameField, $this->username]);

        return $dataProvider;
    }
}