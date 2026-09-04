<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Services\Mailer;
use App\Auth;

class UserController
{
    public function __construct(
        private User $user,
        private Mailer $mailer,
        private Booking $booking
    ) {
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../../Views/register.php';
            return;
        }

        // Get form data
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $password = $_POST['password'] ?? null;
        $passwordConfirmation = $_POST['password_confirmation'] ?? null;


        // Start validation
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $errors = [];

        // Validate name
        $name = trim((string) ($name ?? ''));
        if ($name === '') {
            $errors['name'] = 'Name is required.';
        } elseif (mb_strlen($name) < 2) {
            $errors['name'] = 'Name must be at least 2 characters.';
        } elseif (preg_match('/^[\p{L}\s\'\.-]+$/u', $name) !== 1) {
            $errors['name'] = 'Name contains invalid characters.';
        }

        // Validate email
        $email = trim((string) ($email ?? ''));
        if ($email === '') {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please provide a valid email address.';
        }

        // Validate phone
        $phone = trim((string) ($phone ?? ''));
        if ($phone === '') {
            $errors['phone'] = 'Phone number is required.';
        } elseif (preg_match('/^\+?[0-9\s\-]{7,20}$/', $phone) !== 1) {
            $errors['phone'] = 'Please provide a valid phone number.';
        }

        // If there are validation errors, re-show the form with errors and old input
        if (!empty($errors)) {
            $old = ['name' => $name, 'email' => $email, 'phone' => $phone];
            // expose $errors and $old to the view
            require_once __DIR__ . '/../../Views/register.php';
            return;
        }

        // Validate password

        $password = (string) ($password ?? '');
        $passwordConfirmation = (string) ($passwordConfirmation ?? '');

        $minLen = 8;
        $hasMinLen = mb_strlen($password) >= $minLen;
        $hasUpper = preg_match('/[A-Z]/', $password) === 1;
        $hasLower = preg_match('/[a-z]/', $password) === 1;
        $hasDigit = preg_match('/[0-9]/', $password) === 1;
        $hasSpecial = preg_match('/[\W_]/', $password) === 1; // non-word or underscore
        $noSpaces = preg_match('/^\S+$/', $password) === 1;

        if ($password === '') {
            $errors['password'] = 'Password is required.';
        } elseif (!($hasMinLen && $hasUpper && $hasLower && $hasDigit && $hasSpecial && $noSpaces)) {
            $errors['password'] = 'Password must be at least ' . $minLen . ' characters, include upper and lower case letters, a number, and a special character, and contain no spaces.';
        }

        // Check password confirmation
        if ($password !== $passwordConfirmation) {
            $errors['password_confirmation'] = 'Passwords do not match.';
        }

        // If there are validation errors, re-show the form with errors and old input
        if (!empty($errors)) {
            $old = ['name' => $name, 'email' => $email, 'phone' => $phone];
            require_once __DIR__ . '/../../Views/register.php';
            return;
        }

        if ($this->user->emailExists($email)) {
            $errors['email'] = 'Email is already registered.';
            $old = ['name' => $name, 'email' => $email, 'phone' => $phone];
            require_once __DIR__ . '/../../Views/register.php';
            return;
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $verificationCode = (string) random_int(100000, 999999);

        // Store temporary registration data in session
        $_SESSION['pending_registration'] = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password_hash' => $passwordHash,
            'verification_code' => $verificationCode,
            'created_at' => date('c'),
        ];

        try {
            $this->mailer->sendVerificationCode($email, $verificationCode);
        } catch (\Throwable $e) {
            $errors['email'] = 'Failed to send verification email. Please try again.';
            $old = ['name' => $name, 'email' => $email, 'phone' => $phone];
            require_once __DIR__ . '/../../Views/register.php';
            return;
        }



        header('Location: /verify');
        exit();
    }


    public function verifyUser(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../../Views/verify.php';
            return;
        }

        $errors = [];
        $otp = trim((string) ($_POST['otp'] ?? ''));
        $old = ['otp' => $otp];

        if ($otp === '' || preg_match('/^\d{6}$/', $otp) !== 1) {
            $errors['otp'] = 'Please enter a valid 6-digit OTP.';
            require_once __DIR__ . '/../../Views/verify.php';
            return;
        }

        $pendingRegistration = $_SESSION['pending_registration'] ?? null;
        if (!is_array($pendingRegistration)) {
            $errors['otp'] = 'Verification session expired. Please register again.';
            require_once __DIR__ . '/../../Views/verify.php';
            return;
        }

        $expectedOtp = (string) ($pendingRegistration['verification_code'] ?? '');
        if (!hash_equals($expectedOtp, $otp)) {
            $errors['otp'] = 'Invalid verification code.';
            require_once __DIR__ . '/../../Views/verify.php';
            return;
        }

        try {
            $this->user->registerUser(
                name: (string) ($pendingRegistration['name'] ?? ''),
                email: (string) ($pendingRegistration['email'] ?? ''),
                phone: (string) ($pendingRegistration['phone'] ?? ''),
                password_hash: (string) ($pendingRegistration['password_hash'] ?? '')
            );
        } catch (\Throwable $e) {
            $errors['otp'] = 'Could not complete verification. Please try again.';
            require_once __DIR__ . '/../../Views/verify.php';
            return;
        }

        unset($_SESSION['pending_registration']);
        header('Location: /login');
        exit();
    }



    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../../Views/login.php';
            return;
        }

        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $errors = [];
        $old = ['email' => $email];

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }
        if ($password === '') {
            $errors['password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            require_once __DIR__ . '/../../Views/login.php';
            return;
        }

        $user = $this->user->findByEmail($email);
        if (!is_array($user) || !isset($user['password_hash'])) {
            $errors['email'] = 'Invalid email or password.';
            require_once __DIR__ . '/../../Views/login.php';
            return;
        }

        if (!password_verify($password, (string) $user['password_hash'])) {
            $errors['email'] = 'Invalid email or password.';
            require_once __DIR__ . '/../../Views/login.php';
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        header('Location: /');
        exit();

    }

    public function profile(): void
    {
        // index.php starts the session centrally; use Auth helper
        if (!Auth::check()) {
            header('Location: /login');
            exit();
        }

        $userId = Auth::userId();
        $user = null;
        if ($userId !== null) {
            $user = $this->user->findById($userId);
        }

        // Expose $user to the view
        require_once __DIR__ . '/../../Views/profile.php';
    }

    public function myBookings(): void
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit();
        }

        $userId = Auth::userId();
        $user = $userId !== null ? $this->user->findById($userId) : null;
        $bookings = $userId !== null ? $this->booking->getBookingsByUserId($userId) : [];

        require_once __DIR__ . '/../../Views/my-bookings.php';
    }

    public function editProfile(): void
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit();
        }

        $userId = Auth::userId();
        if ($userId === null) {
            header('Location: /login');
            exit();
        }

        $user = $this->user->findById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../../Views/edit-profile.php';
            return;
        }

        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $phone = trim((string) ($_POST['phone'] ?? ''));

        $errors = [];

        if ($name === '') {
            $errors['name'] = 'Name is required.';
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        if ($phone === '') {
            $errors['phone'] = 'Phone number is required.';
        }

        if (!empty($errors)) {
            require_once __DIR__ . '/../../Views/edit-profile.php';
            return;
        }

        if ($user !== null && isset($user['email']) && $email !== (string) $user['email']) {
            $verificationCode = (string) random_int(100000, 999999);
            $_SESSION['pending_profile_update'] = [
                'user_id' => $userId,
                'name' => $name,
                'phone' => $phone,
                'new_email' => $email,
                'verification_code' => $verificationCode,
            ];

            $this->mailer->sendVerificationCode($email, $verificationCode);
            header('Location: /verify-email-change');
            exit();
        }

        $this->user->updateProfile($userId, $name, $email, $phone);

        header('Location: /profile');
        exit();
    }

    public function verifyEmailChange(): void
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit();
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $pending = $_SESSION['pending_profile_update'] ?? null;
        if (!is_array($pending)) {
            header('Location: /profile');
            exit();
        }

        $errors = [];
        $old = [];

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../../Views/verify-email-change.php';
            return;
        }

        $otp = trim((string) ($_POST['otp'] ?? ''));
        $old['otp'] = $otp;

        if ($otp === '' || preg_match('/^\d{6}$/', $otp) !== 1) {
            $errors['otp'] = 'Please enter a valid 6-digit OTP.';
            require_once __DIR__ . '/../../Views/verify-email-change.php';
            return;
        }

        if (!hash_equals((string) ($pending['verification_code'] ?? ''), $otp)) {
            $errors['otp'] = 'Invalid verification code.';
            require_once __DIR__ . '/../../Views/verify-email-change.php';
            return;
        }

        $this->user->updateProfile(
            (int) $pending['user_id'],
            (string) $pending['name'],
            (string) $pending['new_email'],
            (string) $pending['phone']
        );

        unset($_SESSION['pending_profile_update']);
        header('Location: /profile');
        exit();
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        $_SESSION = [];


        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(),
                '',
                time() - 42000,
                $params['path'] ?? '/',
                $params['domain'] ?? '',
                $params['secure'] ?? false,
                $params['httponly'] ?? true
            );
        }


        session_destroy();


        header('Location: /login');
        exit();
    }
}