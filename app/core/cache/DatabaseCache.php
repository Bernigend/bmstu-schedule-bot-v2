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
    public function set(string $key, string $value, int $ttl = 3600, string $moduleId = 'no'): void
    {
        $this->database->query(
            "INSERT INTO cache (cache_key, cache_value, module_id, ttl) VALUES (:cacheKey, :cacheValue, :moduleId, :ttl)
                 ON DUPLICATE KEY UPDATE cache_value = :cacheValue2, ttl = :ttl2",
            [
                'cacheKey' => $key,
                'cacheValue' => $value,
                'cacheValue2' => $value,
                'moduleId' => $moduleId,
                'ttl' => $ttl,
                'ttl2' => $ttl,
            ]
        );
    }

    /** @inheritDoc */
    public function get(string $key, ?string $defaultValue = null, string $moduleId = 'no'): string
    {
        return $this->database->fetchScalar('SELECT cache_value FROM cache WHERE cache_key = ? AND module_id = ?', [$key, $moduleId]) ?: $defaultValue;
    }

    /** @inheritDoc */
    public function eraseAll(string $moduleId = 'no'): void
    {
        $this->database->query("DELETE FROM cache WHERE module_id = ?", [$moduleId]);
    }
}