<?php

namespace classes;

class ValidatorForm
{
    public static function checkEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function checkInputLength(string $input, int $length): bool
    {
        return strlen($input) >= $length;
    }

}