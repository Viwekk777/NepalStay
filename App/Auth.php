<?php
declare(strict_types=1);
namespace App;

class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }
    public static function userId(): ?int
    {
        if(self::check()===true) {
            return (int)$_SESSION['user_id'];
        }
        return null;
    }
}