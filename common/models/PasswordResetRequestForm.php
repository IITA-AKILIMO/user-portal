<?php

namespace app\common\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     * @throws Exception
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);


        if (!$user) {
            return false;
        }


        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {

            $user->scenario = User::SCENARIO_RESET_PASSWORD;

            $user->generatePasswordResetToken();

            if (!$user->save()) {
                return false;
            }
        }


        $senderEmail = Yii::$app->params['senderEmail'];
        $supportEmail = Yii::$app->params['supportEmail'];
//        $domain = Yii::$app->homeUrl;
        $domain = Yii::$app->params['domainName'];
        $fromName = Yii::$app->name . ' password reset';

        $resetLink = "{$domain}/site/reset-password?token={$user->password_reset_token}";
        $result = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'password-reset', 'text' => 'text'],
                [
                    'names' => $user->names,
                    'resetLink' => $resetLink
                ]
            )
            ->setFrom([$senderEmail => $fromName])
            ->setReplyTo([$supportEmail => 'User support'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . $user->names)
            ->send();

        return $result;
    }
}
