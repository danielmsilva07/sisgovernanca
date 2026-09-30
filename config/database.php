<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = '127.0.0.1';
            $port = '5432';
            $dbname = 'sisgovernanca';
            $username = 'postgres'; // Ajuste conforme seu usuário do PostgreSQL
            $password = 'postgres'; // Ajuste conforme sua senha do PostgreSQL

            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

            try {
                self::$instance = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
?>