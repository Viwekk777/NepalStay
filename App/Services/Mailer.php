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

        $mail->Subject = 'NepalStay Verification Code';

        $mail->Body = "Your NepalStay verification code is: {$code}";

        $mail->send();
    }
}