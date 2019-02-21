<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class CpuLoadAverage1mSensor
 *
 * Датчик - средняя загрузка процессора (%) за 1 мин.
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class CpuLoadAverage1mSensor implements SensorInterface
{
    /**
     * Получение средней загрузки процессора (ов)
     * - среднее за 1 мин.
     * @return int
     * @throws \Exception
     */
    public function getMeter(): int
    {
        CpuLoadAverage15mSensor::calc();
        return CpuLoadAverage15mSensor::$averageLoad1m;
    }
}
