<?php

namespace mistim\modules\admin\models;

use mistim\modules\admin\models\AdminAuth;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_admin = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username'   => Yii::t('admin', 'Login'),
            'password'   => Yii::t('admin', 'Password'),
            'rememberMe' => Yii::t('admin', 'Remember me'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getUser();

            if (!$admin || !$admin->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate())
        {
            /** @var AdminAuth $user */
            $user = $this->getUser();

            $result = Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);

            if ($result)
            {
                $user->saveDateLastEnter();
            }

            return $result;
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Admin|null
     */
    public function getUser()
    {
        if ($this->_admin === false) {
            $this->_admin = AdminAuth::findByEmail($this->username);
        }

        return $this->_admin;
    }
}
