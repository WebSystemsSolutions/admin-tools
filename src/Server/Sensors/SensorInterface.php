<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Interface SensorInterface
 * Интерефейс классов - "датчиков" (получение конкретной метрики)
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
interface SensorInterface
{
    public function getMeter();
}
