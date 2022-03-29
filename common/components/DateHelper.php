<?php


namespace app\common\components;


use app\models\Sale;

class DateHelper
{
    /**
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getDateRangeForMonthAndYear($month = 0, $year = 0)
    {
        $currentDay = date('Y-m-d');
        if ($month <= 0) {
            $month = date('m');
        }

        if ($year <= 0) {
            $year = date('Y');
        }
        $monthDaysList = [];

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                if (date('Y-m-d', $time) <= $currentDay) {
                    $monthDaysList[] = date('Y-m-d', $time);
                }
            }
        }
        return $monthDaysList;
    }

    public function getCumulativeMonthShopSales($dateFrom, $dateTo)
    {
        $cumulativeSale = Sale::find()
            ->where(['between', 'sale_date', $dateFrom, $dateTo])
            ->andWhere(['sale_closed' => 1])
            ->sum('final_amount');

        return $cumulativeSale != null ? $cumulativeSale : 0;
    }
}
