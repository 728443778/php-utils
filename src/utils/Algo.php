<?php
/**
 * Created by 侯成华.
 * User: 侯成华
 * Date: 2018/8/23
 * Time: 下午6:14
 */

namespace sevenUtils\utils;

class Algo
{
    /**
     * 采用加权算法，获取随机item
     * 输入参数 $array_item和 $array_weight 是一一对应的
     * @param $array_item array item数组
     * @param $array_weight array item对应的weight数组，
     * @param $weighted_poll boolean 是否采用加权轮询算法，默认是，如果总权重过大，则最好采用加权轮询算法
     * @param $get_key boolean 是否获取key
     * @return null | mixed | int
     */
    function get_item_by_weight($array_item, $array_weight, $weighted_poll = true, $get_key = false)
    {
        if (!is_array($array_item) || !is_array($array_weight)) {
            return null;
        }
        $count = count($array_item);
        if ($count != count($array_weight)) {
            return null;
        }
        //采用寻常的加权算法，时间复杂的为o(n)
        if (!$weighted_poll) {
            $i = 0;
            $weight_items = [];
            foreach ($array_weight as $weight) {
                $item = $array_item[$i];
                for ($j = 0; $j <$weight; ++$j) {
                    $weight_items[] = $item;
                }
                ++$i;
            }
            $key = array_rand($weight_items);
            if ($get_key) {
                return $key;
            }
            return $weight_items[$key];
        } else {
            //加权轮询算法
            $weight_total = 0;
            foreach ($array_weight as $key => $weight) {
                if ($weight <= 0) {
                    unset($array_item[$key]);
                    unset($array_weight[$key]);
                }
                $weight_total+=$weight;
            }
            $rand = mt_rand(0, $weight_total);
            foreach ($array_weight as $key=>$weight) {
                $rand -= $weight;
                if ($rand <= 0) {
                    if ($get_key) {
                        return $key;
                    }
                    return $array_item[$key];
                }
            }
        }
        return null;
    }
}