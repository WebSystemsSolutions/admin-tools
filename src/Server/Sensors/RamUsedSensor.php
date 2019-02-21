<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class RamUsedSensor
 *
 * Получение размера использованой процессами оперативной памяти (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class RamUsedSensor implements SensorInterface
{
    /**
     * @return int
     * @throws \Exception
     */
    public function getMeter()
    {
        RamFreeSensor::calc();
        return RamFreeSensor::$usedRam;
    }
}
