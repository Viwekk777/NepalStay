<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\PasswordReset;
use App\Services\Mailer;
use Throwable;

final class PasswordResetController
{
    public function __construct(private PasswordReset $resets, private Mailer $mailer) {}

    private function input(string $key): string
    {
        return isset($_POST[$key]) && is_string($_POST[$key]) ? $_POST[$key] : '';
    }

    private function csrf(): string
    {
        return $_SESSION['reset_csrf'] ??= bin2hex(random_bytes(32));
    }

    public function forgot(): void
    {
        header('Cache-Control: no-store');
        $csrf = $this->csrf();
        $errors = [];
        $submitted = false;
        $email = trim($this->input('email'));
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!hash_equals($csrf, $this->input('csrf'))) {
                http_response_code(403);
                $errors[] = 'Your form expired. Please try again.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
                http_response_code(422);
                $errors[] = 'Please enter a valid email address.';
            } else {
                $submitted = true;
                // Session limit also covers requests to many different addresses.
                if ((int) ($_SESSION['reset_last_request'] ?? 0) <= time() - 60) {
                    $_SESSION['reset_last_request'] = time();
                    $token = null;
                    try {
                        $token = $this->resets->issue($email);
                        if ($token !== null) {
                            // Never derive a security-sensitive email URL from an untrusted Host header.
                            $this->mailer->sendPasswordReset($email, 'https://nepalstay.bibeklamsal.tech/reset-password?token=' . $token);
                        }
                    } catch (Throwable $e) {
                        if ($token !== null) {
                            try { $this->resets->deliveryFailed($token); }
                            catch (Throwable $cleanupError) { /* Preserve the original failure category. */ }
                        }
                        // Classify locally; never return raw SMTP/SQL messages or credentials.
                        $category = $e instanceof \PDOException ? 'RESET-STORAGE' : 'MAIL-SEND';
                        $message = strtolower($e->getMessage());
                        if ($message === 'mail_config') $category = 'MAIL-CONFIG';
                        elseif (str_contains($message, 'authenticate')) $category = 'MAIL-AUTH';
                        elseif (str_contains($message, 'connect') || str_contains($message, 'smtp host')) $category = 'MAIL-CONNECTION';
                        error_log('NepalStay recovery failure: ' . $category . '; code=' . (string) $e->getCode());
                        http_response_code(503);
                        $submitted = false;
                        $errors[] = 'We could not complete the reset request. Please wait one minute and try again. If it continues, report this reference: ' . $category . '.';
                    }
                }
            }
        }
        require __DIR__ . '/../../Views/forgot-password.php';
    }

    public function reset(): void
    {
        header('Cache-Control: no-store');
        header('Referrer-Policy: no-referrer');
        $csrf = $this->csrf();
        $errors = [];
        $success = false;
        $token = $_SERVER['REQUEST_METHOD'] === 'POST' ? $this->input('token') : (is_string($_GET['token'] ?? null) ? $_GET['token'] : '');
        try {
            $valid = $this->resets->valid($token);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid) {
                $password = $this->input('password');
                if (!hash_equals($csrf, $this->input('csrf'))) {
                    http_response_code(403);
                    $errors[] = 'Your form expired. Please try again.';
                } elseif (strlen($password) < 8 || strlen($password) > 72 || !preg_match('/[A-Z]/', $password)
                    || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)
                    || !preg_match('/[\W_]/', $password) || preg_match('/\s/', $password)) {
                    http_response_code(422);
                    $errors[] = 'Use 8–72 characters, including uppercase and lowercase letters, a number, and a special character, with no spaces.';
                } elseif ($password !== $this->input('password_confirmation')) {
                    http_response_code(422);
                    $errors[] = 'Passwords do not match.';
                } else {
                    $email = $this->resets->consume($token, $password);
                    $success = $email !== null;
                    $valid = false;
                    if ($success) {
                        $_SESSION = [];
                        if (session_status() === PHP_SESSION_ACTIVE) session_regenerate_id(true);
                        try { $this->mailer->sendPasswordChanged($email); }
                        catch (Throwable $e) { error_log('NepalStay password change notification could not be sent.'); }
                    }
                }
            }
            if (!$valid && !$success) http_response_code(400);
        } catch (Throwable $e) {
            error_log('NepalStay password reset could not be completed.');
            http_response_code(503);
            $valid = false;
            $errors[] = 'Password reset is temporarily unavailable. Please try again shortly.';
        }
        require __DIR__ . '/../../Views/reset-password.php';
    }
}
