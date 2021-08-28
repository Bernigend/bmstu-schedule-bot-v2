<?php

namespace app\core\cache;

interface ICache
{
    /**
     * Инициализирует систему кэширования.
     *
     * @throws \app\core\cache\exception\CacheException
     */
    public function init(): self;

    /**
     * Сохраняет значение по указанному ключу.
     *
     * @param string $key уникальный ключ для сохранения
     * @param string $value значение для сохранения
     * @param int $ttl время жизни кэша
     */
    public function set(string $key, string $value, int $ttl = 3600): void;

    /**
     * Вовзвращает значение из кэша по указанному ключу.
     *
     * @param string $key уникальный ключ для сохранения
     * @param string|null $defaultValue значение по умолчанию, если значение не было найдено
     *
     * @return string
     */
    public function get(string $key, ?string $defaultValue = null): string;

    /**
     * Удаляет весь кэш.
     *
     * @throws \app\core\cache\exception\CacheException
     */
    public function eraseAll(): void;

    /**
     * Удаляет весь истёкший кэш.
     *
     * @throws \app\core\cache\exception\CacheException
     */
    public function eraseExpired(): void;
}