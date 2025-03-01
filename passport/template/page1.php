<?php
require_once'../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$valid_access_key = $_ENV['VALID_ACCESS_KEY'];

session_start();

if (!isset($_SESSION['valid_access']) || $_SESSION['valid_access']!== $valid_access_key) {
    header("Location: /error.php");
    exit();
}

unset($_SESSION['valid_access']);

$name = $_ENV['PASSPORT_NAME'];
$number = $_ENV['PASSPORT_NUMBER'];

$imageFiles = glob(__DIR__ . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
$imageUrl = !empty($imageFiles) ? basename($imageFiles[0]) : null;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QIQI ISLAND PASSPORT</title>
    <link rel="icon" href="https://passport.mikey.horatio.cn/favicon.jpg">
    
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Noto Sans SC", "Noto Sans", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: url('../../resource/image/page1/wide.jpg') no-repeat center center/cover;
            padding: 20px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        @media (min-width: 600px) and (max-width: 1024px) and (orientation: portrait) {
            body {
                background: url('../../resource/image/page1/narrow.jpg') no-repeat center center/cover;
            }
        }

        @media (max-width: 768px) {
            body {
                background: url('../../resource/image/page1/narrow.jpg') no-repeat center center/cover;
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            animation: fade-in 0.6s ease-out;
            transition: background 0.3s ease;
        }

        .avatar {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto 10px;
        }

        .name {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }

        .number {
            font-size: 18px;
            color: #333;
        }

        .letter-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #333;
            padding: 20px;
            border-radius: 15px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            margin-top: 20px;
            animation: fade-in 0.8s ease-out;
        }

        .letter-card p {
            font-size: 16px;
            line-height: 1.6;
            text-align: left;
        }

        footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
            text-align: center;
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1e1e1e;
                color: #fff;
            }

            .card, .letter-card {
                background: rgba(51, 51, 51, 0.4);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
                color: #fff;
            }

            .avatar {
                border: 3px solid #444;
            }

            .name {
                color: #fff;
            }

            .number {
                color: #fff;
            }

            footer {
                color: #bbb;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <?php if ($imageUrl): ?>
            <img src="<?php echo $imageUrl; ?>" alt="Avatar" class="avatar">
        <?php endif; ?>
        <div class="name"><?php echo htmlspecialchars($name); ?></div>
        <div class="number"><?php echo htmlspecialchars($number); ?></div>
    </div>

    <div class="letter-card">
        <p>你好，焦迈奇。我是焦迈奇</br>
           替你感到开心，你在22岁的时候，拥有第一张自己的正式专辑</br>
           你做到了，你完成了人生中一个小梦想。</br>
           要记得感谢帮助过你的每一个人，</br>
           感谢此刻拿着这张专辑支持着你的每一个人。</br>
           期待32岁的与我碰面</br>
           那时候的你，</br>
           还是一个唱歌会有山东口音的潍坊小伙。
        </p>
    </div>

    <footer>© QIQI ISLAND PASSPORT</footer>
</body>
</html>
