<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class User
{
    public function __construct(private PDO $db)
    {
    }

    public function registerUser
    (
        string $name,
        string $email,
        string $phone,
        string $password_hash,
    ): int {
        $this->db->beginTransaction();

        try {
            $sql= "INSERT INTO users
            (name, email, phone, password_hash)
            VALUES
            (:name, :email, :phone, :password_hash)";


$stmt = $this->db->prepare($sql);

$stmt->execute
(
    [':name'=>$name, ':email'=>$email, ':phone'=>$phone, ':password_hash'=>$password_hash]
);

$userId = (int) $this->db->lastInsertId();


$this->db->commit();

return $userId;

}
catch (\Throwable $e) {

$this->db->rollBack();

throw $e;
        }
    }

    public function emailExists(string $email): bool
    {
        $sql = 'SELECT 1 FROM users WHERE email = :email LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetchColumn() !== false;
    }
}