<?php

namespace app\core;


use app\core\cache\exception\CacheException;
use app\core\cache\ICache;
use app\core\database\Database;
use app\core\environment\Environment;
use app\core\logger\exception\LoggerException;
use app\core\logger\ILogger;
use app\core\request\Request;
use app\core\response\Response;
use RuntimeException;
use Throwable;

final class Application
{
    /** @var \app\core\Application|null объект класса */
    protected static ?Application $instance = null;

    /** @var \app\core\request\Request объект запроса */
    protected Request $request;

    /** @var Response объект ответа */
    protected Response $response;

    /** @var \app\core\database\Database объект базы данных */
    protected Database $database;

    /** @var \app\core\environment\Environment объект окружения */
    protected Environment $environment;

    /** @var \app\core\logger\ILogger объект логгера */
    protected ILogger $logger;

    /** @var \app\core\cache\ICache объект кэша */
    protected ICache $cache;

    /** @var string абсолютный путь к корневой директории приложения */
    protected string $absRootDirectory;

    /**
     * Создаёт объект класса.
     *
     * @return static
     * @throws \app\core\logger\exception\LoggerException
     * @throws \app\core\cache\exception\CacheException
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
        $this->response = new Response();
        $this->database = new Database();

        $this->absRootDirectory = rtrim(dirname(__DIR__, 2), DIRECTORY_SEPARATOR);
    }

    /**
     * Инициализирует приложение.
     *
     * @throws \app\core\logger\exception\LoggerException
     * @throws \app\core\cache\exception\CacheException
     */
    protected function init(): self
    {
        $this->initExceptionHandlers();
        $this->environment->init();

        $this->initLogger();
        $this->initSentry();
        $this->database->connect();
        $this->initCache();

        $this->initShutdownActions();

        return $this;
    }

    protected function initExceptionHandlers(): void
    {
        set_error_handler(function ($level, $message, $file, $line) {
            if ($level > E_NOTICE) {
                $this->getLogger()->error("Error [{$level}, {$file}, {$line}]: {$message}");
            }
        });

        set_exception_handler(function (Throwable $e) {
            $this->getLogger()->exception($e);
        });
    }

    protected function initSentry(): void
    {
        $sentryDsn = $this->environment->get('SENTRY_DSN', '');
        if (empty($sentryDsn)) {
            return;
        }

        \Sentry\init([
            'dsn' => $sentryDsn,
            'traces_sample_rate' => (float)$this->environment->get('SENTRY_TRACES_SAMPLE_RATE', '0.0'),
            'environment' => $this->environment->getEnvironmentType(),
            'server_name' => $_SERVER['HTTP_HOST'],
        ]);
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
     * @throws \app\core\cache\exception\CacheException
     */
    protected function initShutdownActions(): void
    {
        register_shutdown_function(function () {
            $this->getCache()->eraseExpired();
        });
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
     * @return \app\core\response\Response
     */
    public function getResponse(): Response
    {
        return $this->response;
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