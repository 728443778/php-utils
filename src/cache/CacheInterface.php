<?php
/**
 * Created by 侯成华.
 * User: 侯成华
 * Date: 2018/6/1
 * Time: 上午10:39
 */

namespace sevenUtils\cache;

use sevenUtils\traits\SingleInstance;

abstract class CacheInterface
{
    use SingleInstance;

    protected $_driver;
}