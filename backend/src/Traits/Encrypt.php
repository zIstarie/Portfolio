<?php

namespace Portfolio\Src\Traits;

trait Encrypt
{
    public function randomString(int $length = 32): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function hashString(string|int $password): string
    {
        $prefix = $this->randomString();
        $password = password_hash((string) $password, PASSWORD_BCRYPT);

        return "$prefix:$password";
    }
}

?>
