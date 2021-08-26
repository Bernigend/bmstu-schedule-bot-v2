<?php

namespace app\core\cache;

class DisabledCache implements ICache
{
    /** @inheritDoc */
    public function init(): ICache
    {
        return $this;
    }

    /** @inheritDoc */
    public function set(string $key, string $value, int $ttl = 3600, string $moduleId = 'no'): void
    {}

    /** @inheritDoc */
    public function get(string $key, ?string $defaultValue = null, string $moduleId = 'no'): string
    {
        return $defaultValue;
    }

    /** @inheritDoc */
    public function eraseAll(string $moduleId = 'no'): void
    {}
}