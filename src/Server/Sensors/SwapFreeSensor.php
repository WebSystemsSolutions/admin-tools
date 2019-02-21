<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class SwapFreeSensor
 *
 * Получение размера свободного (не занятого) пространства файла подкачки (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class SwapFreeSensor implements SensorInterface
{
    /**
     * @return int
     * @throws \Exception
     */
    public function getMeter()
    {
        RamFreeSensor::calc();
        return RamFreeSensor::$freeSwap;
    }
}
