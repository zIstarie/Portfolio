<?php

namespace Portfolio\Src\Traits;

trait HTTPResponse
{
    public function send(string $message, int $status)
    {
        http_response_code($status);
        echo json_encode([
            'message' => $message,
            'status' => http_response_code()
        ]);
    }

    public function response(array|object $items, int $status = 200)
    {
        http_response_code($status);
        echo json_encode([
            'data' => $items,
            'status' => http_response_code()
        ]);
    }
}

?>
