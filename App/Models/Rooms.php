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
        "SELECT
            rooms.id,
            rooms.title,
            rooms.price,
            rooms.capacity,
            rooms.description,
            (
                SELECT ri.image_path
                FROM room_images ri
                WHERE ri.room_id = rooms.id
                ORDER BY ri.is_primary DESC, ri.id ASC
                LIMIT 1
            ) AS main_image
        FROM rooms
        ORDER BY rooms.id ASC"
    );

    $rooms = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    foreach ($rooms as &$room) {
        $room['main_image'] = $this->normalizeImagePath($room['main_image'] ?? null);
    }
    unset($room);

    return $rooms;

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

    $images = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    foreach ($images as &$image) {
        $image['image_path'] = $this->normalizeImagePath($image['image_path'] ?? null);
    }
    unset($image);

    return $images;
}

private function normalizeImagePath(?string $path): ?string
{
    if ($path === null || trim($path) === '') {
        return $path;
    }

    $normalized = str_replace('\\', '/', trim($path));

    if (preg_match('#^https?://#i', $normalized) === 1) {
        return $normalized;
    }

    if (str_starts_with($normalized, '/Assets/images/')) {
        return $normalized;
    }

    if (str_starts_with($normalized, 'Assets/images/')) {
        return '/' . $normalized;
    }

    if (str_starts_with($normalized, '/images/')) {
        return '/Assets' . $normalized;
    }

    if (str_starts_with($normalized, 'images/')) {
        return '/Assets/' . $normalized;
    }

    return '/Assets/images/' . ltrim(basename($normalized), '/');
}



    



   
    
}