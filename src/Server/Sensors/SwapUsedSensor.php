<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class SwapUsedSensor
 *
 * Получение размера использования файла подкачки (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class SwapUsedSensor implements SensorInterface
{
    /**
     * @return int
     * @throws \Exception
     */
    public function getMeter()
    {
        RamFreeSensor::calc();
        return RamFreeSensor::$usedSwap;
    }
}
