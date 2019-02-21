<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class SwapTotalSensor
 *
 * Получение размера всего файла подкачки (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class SwapTotalSensor implements SensorInterface
{
    /**
     * @return int
     * @throws \Exception
     */
    public function getMeter()
    {
        RamFreeSensor::calc();
        return RamFreeSensor::$totalSwap;
    }
}
