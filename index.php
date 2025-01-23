<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

$id = $_GET['id'] ?? '';
$token = $_GET['token'] ?? '';
$valid_access_key = $_ENV['VALID_ACCESS_KEY'];

$valid_tokens = array_combine(
    array_map(fn($i) => str_pad($i, 3, '0', STR_PAD_LEFT), range(1, 999)),
    array_map(fn($i) => $_ENV["TOKEN_" . str_pad($i, 3, '0', STR_PAD_LEFT)] ?? '', range(1, 999))
);

if (isset($valid_tokens[$id]) && $valid_tokens[$id] === $token) {
    $_SESSION['valid_access'] = $valid_access_key;
    $pages = [
        "/passport/{$id}/page1.php",
        "/passport/{$id}/page2.php",
        "/passport/{$id}/page3.php"
    ];

    header("Location: " . $pages[array_rand($pages)]);
    exit();
} else {
    header("Location: " . "error.php");
    exit();
}
?>
