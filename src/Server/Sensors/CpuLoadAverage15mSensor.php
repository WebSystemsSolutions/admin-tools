<?php
namespace Sd1328\AdminTools\Server\Sensors;

use Symfony\Component\Process\Process;

/**
 * Class CpuLoadAverage15mSensor
 *
 * Датчик - средняя загрузка процессора (%) за 15 мин.
 *
 * @package Sd1328\AdminTools\Server\Sensors
 * @author lex gudz sd1328@gmail.com
 */
class CpuLoadAverage15mSensor implements SensorInterface
{
    /**
     * @const позиция строки - количество потоков ядра
     */
    private const LINE_INFO_THREAD_CORE = 5;

    /**
     * @const позиция строки - количество ядер
     */
    private const LINE_INFO_CORE_NUM = 6;

    /**
     * @const позиция строки - количество процессоров
     */
    private const LINE_INFO_SOCKET_NUM = 7;

    /**
     * @var int - загрузка процессора - среднее за 1 мин.
     */
    public static $averageLoad1m;

    /**
     * @var  - загрузка процессора - среднее за 5 мин.
     */
    public static $averageLoad5m;

    /**
     * @var  - загрузка процессора - среднее за 15 мин.
     */
    public static $averageLoad15m;

    /**
     * Получение средней загрузки процессора (ов)
     * - среднее за 15 мин.
     * @return int
     * @throws \Exception
     */
    public function getMeter(): int
    {
        self::calc();
        return self::$averageLoad15m;
    }

    /**
     * Рассчет показателей
     * @throws \Exception
     */
    public static function calc(): void
    {
        if (self::$averageLoad1m === null) {
            $averageLoad = self::getAllAverageLoad();
            $coreNum = self::getAllCoreNum();
            self::$averageLoad1m = round(($averageLoad[0] / $coreNum) * 100);
            self::$averageLoad5m = round(($averageLoad[1] / $coreNum) * 100);
            self::$averageLoad15m = round(($averageLoad[2] / $coreNum) * 100);
        }
    }

    /**
     * Полуения характеристик процессоро системы - lscpu
     * @return int
     * @throws \Exception
     */
    protected static function getAllCoreNum(): int
    {
        $process = new Process(['lscpu']);
        $process->run();
        if ($process->getExitCode() == 0) {
            $lines = explode(PHP_EOL, $process->getOutput());
            return (int) (
                self::getIntValue($lines[self::LINE_INFO_THREAD_CORE])
                * self::getIntValue($lines[self::LINE_INFO_CORE_NUM])
                * self::getIntValue($lines[self::LINE_INFO_SOCKET_NUM])
            );
        }
        throw new \Exception('Неизестная ошибка выполнения команды, код:' . $process->getExitCode());
    }

    /**
     * Получение средней загрузки процессора - uptime
     * @return int
     * @throws \Exception
     */
    protected static function getAllAverageLoad(): array
    {
        $process = new Process(['uptime']);
        $process->run();
        if ($process->getExitCode() == 0) {
            if (preg_match('/\w:\s+([\d\.,]{1,10}),\s+([\d\.,]{1,10}),\s+([\d\.,]{1,10})\s*/', $process->getOutput(), $match)) {
                return [
                    (float) str_replace(',', '.', $match[1]),
                    (float) str_replace(',', '.', $match[2]),
                    (float) str_replace(',', '.', $match[3]),
                ];
            }
        }
        throw new \Exception('Неизестная ошибка выполнения команды, код:' . $process->getExitCode());
    }

    /**
     * Получение числового показателя из строки
     * @param string $line
     * @return float
     */
    protected static function getIntValue(string $line): int
    {
        return  (int) trim(substr(
            $line,
            strpos($line, ':') + 1      // находим разделитель :
        ));
    }
}
