<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Models\Rooms;

class HomeController


{
    private Rooms $rooms;
    public function __construct(Rooms $rooms)
    {
        $this->rooms = $rooms;
    }
    
    public function rooms()
    {
      $rooms = $this->rooms->getAllRooms();
      require_once __DIR__ .'/../../Views/rooms.php';

    }
    public function home()
    {
        $rooms = $this->rooms->getAllRooms();
        




       require_once __DIR__ .'/../../Views/Home.php';
    }
    public function getImages()
    {

    }
    public function getRoomById()
    {


    $this->getImages();
    require_once __DIR__ .'/../../Views/roomdetial.php';
    }
}