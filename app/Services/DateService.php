<?php
namespace App\Services;

use Carbon\Carbon;

class DateService {

    protected $carbon;

    /**
     * DateService constructor.
     * @param Carbon $carbon
     */
    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
    }

    /**
     * 今日の日付を取得
     *
     * @param String $format
     * @return void
     */
    public function getToday(String $format = "YYYY-MM-DD")
    {
        //今日の日付取得
        return $this->carbon->toDateString();
    }

    /**
     * 現在の時間を取得
     *
     * @param String $format
     * @return void
     */
    public function getNowTime(String $format = "H:i")
    {
        //現在の時間取得
        return $this->carbon->format($format);
    }

    /**
     * 一週間分の日付を取得
     * @param String $targetDay
     * @return array
     */
    public function getDateForOneWeek(String $targetDay){
        $weekArray = array();
        $weekArray[] = $targetDay;
        for ($i=1; $i <= 6; $i++) {
            $targetDay = strtotime($targetDay);
            $targetDay = date('Y-m-d', strtotime('+1 days', $targetDay));
            $weekArray[] = $targetDay;
        }
        return $weekArray;
    }

    /**
     * カレンダー取得
     * @param String $year
     * @param String $month
     * @return array
     * @throws \Exception
     */
    public function getCalendarDates($year, $month)
    {
        $dateStr = sprintf('%04d-%02d-01', $year, $month);
        $date = new Carbon($dateStr);
        // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
        $date->subDay($date->dayOfWeek);
        // 同上。右下の隙間のための計算。
        $count = 31 + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $dates = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            // copyしないと全部同じオブジェクトを入れてしまうことになる
            $dates[] = $date->copy();
        }
        return $dates;
    }
}
