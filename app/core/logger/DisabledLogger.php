<?php

namespace app\core\logger;

use Throwable;

class DisabledLogger implements ILogger
{
    /**
     * @inheritDoc
     */
    public function init(): ILogger
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function write(string $value, int $type = self::MESSAGE)
    {}

    /**
     * @inheritDoc
     */
    public function info(string $value)
    {}

    /**
     * @inheritDoc
     */
    public function warn(string $value)
    {}

    /**
     * @inheritDoc
     */
    public function error(string $value)
    {}

    public function exception(Throwable $e)
    {}
}