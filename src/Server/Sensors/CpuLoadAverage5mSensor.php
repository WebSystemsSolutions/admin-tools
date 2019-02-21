<?php
namespace Sd1328\AdminTools\Server\Sensors;

/**
 * Class CpuLoadAverage5mSensor
 *
 * Датчик - средняя загрузка процессора (%) за 5 мин.
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class CpuLoadAverage5mSensor implements SensorInterface
{
    /**
     * Получение средней загрузки процессора (ов)
     * - среднее за 5 мин.
     * @return int
     * @throws \Exception
     */
    public function getMeter(): int
    {
        CpuLoadAverage15mSensor::calc();
        return CpuLoadAverage15mSensor::$averageLoad5m;
    }
}
