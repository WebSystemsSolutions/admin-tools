<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class DiskTotalSensor
 *
 * Получение размера всего дискового пространста (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class DiskTotalSensor implements SensorInterface
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function getMeter()
    {
        DiskFreeSensor::calc();
        return DiskFreeSensor::$totalSpace;
    }
}
