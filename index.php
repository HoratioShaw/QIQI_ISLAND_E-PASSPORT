<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

$id = $_GET['id'] ?? '';
$token = $_GET['token'] ?? '';

$valid_tokens = array_combine(
    array_map(fn($i) => str_pad($i, 3, '0', STR_PAD_LEFT), range(1, 999)),
    array_map(fn($i) => $_ENV["TOKEN_" . str_pad($i, 3, '0', STR_PAD_LEFT)] ?? '', range(1, 999))
);

if (isset($valid_tokens[$id]) && $valid_tokens[$id] === $token) {
    $_SESSION['valid_access'] = true;

    $pages = [
        "/passport/{$id}/test1.php",
        "/passport/{$id}/test2.php",
        "/passport/{$id}/test3.php"
    ];

    header("Location: " . $pages[array_rand($pages)]);
    exit();
} else {
    echo "Invalid ID or Token.";
}
?>
