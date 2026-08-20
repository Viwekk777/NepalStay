<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Rooms;
use App\Exceptions\RoomNotFoundException;

class RoomController
{
    public function __construct(private Rooms $rooms)
    {
        $this->rooms = $rooms;
    }

    public function rooms()
    {
        $rooms = $this->rooms->getAllRooms();
        require_once __DIR__ . '/../../Views/rooms.php';
    }

    public function getImages(int $id)
    {
        $images = $this->rooms->getRoomImages($id);
        return $images;
    }

    public function getRoom():void
    {
        
    $id = filter_input(INPUT_GET, 'room_id', FILTER_VALIDATE_INT);

    if ($id === false || $id === null) {
        throw new \InvalidArgumentException('Invalid room ID.');
    }

        $this->getRoomById($id);


    }
    public function getRoomById(int $id)
    {
        $room = $this->rooms->getRoomById($id);

        if (!$room) {
            throw new RoomNotFoundException($id);
        }

        $title = $room['title'];
        $price = $room['price'];
        $capacity = $room['capacity'];
        $amenities = $room['amenities'];

        $images = $this->getImages($id);

        require_once __DIR__ . '/../../Views/roomdetial.php';
    }
}