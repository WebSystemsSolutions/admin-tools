<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class RamTotalSensor
 *
 * Получение размера всей оперативной памяти (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class RamTotalSensor implements SensorInterface
{
    /**
     * @return int
     * @throws \Exception
     */
    public function getMeter()
    {
        RamFreeSensor::calc();
        return RamFreeSensor::$totalRam;
    }
}
