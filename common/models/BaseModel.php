<?php
/** @noinspection UndetectableTableInspection */

namespace app\common\models;

use app\models\ItemSale;
use app\models\SaleItem;
use app\models\ShopIssuanceItem;
use app\models\ShopIssuanceStatus;
use app\models\StockOrderItem;
use DateTime;
use Exception;
use mootensai\relation\RelationTrait;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class BaseModel
 * @property int $stock_category_id
 * @package app\common\models
 */
class BaseModel extends ActiveRecord
{
//    use RelationTrait;


    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ]
        ];
    }

    /**
     * @return int
     * @throws Exception
     */
    public function generateTimeStamp()
    {
        $date = new DateTime();
        return $date->getTimestamp();
    }


    /**
     * @return array
     */
    protected function setMonthsArray()
    {
        $monthsData = [];
        for ($i = 0; $i <= 11; $i++) {
            $monthsData[$i] = null;
        }

        return $monthsData;
    }

    /**
     * @param $year
     * @return array
     */
    public function setShortMonthName($year)
    {
        $monthsData = $this->setMonthsArray();
        $labels = [];
        foreach ($monthsData as $key => $data) {
            $monthNumber = $key + 1; //increment by one to allow number to name conversion
            $jd = GregorianToJD($monthNumber, 1, $year);
            $labels[] = JDMonthName($jd, 0);
        }
        return $labels;
    }
}