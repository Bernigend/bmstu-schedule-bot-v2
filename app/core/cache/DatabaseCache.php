<?php

namespace app\core\cache;

use app\core\Application;
use app\core\database\Database;

class DatabaseCache implements ICache
{
    /** @var \app\core\database\Database */
    protected Database $database;

    /** @inheritDoc */
    public function init(): ICache
    {
        $this->database = Application::getInstance()->getDatabase();

        return $this;
    }

    /** @inheritDoc */
    public function set(string $key, string $value, int $ttl = 3600): void
    {
        $this->database->query(
            "INSERT INTO cache (cache_key, cache_value, ttl) VALUES (:cacheKey, :cacheValue, :ttl)
                 ON DUPLICATE KEY UPDATE cache_value = :cacheValue2, ttl = :ttl2",
            [
                'cacheKey' => $key,
                'cacheValue' => $value,
                'cacheValue2' => $value,
                'ttl' => $ttl,
                'ttl2' => $ttl,
            ]
        );
    }

    /** @inheritDoc */
    public function get(string $key, ?string $defaultValue = null): string
    {
        return $this->database->fetchScalar('SELECT cache_value FROM cache WHERE cache_key = ?', [
            $key,
        ]) ?: $defaultValue;
    }

    /** @inheritDoc */
    public function eraseAll(): void
    {
        $this->database->query("TRUNCATE cache");
    }

    /** @inheritDoc */
    public function eraseExpired(): void
    {
        $this->database->query("DELETE FROM cache WHERE UNIX_TIMESTAMP(created_at) + ttl < UNIX_TIMESTAMP(current_timestamp)");
    }
}