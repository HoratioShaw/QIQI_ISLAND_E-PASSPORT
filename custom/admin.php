<?php
require_once'../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || 
    $_SERVER['PHP_AUTH_USER'] !== $_ENV['USERNAME'] || $_SERVER['PHP_AUTH_PW'] !== $_ENV['PASSWORD']) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    echo '需要密码才能访问此页面';
    exit;
}

$isDarkMode = isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark';

$uploadDir = 'upload/';

$folders = array_filter(glob($uploadDir . '*'), 'is_dir');

usort($folders, function ($a, $b) {
    return filemtime($b) - filemtime($a);
});

echo '<!DOCTYPE html>';
echo '<html lang="zh">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>定制信息总览 - QIQI ISLAND PASSPORT</title>';
echo '<link rel="icon" href="../resource/image/favicon/favicon.png">';

echo '<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&family=Noto+Sans+SC&display=swap" rel="stylesheet">';

echo '<style>';
echo 'body { font-family: "Noto Sans SC", "Noto Sans", sans-serif; background: url("../../resource/image/page1/wide.jpg") no-repeat center center/cover; color: ' . ($isDarkMode ? '#f1f1f1' : '#333') . '; margin: 0; padding: 0; display: flex; justify-content: center; flex-wrap: wrap; }';

echo '@media (min-width: 600px) and (max-width: 1024px) and (orientation: portrait) {';
echo '    body {';
echo '        background: url("../../resource/image/page1/narrow.jpg") no-repeat center center/cover;';
echo '    }';
echo '}';

echo '@media (max-width: 768px) {';
echo '    body {';
echo '        background: url("../../resource/image/page1/narrow.jpg") no-repeat center center/cover;';
echo '    }';
echo '}';

echo '.order-card { background: rgba(255, 255, 255, 0.1); border-radius: 20px; width: 300px; padding: 20px; margin: 10px; backdrop-filter: blur(10px); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); transition: 0.3s ease-in-out; }';
echo '.order-card.dark-mode { background: rgba(51, 51, 51, 0.8); backdrop-filter: blur(10px) contrast(80%); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7); }';
echo '.order-card h2 { font-size: 20px; font-weight: bold; margin-bottom: 10px; }';
echo '.order-card p { font-size: 14px; margin: 5px 0; }';

echo '.order-card img { max-width: 100%; margin-top: 10px; }';

echo '.no-signature { display: flex; justify-content: center; align-items: center; height: 200px; font-size: 18px; font-weight: bold; }';

echo '</style>';
echo '</head>';
echo '<body>';

foreach ($folders as $folder) {
    $txtFiles = glob($folder . '/*.txt');
    
    if (count($txtFiles) > 0) {
        $txtContent = file_get_contents($txtFiles[0]);
        $txtContent = mb_convert_encoding($txtContent, 'UTF-8', 'auto'); 

        $txtContent = str_replace('：', ':', $txtContent);

        $lines = explode("\n", $txtContent);
        $data = [];

        foreach ($lines as $line) {
            if (preg_match('/^类型\s*[:]\s*(.+)$/', $line, $matches)) {
                $data['type'] = trim($matches[1]);
            }
            if (preg_match('/^订单号\s*[:]\s*(.+)$/', $line, $matches)) {
                $data['order_number'] = trim($matches[1]);
            }
            if (preg_match('/^名称\s*[:]\s*(.+)$/', $line, $matches)) {
                $data['name'] = trim($matches[1]);
            }
            if (preg_match('/^性别\s*[:]\s*(.+)$/', $line, $matches)) {
                $data['gender'] = trim($matches[1]);
            }
            if (preg_match('/^生日\s*[:]\s*(.+)$/', $line, $matches)) {
                $data['birthday'] = trim($matches[1]);
            }
            if (preg_match('/^出生地点\s*[:]\s*(.+)$/', $line, $matches)) {
                $data['birthplace'] = trim($matches[1]);
            }
            if (preg_match('/^微信号\s*[:]\s*(.+)$/', $line, $matches)) {
                $data['wechat'] = trim($matches[1]);
            }
        }

        echo '<div class="order-card ' . ($isDarkMode ? 'dark-mode' : '') . '">';
        if (isset($data['order_number'])) {
            echo "<h2>订单号: {$data['order_number']}</h2>";
        }

        if (isset($data['type'])) {
            echo "<p>类型: {$data['type']}</p>";
        }

        if (isset($data['name'])) {
            echo "<p>名称: {$data['name']}</p>";
        }

        if (isset($data['gender'])) {
            echo "<p>性别: {$data['gender']}</p>";
        }

        if (isset($data['birthday'])) {
            echo "<p>生日: {$data['birthday']}</p>";
        }

        if (isset($data['birthplace'])) {
            echo "<p>出生地点: {$data['birthplace']}</p>";
        }

        if (isset($data['wechat'])) {
            echo "<p>微信号: {$data['wechat']}</p>";
        }

        if (isset($data['type']) && $data['type'] === '定制') {
            $avatarFiles = glob($folder . '/avatar*');
            if (count($avatarFiles) > 0) {
                echo "<h3>头像:</h3>";
                echo "<img src='{$avatarFiles[0]}' alt='Avatar'><br>";
            }

            $signatureFiles = glob($folder . '/signature*');
            if (count($signatureFiles) > 0) {
                echo "<h3>签名:</h3>";
                echo "<img src='{$signatureFiles[0]}' alt='Signature'><br>";
            } else {
                echo "<div class='no-signature'>没有签名图片</div>";
            }
        }
        echo '</div>';
    }
}

echo '</body>';
echo '</html>';
?>
