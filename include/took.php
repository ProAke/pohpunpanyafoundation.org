<?php
require __DIR__ . '/../vendor/autoload.php'; 

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../env/');
$dotenv->load();

try {
    R::setup(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    );

    if (!R::testConnection()) {
        throw new Exception('ไม่สามารถเชื่อมต่อฐานข้อมูลได้');
    }
} catch (Exception $e) {
    echo 'ข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: ' . $e->getMessage();
    exit;
}