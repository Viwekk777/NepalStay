<?php
declare(strict_types= 1);   
namespace App\Models;
use PDO;

class Rooms
{
    private PDO $pdo;
    public function __construct(private DB $db){
        $this->pdo = $this->db->getConnection();
    }
public function getAllRooms(): array
{
    $pdo = $this->pdo;

    $stmt = $pdo->query(
        "SELECT rooms.id, rooms.title, rooms.price, rooms.capacity,
                rooms.description,
                room_images.image_path AS main_image
         FROM rooms
         LEFT JOIN room_images
            ON rooms.id = room_images.room_id
            AND room_images.is_primary = 1
         ORDER BY rooms.id ASC"
    );

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);

}
    
public function getRoomById(int $id): array|false
{
    $pdo = $this->db->getConnection();

    $stmt = $pdo->prepare(
        "SELECT id, title, description, price, capacity, amenities
         FROM rooms
         WHERE id = :id"
    );

    $stmt->execute(['id' => $id]);

    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
public function getRoomImages(int $id): array
{
    $pdo = $this->db->getConnection();

    $stmt = $pdo->prepare(
        "SELECT id, image_path, is_primary
         FROM room_images
         WHERE room_id = :room_id
         ORDER BY is_primary DESC, id ASC"
    );

    $stmt->execute(['room_id' => $id]);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}



    



   
    
}