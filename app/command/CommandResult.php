<?php

namespace app\command;

class CommandResult
{
    /** @var string */
    protected string $message;

    /** @var string */
    protected string $error;

    /** @var CommandKeyboard|null */
    protected ?CommandKeyboard $keyboard = null;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return CommandResult
     */
    public function setMessage(string $message): CommandResult
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     * @return CommandResult
     */
    public function setError(string $error): CommandResult
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return CommandKeyboard|null
     */
    public function getKeyboard(): ?CommandKeyboard
    {
        return $this->keyboard;
    }

    /**
     * @param CommandKeyboard|null $keyboard
     * @return CommandResult
     */
    public function setKeyboard(?CommandKeyboard $keyboard): CommandResult
    {
        $this->keyboard = $keyboard;
        return $this;
    }
}