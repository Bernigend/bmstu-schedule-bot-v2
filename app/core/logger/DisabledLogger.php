<?php

namespace app\core\logger;

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
    {
        // TODO: Implement write() method.
    }

    /**
     * @inheritDoc
     */
    public function info(string $value)
    {
        // TODO: Implement info() method.
    }

    /**
     * @inheritDoc
     */
    public function warn(string $value)
    {
        // TODO: Implement warn() method.
    }

    /**
     * @inheritDoc
     */
    public function error(string $value)
    {
        // TODO: Implement error() method.
    }
}