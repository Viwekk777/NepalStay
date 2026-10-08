<?php

declare(strict_types=1);

namespace App\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public function sendVerificationCode(
        string $email,
        string $code
    ): void {
        $this->send($email, 'NepalStay Verification Code', "Your NepalStay verification code is: {$code}");
    }

    public function sendPasswordReset(string $email, string $url): void
    {
        $this->send($email, 'Reset your NepalStay password',
            "A password reset was requested for your NepalStay account.\n\nOpen this link to choose a new password:\n{$url}\n\nThis link expires in 15 minutes and can be used once. If you did not request this, you can ignore this email; your password has not changed.");
    }

    public function sendPasswordChanged(string $email): void
    {
        $this->send($email, 'Your NepalStay password was changed',
            "Your NepalStay password has been changed. Existing signed-in sessions will be signed out. If this was not you, use Forgot password on the NepalStay sign-in page to recover your account.");
    }

    private function send(string $email, string $subject, string $body): void
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->Port = (int) $_ENV['MAIL_PORT'];

        $mail->setFrom(
            $_ENV['MAIL_FROM'],
            $_ENV['MAIL_FROM_NAME']
        );

        $mail->addAddress($email);

        $mail->Subject = $subject;

        $mail->Body = $body;

        $mail->send();
    }
}
