<?php

namespace sevenUtils\utils;

use sevenUtils\traits\SingleInstance;

class TimeStamp
{
    use SingleInstance;

    public function getToDayStartUnixTime()
    {
        $time = time();
        $date = date('Y-m-d', $time);
        return strtotime($date);
    }

    public function getToDayEndUnixTime()
    {
        $startTime = $this->getToDayStartUnixTime();
        return $startTime + 3600 * 24 -1;
    }

    public function getCurrentMonthStartUnixTime()
    {
        $date = date('Y-m');
        $date = $date . '-01';
        return strtotime($date);
    }

    public function getCurrentMonthEndUnixTime()
    {
        $year = $this->getCurrentYear();
        $month = $this->getCurrentMonth();
        if ($month == 12) {
            $year += 1;
            $month = 1;
        } else {
            $month += 1;
        }
        return strtotime("{$year}-{$month}-01") - 1; //下一个月的开始时间 在减去1秒
    }

    public function getUnixTime($year = '', $month = '', $day = '', $hour = '', $minu = '', $sec = '')
    {
        return mktime((int)strtotime($hour), (int)strtotime($minu), (int)strtotime($sec),
            (int)strtotime($month),(int)strtotime($day),(int)strtotime($year));
    }

    public function getCurrentYear()
    {
        return date('Y');
    }

    public function getCurrentMonth()
    {
        return date('n');
    }

    public function getCurrentDay()
    {
        return date('j');
    }

    public function getCurrentHour()
    {
        return date('H');
    }

    public function getCurrentMinute()
    {
        return date('i');
    }

    public function getCurrentSecond()
    {
        return date('s');
    }
}