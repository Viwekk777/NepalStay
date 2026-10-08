<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Rooms;
use App\Models\Booking;
use DateTime;
use DateTimeZone;
use InvalidArgumentException;
use App\Exceptions\RoomNotFoundException;

class BookingController
{
    public function __construct(private Rooms $rooms, private Booking $booking) {}

    public function checkAvailability(): void
    {
        $errors = [];
        $rooms = [];
        $checkIn = $this->text($_POST, 'check_in');
        $checkOut = $this->text($_POST, 'check_out');
        $numGuests = $this->positiveInteger($_POST, 'num_guests');
        try {
            [$checkInDate, $checkOutDate] = $this->stayDates($checkIn, $checkOut);
            if ($numGuests === null) {
                throw new InvalidArgumentException('Please enter at least one guest.');
            }
            foreach ($this->rooms->getAllRooms() as $room) {
                if ((int) $room['capacity'] >= $numGuests
                    && $this->booking->checkAvailability((int) $room['id'], $checkInDate, $checkOutDate)) {
                    $rooms[] = $room;
                }
            }
        } catch (InvalidArgumentException $e) {
            http_response_code(422);
            $errors[] = $e->getMessage();
        }
        require __DIR__ . '/../../Views/rooms.php';
    }

    public function book(): void
    {
        $this->renderForm($_GET);
    }

    private function renderForm(array $input, array $errors = []): void
    {
        $rooms = $this->rooms->getAllRooms();
        $roomId = $this->positiveInteger($input, 'room_id');
        $checkIn = $this->text($input, 'check_in');
        $checkOut = $this->text($input, 'check_out');
        $numGuests = $this->positiveInteger($input, 'num_guests') ?? 1;
        $guestName = $this->text($input, 'guest_name');
        $guestEmail = $this->text($input, 'guest_email');
        $guestPhone = $this->text($input, 'guest_phone');
        $today = (new DateTime('today', new DateTimeZone('Asia/Kathmandu')))->format('Y-m-d');
        $capacity = null;
        foreach ($rooms as $room) {
            if ((int) $room['id'] === $roomId) {
                $capacity = (int) $room['capacity'];
                break;
            }
        }
        if ($roomId !== null && $capacity === null) {
            $roomId = null;
            $errors[] = 'That room no longer exists. Please choose another room.';
            http_response_code(422);
        }
        if (!$rooms && !$errors) {
            $errors[] = 'No rooms are currently listed. Please contact us to book.';
        }
        require __DIR__ . '/../../Views/book.php';
    }

    public function bookRoom(
        int $roomId, string $guestName, string $guestEmail, string $guestPhone,
        int $numGuests, DateTime $checkIn, DateTime $checkOut, ?int $userId
    ): array {
        if ($roomId < 1 || $numGuests < 1 || $checkOut <= $checkIn) {
            throw new InvalidArgumentException('Please choose a room, valid dates, and at least one guest.');
        }
        $room = $this->rooms->getRoomById($roomId);
        if (!$room) {
            throw new RoomNotFoundException($roomId);
        }
        if ($numGuests > (int) $room['capacity']) {
            throw new InvalidArgumentException('Number of guests exceeds room capacity.');
        }
        if (!$this->booking->checkAvailability($roomId, $checkIn, $checkOut)) {
            throw new InvalidArgumentException('Room is not available for the selected dates. Please choose another room or dates.');
        }
        $totalPrice = $checkIn->diff($checkOut)->days * (float) $room['price'];
        $bookingId = $this->booking->createBooking(
            $roomId, $guestName, $guestEmail, $guestPhone, $numGuests,
            $checkIn, $checkOut, $totalPrice, $userId
        );
        if (!$bookingId) {
            throw new \RuntimeException('Failed to create booking.');
        }
        $booking = $this->booking->getBookingById($bookingId);
        if (!$booking) {
            throw new \RuntimeException('Booking was created but could not be retrieved.');
        }
        return $booking;
    }

    public function booked(): void
    {
        $roomId = $this->positiveInteger($_POST, 'room_id');
        $numGuests = $this->positiveInteger($_POST, 'num_guests');
        $checkIn = $this->text($_POST, 'check_in');
        $checkOut = $this->text($_POST, 'check_out');
        $guestName = $this->text($_POST, 'guest_name');
        $guestEmail = $this->text($_POST, 'guest_email');
        $guestPhone = $this->text($_POST, 'guest_phone');
        try {
            if ($roomId === null || $numGuests === null || $guestName === '') {
                throw new InvalidArgumentException('Please choose a room, enter at least one guest, and provide your name.');
            }
            if (!filter_var($guestEmail, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException('Please enter a valid email address.');
            }
            $guestPhone = str_replace([' ', '-'], '', $guestPhone);
            if (preg_match('/^\+?[0-9]{7,15}$/', $guestPhone) !== 1) {
                throw new InvalidArgumentException('Please enter a valid phone number (7–15 digits, optionally starting with +).');
            }
            [$checkInDate, $checkOutDate] = $this->stayDates($checkIn, $checkOut);
            $userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
            $booking = $this->bookRoom(
                $roomId, $guestName, $guestEmail, $guestPhone, $numGuests,
                $checkInDate, $checkOutDate, $userId
            );
        } catch (InvalidArgumentException $e) {
            http_response_code(422);
            $this->renderForm($_POST, [$e->getMessage()]);
            return;
        } catch (RoomNotFoundException $e) {
            http_response_code(422);
            $this->renderForm($_POST, ['That room no longer exists. Please choose another room.']);
            return;
        } catch (\Throwable $e) {
            error_log('NepalStay booking: ' . $e->getMessage());
            http_response_code(500);
            $this->renderForm($_POST, ['We could not complete your reservation. Please contact us before trying again.']);
            return;
        }
        require __DIR__ . '/../../Views/Booked.php';
    }

    private function text(array $input, string $key): string
    {
        return isset($input[$key]) && is_string($input[$key]) ? trim($input[$key]) : '';
    }

    private function positiveInteger(array $input, string $key): ?int
    {
        $value = $input[$key] ?? null;
        if (!is_string($value) && !is_int($value)) {
            return null;
        }
        $result = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        return $result === false ? null : $result;
    }

    private function stayDates(string $checkIn, string $checkOut): array
    {
        $zone = new DateTimeZone('Asia/Kathmandu');
        $dates = [];
        foreach ([$checkIn, $checkOut] as $value) {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) !== 1) {
                throw new InvalidArgumentException('Please enter valid check-in and check-out dates.');
            }
            $date = DateTime::createFromFormat('!Y-m-d', $value, $zone);
            $errors = DateTime::getLastErrors();
            if (!$date || ($errors !== false && ($errors['warning_count'] || $errors['error_count']))
                || $date->format('Y-m-d') !== $value) {
                throw new InvalidArgumentException('Please enter valid check-in and check-out dates.');
            }
            $dates[] = $date;
        }
        if ($dates[0] < new DateTime('today', $zone)) {
            throw new InvalidArgumentException('Check-in cannot be in the past.');
        }
        if ($dates[1] <= $dates[0]) {
            throw new InvalidArgumentException('Check-out must be after check-in.');
        }
        return $dates;
    }
}
