<?php

namespace App\Models;

use Config\Database;
use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id_user = :id_user LIMIT 1");
        $stmt->bindValue(':id_user', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch();
        return $user ?: null;
    }

    // Método para atualização da chave secreta
    public function save2FASecret(int $userId, string $secret): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET two_factor_secret = :secret, two_factor_enabled = TRUE WHERE id_user = :id_user");
        $stmt->bindValue(':secret', $secret);
        $stmt->bindValue(':id_user', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}