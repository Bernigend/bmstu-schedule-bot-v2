<?php

namespace app\core\logger;

use app\core\Application;
use app\core\logger\exception\LoggerException;
use Throwable;

class FileLogger implements ILogger
{
    /** @var resource открытый файл лога */
    protected $openedFile;

    /** @inheritDoc */
    public function init(): ILogger
    {
        $this->openedFile = fopen(
            $this->getAbsFilePath(),
            'a+'
        );

        if (!$this->openedFile) {
            throw new LoggerException("Cannot open or create log file '{$this->getAbsFilePath()}'");
        }

        return $this;
    }

    /** @inheritDoc */
    public function write(string $value, int $type = self::MESSAGE)
    {
        $value = str_replace(PHP_EOL, ' \n ', $value);
        $value = $this->getPrefix($type) . $value . "\n";

        fwrite($this->openedFile, $value);
    }

    /** @inheritDoc */
    public function info(string $value)
    {
        $this->write($value, static::MESSAGE);
    }

    /** @inheritDoc */
    public function warn(string $value)
    {
        $this->write($value, static::WARNING);
    }

    /** @inheritDoc */
    public function error(string $value)
    {
        $this->write($value, static::ERROR);
    }

    /** @inheritDoc */
    public function exception(Throwable $e)
    {
        $this->write("Exception: {$e->getMessage()}: {$e->getTraceAsString()}", static::ERROR);
    }

    /**
     * Возвращает имя файла с логами.
     *
     * @return string
     */
    protected function getFileName(): string
    {
        return 'log_' . date('Y_m_d') . '.log';
    }

    /**
     * Возвращает абсолютный путь к директории с логами.
     *
     * @return string
     */
    protected function getAbsDirPath(): string
    {
        return Application::getInstance()->getAbsRootDirectory() . '/logs';
    }

    /**
     * Возвращает абсолютный путь к файлу лога.
     *
     * @return string
     */
    protected function getAbsFilePath(): string
    {
        return $this->getAbsDirPath() . DIRECTORY_SEPARATOR . $this->getFileName();
    }

    /**
     * Возвращает префикс для записи лога.
     *
     * @param int $logType
     *
     * @return string
     */
    protected function getPrefix(int $logType): string
    {
        switch ($logType) {
            default:
            case ILogger::MESSAGE:
                $messageType = 'INFO';
                break;
            case ILogger::WARNING:
                $messageType = 'WARN';
                break;
            case ILogger::ERROR:
                $messageType = 'ERR';
                break;
        }

        return "[{$messageType}][" . date('Y-m-d H:i:s') . "] ";
    }
}