<?php
require_once __DIR__ . '../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$SESSION_ACCESS = $_ENV['SESSION_TOKEN']

session_start(); // 启动会话

// 如果 session 中没有 valid_access 标识，说明没有通过合法跳转访问此页面
if (!isset($_SESSION[$SESSION_ACCESS]) || $_SESSION[$SESSION_ACCESS] !== true) {
    // 如果没有标识，则禁止访问并跳转到一个错误页面或者首页
    header("Location: /error.php"); // 或者你可以指定其他的错误页面
    exit();
}

// 一旦通过检查，清除会话中的标识，防止直接访问
unset($_SESSION[$SESSION_ACCESS]);
?>
<!-- 目标页面内容开始 -->
<h1>Test Page2 NO.001</h1>
<!-- 目标页面内容结束 -->
