<?php


namespace app\common\controllers;


use app\common\components\MyAccessControl;
use app\models\City;
use app\models\Employee;
use app\models\Sale;
use app\models\SaleItem;
use app\models\ShopIssuanceItem;
use app\models\StockOrder;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 *
 * @property-read mixed $cacheShop
 */
class BaseWebController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => MyAccessControl::class,
                'allowActions' => ['request-password-reset', 'login',]

            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $model
     * @return array
     */
    protected function getAttributeErrors($model): array
    {
        $result = [];
        foreach ($model->getErrors() as $attribute => $errors) {
            $result[Html::getInputId($model, $attribute)] = $errors;
        }
        return $result;
    }

}