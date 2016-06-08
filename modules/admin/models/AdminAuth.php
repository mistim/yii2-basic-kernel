<?php

namespace mistim\kernel\modules\admin\models;

use mistim\kernel\modules\admin\models\Admin;
use yii\web\IdentityInterface;
use Yii;

/**
 * Class AdminAuth
 * @package mistim\kernel\modules\admin\models
 */
class AdminAuth extends Admin implements IdentityInterface
{
	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByEmail($username)
	{
		return static::findOne(['varEmail' => $username, 'intStatus' => self::STATUS_ACTIVE]);
	}

	public function getUsername(){
		return $this->varName;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->varPassword);
	}

	/**
	 * @param $password
	 * @return string
	 * @throws \yii\base\Exception
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function setPassword($password)
	{
		return Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * @param int|string $id
	 * @return \yii\web\IdentityInterface|static
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	/**
	 * @param mixed $token
	 * @param null $type
	 * @return \yii\web\IdentityInterface|static
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}

	/**
	 * @return int|string current user ID
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return true;
	}

	/**
	 * @return string
	 */
	public static function getRole()
	{
		$roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->getId());

		return implode(', ', array_keys($roles));
	}

	/**
	 * @return \yii\rbac\Role[]
	 */
	public static function getAllRoles()
	{
		return Yii::$app->authManager->getRoles();
	}

	/**
	 * @return bool
	 */
	public static function isAdmin()
	{
		return self::getRole() === 'Administrator';
	}
}
