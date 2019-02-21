<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class RamAvailableSensor
 *
 * Получение размера доступной процессам оперативной памяти (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class RamAvailableSensor implements SensorInterface
{
    /**
     * @return int
     * @throws \Exception
     */
    public function getMeter()
    {
        RamFreeSensor::calc();
        return RamFreeSensor::$availableRam;
    }
}
