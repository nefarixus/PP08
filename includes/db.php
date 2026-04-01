<?php

declare(strict_types=1);

function getPDO(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = '127.0.0.1';
    $dbname = 'sidequest';
    $username = 'root';
    $password_db = '';

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password_db,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    return $pdo;
}

function isAdminSession(): bool
{
    return isset($_SESSION['login']) && $_SESSION['login'] === 'admin';
}
