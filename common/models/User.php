<?php

namespace app\common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 *
 * @property mixed $authKey
 * @property string $password
 * @property mixed $role
 * @property string $names
 * @property mixed $initialPassword
 */
class User extends \app\models\User implements IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = static::findOne([
            'username' => $username,
            'status' => self::STATUS_ACTIVE
        ]);
        return $user;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->confirm_password = $this->password_hash;
    }

    /**
     * Set default password that the user will have to change upon login
     * @param $password
     */
    public function setInitialPassword($password)
    {
        $this->default_password = $password;
        $this->change_password = true; //require user to change password on login
    }

    /**
     * @param string $id user_id from audit_entry table
     * @return mixed|string
     */
    public static function userIdentifierCallback($id)
    {
        $user = self::findOne($id);
        $return = $user ? $user->username : $id;
        return $return;
    }

    /**
     * @param string $identifier user_id from audit_entry table
     * @return mixed|string
     */
    public static function filterByUserIdentifierCallback($identifier)
    {
        return static::find()->select('id')
            ->where(['like', 'username', $identifier])
            ->orWhere(['like', 'email', $identifier])
            ->column();
    }

    public function getNames()
    {
        return "show full names"; //"{$this->employee->emp_firstname},{$this->employee->emp_lastname}";
    }

    public function getEmployeeid()
    {
        return $this->employee_id;
    }

    public function getRole()
    {
        return $this->userType->user_type;
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

}
