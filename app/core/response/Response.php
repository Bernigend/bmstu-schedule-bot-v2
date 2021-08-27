<?php

namespace app\core\response;

class Response
{
    public function sendAndContinueScript(string $response): void
    {
        // Prevent echo, print, and flush from killing the script
        ignore_user_abort(true);

        echo $response;

        $size = strlen($response);

        // Disable compression (in case content length is compressed).
        header("Content-Encoding: none");

        // Set the content length of the response.
        header("Content-Length: {$size}");

        // Close the connection.
        header("Connection: close");

        ob_start();

        // Flush all output.
        ob_end_flush();
        @ob_flush();
        flush();

        // Close current session (if it exists).
        if(session_id()) session_write_close();

        if (is_callable('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }
}