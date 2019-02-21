<?php
namespace Sd1328\AdminTools\Service;

/**
 * Class LogPageReader
 *
 * Ридер файлов логов
 * - позволяет читать файл лога Построчно начиная "С КОНЦА"  (последних добаленных строк)
 * 
 * @package Sd1328\AdminTools\Service
 * @author lex gudz sd1328@gmail.com
 */
class LogPageReader
{
    /**
     * @var string - абсолютный путь к файлу
     */
    private $path;

    /**
     * @var int - размер страницы данных, читаемых за 1 запрос, в байтах
     */
    private $pageSize = 10000;

    /**
     * @var int - смещение предыдущей прочитаной страницы
     */
    private $lastOffset = -1;   // -1 - первый запрос

    /**
     * @var int размер запрашываемого файла
     */
    private $fileSize;

    /**
     * LogPageReader constructor.
     * @param string $path
     * @param int $pageSize
     * @throws \Exception
     */
    public function __construct(string $path, int $pageSize = 10000)
    {
        if (!file_exists($this->path)) {
            throw new \Exception('Файл Лога [' . $this->path . '] не найден');
        }
        if (!is_readable($this->path)) {
            throw new \Exception('Нет доступа для чтения [' . $this->path . ']');
        }
        $this->path = $path;
        $this->pageSize = $pageSize;
        $this->fileSize = filesize($this->path);
    }

    /**
     * @return int
     */
    public function getLastOffset(): int
    {
        return $this->lastOffset;
    }

    /**
     * @param int $lastOffset
     */
    public function setLastOffset(int $lastOffset): void
    {
        $this->lastOffset = $lastOffset;
    }

    /**
     * @param int|null $lastOffset
     * @return string
     * @throws \Exception
     */
    public function getLogContent(): string
    {
        // первый запрос - читаем последний участок файла
        if ($this->lastOffset === -1) {
            $this->lastOffset = $this->fileSize;
        }
        // достигнуто начало файла - заглушка возвращаем пустую строку
        if ($this->lastOffset == 0) {
            return '';
        }
        // Не начало файла
        if ($this->lastOffset > $this->pageSize) {
            $offset = $this->lastOffset - $this->pageSize;
            $length = $this->pageSize;
        } else {    // достигнуто начало файла
            $offset = 0;
            $length = $this->lastOffset;
        }

        return $this->readPage($offset, $length);
    }

    /**
     * Непосредственное чтение страницы из файла
     * @param int $offset
     * @param int $length
     * @return string
     */
    protected function readPage(int $offset, int $length): string
    {
        // чтение заданного участка файла
        $fp = fopen($this->path, 'r');
        fseek($fp, $offset);
        $content = fread($fp, $length);
        fclose($fp);

        // если НЕ начало файла
        if ($this->lastOffset > $this->pageSize) {
            // обрезаем страницу до целых строк
            $start = strpos($content, PHP_EOL);
            $this->lastOffset = $offset + strpos($content, PHP_EOL);
            $content = substr($content, $start, $this->pageSize);
        }
        return $content;
    }
}
