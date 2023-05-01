<?php

namespace Portfolio\Src\Traits;

trait HTTPResponse
{
    public function send(string $message, int $status)
    {
        http_response_code($status);
        return json_encode([
            'message' => $message,
            'status' => http_response_code()
        ]);
    }
}

?>
