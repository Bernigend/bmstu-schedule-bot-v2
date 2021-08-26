<?php

namespace app\core\request;

class Request
{
    /**
     * Возвращает GET параметр запроса.
     *
     * @param string $key
     * @param string|null $defaultValue
     *
     * @return string|null
     */
    public function get(string $key, string $defaultValue = null): ?string
    {
        return $_GET[$key] ?? $defaultValue;
    }

    /**
     * Возвращает POST параметр запроса.
     *
     * @param string $key
     * @param string|null $defaultValue
     *
     * @return mixed|string|null
     */
    public function post(string $key, string $defaultValue = null)
    {
        return $_POST[$key] ?? $defaultValue;
    }
}