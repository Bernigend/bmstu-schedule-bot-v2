<?php

namespace app\core\database;


use app\core\Application;
use app\core\database\exception\SqlException;
use PDO;

class Database
{
    /** @var \PDO|null */
    protected ?PDO $connection = null;

    /**
     * Выполняет (и возвращает) подключение к базе данных.
     *
     * @return PDO
     *
     * @throws \PDOException
     */
    public function connect(): PDO
    {
        if (!is_null($this->connection)) {
            return $this->connection;
        }

        $env = Application::getInstance()->getEnvironment();
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $env->getDatabaseHost(),
            $env->getDatabasePort(),
            $env->getDatabaseName(),
            $env->getDatabaseCharset()
        );

        $this->connection = new PDO($dsn, $env->getDatabaseUser(), $env->getDatabasePass(), [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return $this->connection;
    }

    /**
     * Возвращает (и выполняет, в случае необходимости) подключение к базе данных.
     *
     * @return \PDO
     */
    public function getConnection(): PDO
    {
        return $this->connect();
    }

    /**
     * Выполняет запрос к БД.
     *
     * @param string $sql
     * @param array|null $params
     *
     * @return false|\PDOStatement
     * @throws \app\core\database\exception\SqlException
     * @throws \PDOException
     */
    public function query(string $sql, array $params = null)
    {
        if (is_null($params)) {
            return $this->connection->query($sql);
        }

        $preparedSql = $this->connection->prepare($sql);
        if (!$preparedSql) {
            throw new SqlException("Failed to prepare the query for execution: {$preparedSql->errorInfo()[2]}");
        }

        $preparedSql->execute($params);

        return $preparedSql;
    }

    /**
     * Возвращает скалярное значение одного столбца.
     *
     * @param string $sql
     * @param array|null $params
     *
     * @return false|mixed
     * @throws \app\core\database\exception\SqlException
     * @throws \PDOException
     */
    public function fetchScalar(string $sql, array $params = null)
    {
        $raw = $this->query($sql, $params)->fetch();
        if (is_array($raw)) {
            return reset($raw);
        }

        return false;
    }

    /**
     * Возвращает массив значений из строки выборки.
     *
     * @param string $sql
     * @param array|null $params
     *
     * @return array|false|mixed
     * @throws \app\core\database\exception\SqlException
     * @throws \PDOException
     */
    public function fetchRow(string $sql, array $params = null)
    {
        $raw = $this->query($sql, $params)->fetch();
        if (is_array($raw)) {
            return $raw;
        }

        return false;
    }

    /**
     * Возвращает массив значений из строки выборки.
     *
     * @param string $sql
     * @param array|null $params
     *
     * @return array|false
     * @throws \app\core\database\exception\SqlException
     * @throws \PDOException
     */
    public function getAll(string $sql, array $params = null)
    {
        $raw = $this->query($sql, $params)->fetchAll();
        if (is_array($raw)) {
            return $raw;
        }

        return false;
    }

    /**
     * Возвращает ID последнего запроса INSERT.
     * @return string
     */
    public function getLastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }

    /**
     * Возвращает сообщение последней ошибки.
     * @return string
     */
    public function getLastError(): string
    {
        return $this->connection->errorInfo()[2];
    }
}