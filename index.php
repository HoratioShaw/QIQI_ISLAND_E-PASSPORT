<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

$valid_tokens = [
    '001' => $_ENV['TOKEN_001'],
    '002' => $_ENV['TOKEN_002'],
];

if (array_key_exists($id, $valid_tokens) && $valid_tokens[$id] === $token) {
    $pages = [
        "/passport/{$id}/test1.php",
        "/passport/{$id}/test2.php",
        "/passport/{$id}/test3.php"
    ];

    $_SESSION['valid_access'] = true;

    $random_page = $pages[array_rand($pages)];

    header("Location: $random_page");
    exit();
} else {
    echo "Invalid ID or Token.";
}
?>
