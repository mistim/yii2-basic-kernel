<?php

namespace mistim\modules\admin\models;

use mistim\modules\rbac\models\AuthAssignmentModel;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property integer $intAdminID
 * @property string $varName
 * @property string $varEmail
 * @property string $varPassword
 * @property integer $intStatus
 * @property string $dateCreated
 * @property string $dateLastEnter
 * @property string $varConfirmPassword
 *
 * @property AuthAssignmentModel[] $roles
 * @property array $listRoles
 */
class Admin extends ActiveRecord
{
	const STATUS_NOT_ACTIVE = 0;
	const STATUS_ACTIVE = 1;

	static $listStatus = [];

	protected $auth_key = '';

	public $varConfirmPassword;
	public $listRoles = [];

	public function init()
	{
		parent::init();

		self::$listStatus = [
			self::STATUS_NOT_ACTIVE => Yii::t('admin', 'Not active'),
			self::STATUS_ACTIVE     => Yii::t('admin', 'Active')
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'admin';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['varName', 'varEmail', 'intStatus'], 'required'],
			['listRoles', 'required', 'except' => 'last_enter'],
			[['varName', 'varEmail'], 'unique'],
			[['varName'], 'required'],
			[['varEmail'], 'email', 'except' => 'login'],
			[['intStatus'], 'integer'],
			//['intRoleID', 'in', 'range' => array_keys(Roles::$listRoles)],
			[['dateCreated', 'dateLastEnter'], 'safe'],
			[['varName'], 'string', 'max' => 32],
			[['varEmail', 'varPassword', 'varConfirmPassword'], 'string', 'max' => 64],
			// Minimum password length of 8 characters, at least one digit, at least one letter, at least one special character
			[
				['varPassword', 'varConfirmPassword'], 'match', 'pattern'=>'/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/i',
				'message' => Yii::t('admin', 'Minimum password length of 8 characters, at least one digit, at least one letter, at least one special character')
			],
			['varConfirmPassword', 'confirmPassword', 'skipOnEmpty' => true, 'on' => ['update', 'last_enter']],
			['varPassword', 'required', 'on' => ['create','login']],

			['varConfirmPassword', 'required', 'when' => function ($model) {
					return !empty($model->varPassword) && !$model->isNewRecord;
				}, 'whenClient' => "function (attribute, value) {
				return $('#adminauth-varpassword').val() != '';
			}", 'except' => 'last_enter'],
			//[['varPassword', 'varConfirmPassword'], 'required', 'on' => 'create'],
			['dateLastEnter', 'required', 'on' => ['last_enter'], 'except' => ['create', 'login']],
			[['listRoles'], 'safe'],
		];
	}

	/**
	 * @param $attribute
	 */
	public function confirmPassword($attribute)
	{
		if ($this->varPassword !== $this->varConfirmPassword)
		{
			$this->addError($attribute, Yii::t('admin', 'Passwords do not match'));
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'intAdminID'         => Yii::t('admin', 'ID'),
			'varName'            => Yii::t('admin', 'Name'),
			'varEmail'           => Yii::t('admin', 'Email'),
			'varPassword'        => Yii::t('admin', 'Password'),
			'intStatus'          => Yii::t('admin', 'Status'),
			'dateCreated'        => Yii::t('admin', 'Created Date'),
			'dateLastEnter'      => Yii::t('admin', 'Last Enter Date'),
			'varConfirmPassword' => Yii::t('admin', 'Confirm Password'),
			'role'               => Yii::t('admin', 'Role'),
			'listRoles'          => Yii::t('admin', 'Role'),
		];
	}

	/**
	 * @param bool $insert
	 * @return bool
	 * @throws \yii\base\Exception
	 * @throws \yii\base\InvalidConfigException
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert))
		{
			if ($this->getIsNewRecord())
			{
				$this->varPassword = Yii::$app->getSecurity()->generatePasswordHash($this->varPassword);
				$this->dateCreated = date('Y-m-d H::i::s');
			}
			else
			{
				if ($this->getScenario() === 'update')
				{
					if (!empty($this->varPassword))
					{
						$this->varPassword = Yii::$app->getSecurity()->generatePasswordHash($this->varPassword);
					} else {
						unset($this->varPassword);
					}
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
	 * @param bool $insert
	 * @param array $changedAttributes
	 */
	public function afterSave($insert, $changedAttributes)
	{
		parent::AfterSave($insert, $changedAttributes);

		if ($this->getScenario() !== 'last_enter')
		{
			AuthAssignmentModel::deleteAll(['user_id' => $this->intAdminID]);

			foreach ($this->listRoles as $role)
			{
				$model = new AuthAssignmentModel();
				$model->item_name = $role;
				$model->user_id = (string) $this->intAdminID;
				$model->created_at = time();
				$model->save();
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	public function setListRoles()
	{
		foreach ($this->roles as $role)
		{
			$this->listRoles[$role->item_name] = $role->item_name;
		}
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRoles()
	{
		return $this->hasMany(AuthAssignmentModel::className(), ['user_id' => 'intAdminID']);
	}

	/**
	 * @return \yii\rbac\Role[]
	 */
	public static function getAllRoles()
	{
		return Yii::$app->authManager->getRoles();
	}

	/**
	 * @param $role
	 * @return array
	 */
	public static function findAllByRole($role)
	{
		return self::find()
			->select('admin.*, auth_assignment.*')
			->leftJoin('auth_assignment', '`user_id` = `intAdminID`')
			->where(['item_name' => $role])
			->all();
	}

	/**
	 * @return bool
	 */
	public function saveDateLastEnter()
	{
		$this->scenario = 'last_enter';
		$this->dateLastEnter = (new \DateTime())->format('Y-m-d H:i:s');

		return $this->save();
	}
}
