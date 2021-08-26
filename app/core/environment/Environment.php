<?php

namespace app\core\environment;


use app\core\Application;
use Dotenv\Dotenv;

/**
 * Class Environment.
 *
 * Класс для работы с окружением.
 * Подгружает переменные окружения из .env файла.
 */
class Environment
{
    /** @var string */
    protected const DATABASE_HOST = 'DATABASE_HOST';
    /** @var string */
    protected const DATABASE_PORT = 'DATABASE_PORT';
    /** @var string */
    protected const DATABASE_NAME = 'DATABASE_NAME';
    /** @var string */
    protected const DATABASE_USER = 'DATABASE_USER';
    /** @var string */
    protected const DATABASE_PASS = 'DATABASE_PASS';
    /** @var string */
    protected const DATABASE_CHARSET = 'DATABASE_CHARSET';

    /** @var string */
    protected const LOGGER_CLASS = 'LOGGER_CLASS';
    /** @var string */
    protected const CACHE_CLASS = 'CACHE_CLASS';

    /** @var string */
    protected const BITOP_ACCESS_TOKEN = 'BITOP_ACCESS_TOKEN';

    /** @var string[] обязательные переменные */
    protected const REQUIRED_VARS = [
        self::DATABASE_HOST,
        self::DATABASE_PORT,
        self::DATABASE_NAME,
        self::DATABASE_USER,
        self::DATABASE_PASS,
        self::DATABASE_CHARSET,

        self::LOGGER_CLASS,
        self::CACHE_CLASS,

        self::BITOP_ACCESS_TOKEN,
    ];

    /** @var Dotenv */
    protected Dotenv $dotenv;

    /**
     * Инициализирует переменные окружения.
     */
    public function init(): void
    {
        $this->dotenv = Dotenv::createImmutable(Application::getInstance()->getAbsRootDirectory());
        $this->dotenv->load();

        $this->dotenv->required(static::REQUIRED_VARS);
    }

    /**
     * Возвращает значение переменной окружения.
     *
     * @param string $name название еременной
     * @param string|null $defaultValue значение по умолчанию, если переменной не существует
     *
     * @return string|null
     */
    public function get(string $name, string $defaultValue = null): ?string
    {
        return $_ENV[$name] ?? $defaultValue;
    }

    /**
     * @return string|null
     */
    public function getDatabaseHost(): ?string
    {
        return $this->get(static::DATABASE_HOST);
    }

    /**
     * @return string|null
     */
    public function getDatabasePort(): ?string
    {
        return $this->get(static::DATABASE_PORT);
    }

    /**
     * @return string|null
     */
    public function getDatabaseName(): ?string
    {
        return $this->get(static::DATABASE_NAME);
    }

    /**
     * @return string|null
     */
    public function getDatabaseUser(): ?string
    {
        return $this->get(static::DATABASE_USER);
    }

    /**
     * @return string|null
     */
    public function getDatabasePass(): ?string
    {
        return $this->get(static::DATABASE_PASS);
    }

    /**
     * @return string|null
     */
    public function getDatabaseCharset(): ?string
    {
        return $this->get(static::DATABASE_CHARSET);
    }

    /**
     * @return string|null
     */
    public function getLoggerClass(): ?string
    {
        return $this->get(static::LOGGER_CLASS);
    }

    /**
     * @return string|null
     */
    public function getCacheClass(): ?string
    {
        return $this->get(static::CACHE_CLASS);
    }

    /**
     * @return string|null
     */
    public function getBitopAccessToken(): ?string
    {
        return $this->get(static::BITOP_ACCESS_TOKEN);
    }
}
