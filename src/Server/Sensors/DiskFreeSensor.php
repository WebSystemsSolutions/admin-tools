<?php
namespace Sd1328\AdminTools\Server\Sensors;

use Symfony\Component\Process\Process;

/**
 * Class DiskFreeSensor
 *
 * Получение размера свободной дискового пространста (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class DiskFreeSensor implements SensorInterface
{
    /**
     * @var int все дисковое пространство (Кбайт)
     */
    public static $totalSpace;

    /**
     * @var int занятое дисковое пространство (Кбайт)
     */
    public static $usedSpace;

    /**
     * @var int свободное дисковое пространство (Кбайт)
     */
    public static $freeSpace;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getMeter()
    {
        self::calc();
        return self::$freeSpace;
    }

    /**
     * Рассчет показателей
     * @throws \Exception
     */
    public static function calc()
    {
        if (self::$totalSpace === null) {
            self::getDiskStat();
        }
    }

    /**
     * Получение метрик диска
     * @throws \Exception
     */
    protected static function getDiskStat()
    {
        $process = new Process(['df']);
        $process->run();
        if ($process->getExitCode() != 0) {
            throw new \Exception('Неизестная ошибка выполнения команды, код:' . $process->getExitCode());
        }

        if (preg_match('|(\w+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+%)\s+/\s+|', $process->getOutput(), $match)) {
            self::$totalSpace = $match[2];
            self::$usedSpace = $match[3];
            self::$freeSpace = $match[4];
        } else {
            throw new \Exception('Неизестная ошибка парсинга параметров диска');
        }
    }
}
