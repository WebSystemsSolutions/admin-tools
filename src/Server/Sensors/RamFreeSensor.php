<?php
namespace Sd1328\AdminTools\Server\Sensors;

use Symfony\Component\Process\Process;

/**
 * Class RamFreeSensor
 *
 * Получение размера свободной (не занятой) оперативной памяти (Кбайт)
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class RamFreeSensor implements SensorInterface
{
    /**
     * @const - RegExp паттерн метрик RAM
     */
    private const RAM_PATTERN = '/:\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s*/';

    /**
     * @const - RegExp паттерн метрик SWAP
     */
    private const SWAP_PATTERN = '/:\s+(\d{1,10})\s+(\d{1,10})\s+(\d{1,10})\s*/';

    /**
     * @var int - всего RAM (Кбайт)
     */
    public static $totalRam;

    /**
     * @var int - занято процессами RAM (Кбайт)
     */
    public static $usedRam;

    /**
     * @var int - свободно RAM (Кбайт)
     */
    public static $freeRam;

    /**
     * @var int - доступно процессам RAM (Кбайт)
     */
    public static $availableRam;

    /**
     * @var int - всего SWAP (Кбайт)
     */
    public static $totalSwap;

    /**
     * @var int - занято процессами SWAP (Кбайт)
     */
    public static $usedSwap;

    /**
     * @var int - свободно SWAP (Кбайт)
     */
    public static $freeSwap;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getMeter()
    {
        self::calc();
        return self::$freeRam;
    }

    /**
     * Рассчет показателей
     * @throws \Exception
     */
    public static function calc()
    {
        if (self::$totalRam === null) {
            self::getMemoryStat();
        }
    }

    /**
     * Получение метрик памяти
     * @throws \Exception
     */
    private static function getMemoryStat()
    {
        $process = new Process(['free']);
        $process->run();
        if ($process->getExitCode() != 0) {
            throw new \Exception('Неизестная ошибка выполнения команды, код:' . $process->getExitCode());
        }
        $lines = explode(PHP_EOL, $process->getOutput());
        if (count($lines) < 3) {
            throw new \Exception('Неожиданый вывод команды free'.print_r($lines, true));
        }
        // метрики RAM
        // 1-total   2-used  3-free  4-shared  5-buff/cache  6-available
        if (preg_match(self::RAM_PATTERN, $lines[1], $match)) {
            self::$totalRam = $match[1];
            self::$usedRam = $match[2];
            self::$freeRam = $match[3];
            self::$availableRam = $match[6];
        } else {
            throw new \Exception('Неизестная ошибка парсинга параметров RAM'.$lines[1]);
        }
        // метрики SWAP
        // 1-total   2-used  3-free
        if (preg_match(self::SWAP_PATTERN, $lines[2], $match)) {
            self::$totalSwap = $match[1];
            self::$usedSwap = $match[2];
            self::$freeSwap = $match[3];
        } else {
            throw new \Exception('Неизестная ошибка парсинга параметров SWAP');
        }
    }
}
