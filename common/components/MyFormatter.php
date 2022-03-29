<?php


namespace app\common\components;


use yii\i18n\Formatter;

class MyFormatter extends Formatter
{

    public function asDecimal($value, $decimals = 2, $options = [], $textOptions = [])
    {
        return parent::asDecimal($value, $decimals, $options, $textOptions);
    }
}