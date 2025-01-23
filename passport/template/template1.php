<?php
session_start(); // 启动会话

// 如果 session 中没有 valid_access 标识，说明没有通过合法跳转访问此页面
if (!isset($_SESSION['valid_access']) || $_SESSION['valid_access'] !== true) {
    // 如果没有标识，则禁止访问并跳转到一个错误页面或者首页
    header("Location: /error.php"); // 或者你可以指定其他的错误页面
    exit();
}

// 一旦通过检查，清除会话中的标识，防止直接访问
unset($_SESSION['valid_access']);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page1 NO.001</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <div class="tile large">电话</div>
        <div class="tile medium">消息</div>
        <div class="tile medium">日历</div>
        <div class="tile large">邮件</div>
        <div class="tile medium">相册</div>
        <div class="tile small">设置</div>
        <div class="tile small">天气</div>
        <div class="tile large">浏览器</div>
    </div>
</body>
</html>

