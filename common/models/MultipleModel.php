<?php
/**
 * Created by PhpStorm.
 * User: RONIN - Sammy B
 * Date: 2/13/2018
 * Time: 9:49 PM
 */

namespace app\common\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class MultipleModel extends Model
{
    /**
     * Creates and populates a set of models.
     * @example  $desiredMultiple = Model::createMultiple(DesiredMultipleModel::className(), Yii::$app->request->post('DesiredMultipleModel')); // Be specific, you may have multiple model classes in view
     * @example Model::loadMultiple($policyDocs, Yii::$app->request->post('DesiredMultipleModel'));
     * @param string $modelClass
     * @param array $multipleModels
     * @param string $pk
     * @return array
     * @author  Sammy Barasa
     * @Date 19/Sep/2019
     */
    public static function createMultiple($modelClass, $multipleModels = [], $pk = 'id')
    {
        $model = new $modelClass;
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        if (!empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, $pk, $pk));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item[$pk]) && !empty($item[$pk]) && isset($multipleModels[$item[$pk]])) {
                    $models[] = $multipleModels[$item[$pk]];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }
}