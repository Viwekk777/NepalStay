<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Rooms;
use App\Models\Booking;
use DateTime;
use InvalidArgumentException;
use App\Exceptions\RoomNotFoundException;

class BookingController
{
    public function __construct(
        private Rooms $rooms,
        private Booking $booking
    ) {
    }

    public function checkAvailability(): void
    {
        $checkIn = $_POST['check_in'] ?? null;
        $checkOut = $_POST['check_out'] ?? null;

        $numGuests = filter_input(
            INPUT_POST,
            'num_guests',
            FILTER_VALIDATE_INT
        );

        if (
            !$checkIn ||
            !$checkOut ||
            $numGuests === false ||
            $numGuests === null
        ) {
            throw new InvalidArgumentException(
                'Invalid availability information.'
            );
        }

        $checkInDate = new DateTime($checkIn);
        $checkOutDate = new DateTime($checkOut);

        if ($checkOutDate <= $checkInDate) {
            throw new InvalidArgumentException(
                'Check-out must be after check-in.'
            );
        }

        $rooms = [];

        foreach ($this->rooms->getAllRooms() as $room) {

            if ((int) $room['capacity'] < $numGuests) {
                continue;
            }

            if (
                $this->booking->checkAvailability(
                    (int) $room['id'],
                    $checkInDate,
                    $checkOutDate
                )
            ) {
                $rooms[] = $room;
            }
        }

        require_once __DIR__ . '/../../Views/rooms.php';
    }


    public function book(): void
    {
        require_once __DIR__ . '/../../Views/book.php';
    }


    public function bookRoom(
        int $roomId,
        string $guestName,
        string $guestEmail,
        string $guestPhone,
        int $numGuests,
        DateTime $checkIn,
        DateTime $checkOut
    ): array {

        if (
            !$this->booking->checkAvailability(
                $roomId,
                $checkIn,
                $checkOut
            )
        ) {
            throw new InvalidArgumentException(
                'Room is not available for the selected dates.'
            );
        }

        $room = $this->rooms->getRoomById($roomId);

        if (!$room) {
            throw new RoomNotFoundException($roomId);
        }

        if ($numGuests > (int) $room['capacity']) {
            throw new InvalidArgumentException(
                'Number of guests exceeds room capacity.'
            );
        }

        $nights = $checkIn->diff($checkOut)->days;

        $totalPrice = $nights * (float) $room['price'];

        $bookingId = $this->booking->createBooking(
            $roomId,
            $guestName,
            $guestEmail,
            $guestPhone,
            $numGuests,
            $checkIn,
            $checkOut,
            $totalPrice
        );

        if (!$bookingId) {
            throw new \RuntimeException(
                'Failed to create booking.'
            );
        }

        $booking = $this->booking->getBookingById(
            (int) $bookingId
        );

        if (!$booking) {
            throw new \RuntimeException(
                'Booking was created but could not be retrieved.'
            );
        }

        return $booking;
    }


    public function booked(): void
    {
        $roomId = filter_input(
            INPUT_POST,
            'room_id',
            FILTER_VALIDATE_INT
        );

        $checkIn = $_POST['check_in'] ?? null;
        $checkOut = $_POST['check_out'] ?? null;

        $numGuests = filter_input(
            INPUT_POST,
            'num_guests',
            FILTER_VALIDATE_INT
        );

        $guestName = $_POST['guest_name'] ?? null;
        $guestEmail = $_POST['guest_email'] ?? null;
        $guestPhone = $_POST['guest_phone'] ?? null;

        if (
            $roomId === false ||
            $roomId === null ||
            !$checkIn ||
            !$checkOut ||
            $numGuests === false ||
            $numGuests === null ||
            !$guestName ||
            !$guestEmail ||
            !$guestPhone
        ) {
            throw new InvalidArgumentException(
                'Invalid booking information.'
            );
        }

        $checkInDate = new DateTime($checkIn);
        $checkOutDate = new DateTime($checkOut);

        if ($checkOutDate <= $checkInDate) {
            throw new InvalidArgumentException(
                'Check-out must be after check-in.'
            );
        }

        $booking = $this->bookRoom(
            $roomId,
            $guestName,
            $guestEmail,
            $guestPhone,
            $numGuests,
            $checkInDate,
            $checkOutDate
        );

        require_once __DIR__ . '/../../Views/Booked.php';
    }
}