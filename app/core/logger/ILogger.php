<?php

namespace app\core\logger;

interface ILogger
{
    /** @var int тип лога - простое сообщение */
    public const MESSAGE = 1;
    /** @var int тип лога - предупреждение */
    public const WARNING = 2;
    /** @var int тип лога - ошибка */
    public const ERROR = 4;

    /**
     * Инициализирует логгер.
     *
     * @return $this
     * @throws \app\core\logger\exception\LoggerException
     */
    public function init(): self;

    /**
     * Записывает в лог переданное значение без перевода строки.
     *
     * @param string $value значение для записи
     * @param int $type тип сообщения для записи
     *
     * @return mixed
     */
    public function write(string $value, int $type = self::MESSAGE);

    /**
     * @param string $value
     *
     * @return mixed
     */
    public function info(string $value);

    /**
     * @param string $value
     *
     * @return mixed
     */
    public function warn(string $value);

    /**
     * @param string $value
     *
     * @return mixed
     */
    public function error(string $value);
}
