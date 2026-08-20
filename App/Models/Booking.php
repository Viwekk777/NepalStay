<?php

declare(strict_types=1);

namespace App\Models;

use DateTime;
use PDO;

class Booking
{
    private PDO $pdo;

    public function __construct(private DB $db)
    {
        $this->pdo = $this->db->getConnection();
    }

    public function checkAvailability(int $roomId, DateTime $checkIn, DateTime $checkOut): bool
    {
        $sql = "SELECT COUNT(*) FROM bookings
                WHERE room_id = :room_id
                AND status != 'cancelled'
                AND check_in < :check_out
                AND check_out > :check_in";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'room_id'   => $roomId,
            'check_in'  => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
        ]);

        return (int) $stmt->fetchColumn() === 0;
    }
   public function createBooking(
    int $roomId,
    string $guestName,
    string $guestEmail,
    string $guestPhone,
    int $numGuests,
    DateTime $checkIn,
    DateTime $checkOut,
    float $totalPrice
): bool {

    $sql = "INSERT INTO bookings
            (room_id, guest_name, guest_email, guest_phone,
             num_guests, check_in, check_out, total_price, status)
            VALUES
            (:room_id, :guest_name, :guest_email, :guest_phone,
             :num_guests, :check_in, :check_out, :total_price, 'pending')";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        'room_id'     => $roomId,
        'guest_name'  => $guestName,
        'guest_email' => $guestEmail,
        'guest_phone' => $guestPhone,
        'num_guests'  => $numGuests,
        'check_in'    => $checkIn->format('Y-m-d'),
        'check_out'   => $checkOut->format('Y-m-d'),
        'total_price' => $totalPrice
    ]);
}
public function getBookingById(int $bookingId): array|false
{
    $sql = "SELECT
                bookings.id,
                bookings.room_id,
                rooms.title AS room_title,
                bookings.guest_name,
                bookings.guest_email,
                bookings.guest_phone,
                bookings.num_guests,
                bookings.check_in,
                bookings.check_out,
                bookings.total_price,
                bookings.status,
                bookings.created_at
            FROM bookings
            INNER JOIN rooms
                ON bookings.room_id = rooms.id
            WHERE bookings.id = :id";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        'id' => $bookingId
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}