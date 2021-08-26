<?php

namespace app\core;


use app\core\cache\exception\CacheException;
use app\core\cache\ICache;
use app\core\database\Database;
use app\core\environment\Environment;
use app\core\logger\exception\LoggerException;
use app\core\logger\ILogger;
use app\core\module\ModuleManager;
use app\core\request\Request;
use RuntimeException;

final class Application
{
    /** @var \app\core\Application|null объект класса */
    protected static ?Application $instance = null;

    /** @var \app\core\request\Request объект запроса */
    protected Request $request;

    /** @var \app\core\database\Database объект базы данных */
    protected Database $database;

    /** @var \app\core\environment\Environment объект окружения */
    protected Environment $environment;

    /** @var \app\core\logger\ILogger объект логгера */
    protected ILogger $logger;

    /** @var \app\core\cache\ICache объект кэша */
    protected ICache $cache;

    /** @var \app\core\module\ModuleManager объект менеджера модулей */
    protected ModuleManager $moduleManager;

    /** @var string абсолютный путь к корневой директории приложения */
    protected string $absRootDirectory;

    /**
     * Создаёт объект класса.
     *
     * @return static
     * @throws \app\core\logger\exception\LoggerException
     * @throws \app\core\cache\exception\CacheException
     * @throws \app\core\module\exception\ModuleLoaderException
     */
    public static function createInstance(): self
    {
        if (!is_null(self::$instance)) {
            throw new RuntimeException(__CLASS__ . ' has already been created earlier');
        }

        self::$instance = new self();

        return self::$instance->init();
    }

    /**
     * Возвращает объект класса.
     *
     * @return static
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    /**
     * Application constructor.
     */
    protected function __construct()
    {
        $this->environment = new Environment();
        $this->request = new Request();
        $this->database = new Database();
        $this->moduleManager = new ModuleManager();

        $this->absRootDirectory = rtrim(dirname(__DIR__, 2), DIRECTORY_SEPARATOR);
    }

    /**
     * Инициализирует приложение.
     *
     * @throws \app\core\logger\exception\LoggerException
     * @throws \app\core\cache\exception\CacheException
     * @throws \app\core\module\exception\ModuleLoaderException
     */
    protected function init(): self
    {
        $this->environment->init();
        $this->database->connect();

        $this->initLogger();
        $this->initCache();

        $this->moduleManager->init();

        return $this;
    }

    /**
     * Инициализирует логгер.
     *
     * @throws \app\core\logger\exception\LoggerException
     */
    protected function initLogger(): void
    {
        /** @var class-string<ILogger> $loggerClass */
        $loggerClass = $this->environment->getLoggerClass();

        if (!class_exists($loggerClass)) {
            throw new LoggerException("Logger class '{$loggerClass}' not found");
        }

        $this->logger = (new $loggerClass)->init();
    }

    /**
     * Инициализирует кэш.
     *
     * @throws \app\core\cache\exception\CacheException
     */
    protected function initCache(): void
    {
        /** @var class-string<ICache> $cacheClass */
        $cacheClass = $this->environment->getCacheClass();

        if (!class_exists($cacheClass)) {
            throw new CacheException("Cache class '{$cacheClass}' not found");
        }

        $this->cache = (new $cacheClass)->init();
    }

    /**
     * Возвращает абсолютный путь к корневой директории приложения.
     *
     * @return string
     */
    public function getAbsRootDirectory(): string
    {
        return $this->absRootDirectory;
    }

    /**
     * @return \app\core\request\Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return \app\core\database\Database
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }

    /**
     * @return \app\core\environment\Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    /**
     * @return \app\core\logger\ILogger
     */
    public function getLogger(): ILogger
    {
        return $this->logger;
    }

    /**
     * @return \app\core\cache\ICache
     */
    public function getCache(): ICache
    {
        return $this->cache;
    }

    final public function __clone()
    {
    }

    final public function __wakeup()
    {
    }
}