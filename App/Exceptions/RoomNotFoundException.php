<?php
declare(strict_types= 1);
namespace App\Exceptions;
use Exception;  
Class RoomNotFoundException extends Exception
{
    public function __construct(int $id)
    {
        parent::__construct("Room with {$id} was not found",404);
    }


}