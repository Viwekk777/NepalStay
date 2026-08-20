<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Models\Rooms;
//use App\Exceptions\RoomNotFoundException;

class HomeController


{
    public function __construct(private Rooms $rooms)
    {
        $this->rooms = $rooms;
    }
    public function home()
{
    $rooms = $this->rooms->getAllRooms();

    require_once __DIR__ .'/../../Views/Home.php';
}

    public function about()
    {
           require_once __DIR__ .'/../../Views/about.php';

    }
}