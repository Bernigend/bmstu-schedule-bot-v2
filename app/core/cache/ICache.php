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
     * @param string $moduleId ID модуля
     */
    public function set(string $key, string $value, int $ttl = 3600, string $moduleId = 'no'): void;

    /**
     * Вовзвращает значение из кэша по указанному ключу.
     *
     * @param string $key уникальный ключ для сохранения
     * @param string|null $defaultValue значение по умолчанию, если значение не было найдено
     * @param string $moduleId ID модуля
     *
     * @return string
     */
    public function get(string $key, ?string $defaultValue = null, string $moduleId = 'no'): string;

    /**
     * Удаляет весь кэш.
     *
     * @param string $moduleId ID модуля
     *
     * @throws \app\core\cache\exception\CacheException
     */
    public function eraseAll(string $moduleId = 'no'): void;
}