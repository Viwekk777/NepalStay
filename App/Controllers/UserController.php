<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Services\Mailer;

class UserController
{
    public function __construct(
        private User $user,
        private Mailer $mailer
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
        require_once __DIR__ . '/../../Views/login.php';
    }
}