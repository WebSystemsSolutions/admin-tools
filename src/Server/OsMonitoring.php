<?php
namespace Sd1328\AdminTools\Server;

use Sd1328\AdminTools\Server\Sensors\CpuLoadAverage15mSensor;
use Sd1328\AdminTools\Server\Sensors\CpuLoadAverage1mSensor;
use Sd1328\AdminTools\Server\Sensors\CpuLoadAverage5mSensor;
use Sd1328\AdminTools\Server\Sensors\DiskFreeSensor;
use Sd1328\AdminTools\Server\Sensors\DiskTotalSensor;
use Sd1328\AdminTools\Server\Sensors\DiskUsedSensor;
use Sd1328\AdminTools\Server\Sensors\RamAvailableSensor;
use Sd1328\AdminTools\Server\Sensors\RamFreeSensor;
use Sd1328\AdminTools\Server\Sensors\RamTotalSensor;
use Sd1328\AdminTools\Server\Sensors\RamUsedSensor;
use Sd1328\AdminTools\Server\Sensors\SensorInterface;
use Sd1328\AdminTools\Server\Sensors\SwapFreeSensor;
use Sd1328\AdminTools\Server\Sensors\SwapTotalSensor;
use Sd1328\AdminTools\Server\Sensors\SwapUsedSensor;

/**
 * Class OsMonitoring
 *
 * Компонент получения метрик сервера/ОС
 * - нагрузка на процессор
 * - оперативная память
 * - файл подкачки
 * - дисковое пространство
 *
 * Возможно переопределить список метрик по умолчанию через  $customSensorList:
 *
 * $foo = new OsMonitoring($customSensorList);
 *
 * @package Sd1328\AdminTools\Server
 * @author lex gudz sd1328@gmail.com
 */
class OsMonitoring
{
    /**
     * @var array|null  - список получаемых метрик (класов датиков)
     */
    protected $sensorList = [
        CpuLoadAverage15mSensor::class,
        CpuLoadAverage5mSensor::class,
        CpuLoadAverage1mSensor::class,
        DiskTotalSensor::class,
        DiskFreeSensor::class,
        DiskUsedSensor::class,
        RamTotalSensor::class,
        RamAvailableSensor::class,
        RamFreeSensor::class,
        RamUsedSensor::class,
        SwapTotalSensor::class,
        SwapUsedSensor::class,
        SwapFreeSensor::class,
    ];

    /**
     * OsMonitoring constructor.
     * @param array|null $sensorList
     */
    public function __construct(array $sensorList = null)
    {
        if ($sensorList) {
            $this->sensorList = $sensorList;
        }
    }

    /**
     * Получение коолекции показателей (метрик)
     * @return array
     * @throws \Exception
     */
    public function getMeters()
    {
        $data = [];
        foreach ($this->sensorList as $className) {
            $sensor = $this->getSensor($className);
            $data[$this->getSensorName($sensor)] = $sensor->getMeter();
        }
        return $data;
    }

    /**
     * Инстанцирование обекта датчика по имени класа
     * @param $className
     * @return SensorInterface
     * @throws \Exception
     */
    protected function getSensor($className): SensorInterface
    {
        if (!class_exists($className)) {
            throw new \Exception('Неизвестный класс датчика:' . $className);
        }
        $sensor = new $className();
        if ($sensor instanceof SensorInterface) {
            return $sensor;
        }
        throw new \Exception('Указанный класс:' . $className . ' не является датчиком метрики сервера');
    }

    /**
     * Получения имени показателя по классу
     * @param SensorInterface $sensor
     * @return string
     */
    protected function getSensorName(SensorInterface $sensor): string
    {
        $key = get_class($sensor);
        $key = str_replace('Sd1328\AdminTools\Server\Sensors\\', '', $key);
        $key = str_replace('Sensor', '', $key);
        return $key;
    }
}
