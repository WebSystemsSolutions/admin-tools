<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class DiskUsedSensor
 *
 * Получение размера занятого дискового пространста (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class DiskUsedSensor implements SensorInterface
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function getMeter()
    {
        DiskFreeSensor::calc();
        return DiskFreeSensor::$usedSpace;
    }
}
