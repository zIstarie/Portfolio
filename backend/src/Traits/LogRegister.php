<?php

namespace Portfolio\Src\Traits;

use Exception;

trait LogRegister
{
    public function registerLogFile(string $message, Exception $exception): void
    {
        $logFile = fopen('../../logs/' . date('Y-m-d H:i:s') . '-log.txt', 'w');
        $content = "$message. Mensagem de erro: {$exception->getMessage()}";
        fwrite($logFile, $content);
        fclose($logFile);
    }
}

?>
