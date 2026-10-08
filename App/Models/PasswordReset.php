<?php

declare(strict_types=1);
namespace App\Models;

use PDO;
use Throwable;

final class PasswordReset
{
    public function __construct(private PDO $db) {}

    private function prepareStorage(): void
    {
        // Additive, idempotent setup for shared hosting; existing user data is untouched.
        $this->db->exec('CREATE TABLE IF NOT EXISTS password_resets (
            user_id BIGINT PRIMARY KEY, token_hash VARCHAR(64) NOT NULL,
            password_snapshot VARCHAR(255) NOT NULL, email_snapshot VARCHAR(255) NOT NULL,
            expires_at BIGINT NOT NULL, requested_at BIGINT NOT NULL,
            window_start BIGINT NOT NULL, request_count INTEGER NOT NULL
        )');
    }

    private function lockSuffix(): string
    {
        return $this->db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql' ? ' FOR UPDATE' : '';
    }

    public function issue(string $email): ?string
    {
        $this->prepareStorage();
        $now = time();
        $this->db->beginTransaction();
        try {
            // Lock the user as well, including their first reset request.
            $stmt = $this->db->prepare('SELECT id, email, password_hash FROM users WHERE email = :email LIMIT 1' . $this->lockSuffix());
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$user) {
                $this->db->commit();
                return null;
            }
            $stmt = $this->db->prepare('SELECT * FROM password_resets WHERE user_id = :id');
            $stmt->execute(['id' => $user['id']]);
            $previous = $stmt->fetch(PDO::FETCH_ASSOC);
            $sameWindow = $previous && (int) $previous['window_start'] > $now - 3600;
            if ($previous && ((int) $previous['requested_at'] > $now - 60 || ($sameWindow && (int) $previous['request_count'] >= 5))) {
                $this->db->commit();
                return null;
            }
            $token = bin2hex(random_bytes(32));
            $stmt = $this->db->prepare('DELETE FROM password_resets WHERE user_id = :id');
            $stmt->execute(['id' => $user['id']]);
            $stmt = $this->db->prepare('INSERT INTO password_resets
                (user_id, token_hash, password_snapshot, email_snapshot, expires_at, requested_at, window_start, request_count)
                VALUES (:id, :token, :password, :email, :expires, :requested, :window, :count)');
            $stmt->execute([
                'id' => $user['id'], 'token' => hash('sha256', $token),
                'password' => $user['password_hash'], 'email' => $user['email'],
                'expires' => $now + 900, 'requested' => $now,
                'window' => $sameWindow ? $previous['window_start'] : $now,
                'count' => $sameWindow ? (int) $previous['request_count'] + 1 : 1,
            ]);
            $this->db->commit();
            return $token;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            throw $e;
        }
    }

    public function deliveryFailed(string $token): void
    {
        // Match only this attempt; never revoke a newer reset request.
        $stmt = $this->db->prepare('UPDATE password_resets SET expires_at = 0,
            request_count = CASE WHEN request_count > 0 THEN request_count - 1 ELSE 0 END
            WHERE token_hash = :token');
        $stmt->execute(['token' => hash('sha256', $token)]);
    }

    public function valid(string $token): bool
    {
        return $this->lookup($token) !== false;
    }

    private function lookup(string $token): array|false
    {
        if (!preg_match('/^[a-f0-9]{64}$/D', $token)) return false;
        $this->prepareStorage();
        $stmt = $this->db->prepare('SELECT r.*, u.password_hash, u.email FROM password_resets r
            INNER JOIN users u ON u.id = r.user_id WHERE r.token_hash = :token AND r.expires_at > :now');
        $stmt->execute(['token' => hash('sha256', $token), 'now' => time()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row || !hash_equals($row['password_snapshot'], $row['password_hash']) || $row['email_snapshot'] !== $row['email']) return false;
        return $row;
    }

    public function consume(string $token, string $password): ?string
    {
        $row = $this->lookup($token);
        if (!$row) return null;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->db->beginTransaction();
        try {
            // Compare-and-swap plus the live token check prevents concurrent replay/resend races.
            $stmt = $this->db->prepare('UPDATE users SET password_hash = :new
                WHERE id = :id AND password_hash = :old AND email = :email
                AND EXISTS (SELECT 1 FROM password_resets WHERE user_id = :reset_user
                    AND token_hash = :token AND expires_at > :now)');
            $stmt->execute(['new' => $hash, 'id' => $row['user_id'], 'old' => $row['password_snapshot'],
                'email' => $row['email_snapshot'], 'reset_user' => $row['user_id'],
                'token' => hash('sha256', $token), 'now' => time()]);
            if ($stmt->rowCount() !== 1) {
                $this->db->rollBack();
                return null;
            }
            // Preserve the cooldown counters after use, but invalidate the token.
            $stmt = $this->db->prepare('UPDATE password_resets SET expires_at = 0 WHERE user_id = :id');
            $stmt->execute(['id' => $row['user_id']]);
            $this->db->commit();
            return (string) $row['email'];
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            throw $e;
        }
    }
}
