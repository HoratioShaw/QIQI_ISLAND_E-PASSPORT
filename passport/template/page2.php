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

    <style>
        @font-face {
            font-family: "PingFang SC";
            src: url('https://cdn.jsdelivr.net/npm/pingfang-font@1.0.0/PingFang-SC-Regular.woff2') format('woff2'),
                 url('https://cdn.jsdelivr.net/npm/pingfang-font@1.0.0/PingFang-SC-Regular.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "PingFang SC", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            padding: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            animation: fade-in 0.6s ease-out;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
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
            color: #777;
        }

        .letter-card {
            background: white;
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
                background: linear-gradient(135deg, #2d2d2d, #1e1e1e);
                color: #fff;
            }

            .card, .letter-card {
                background: #333;
                color: #fff;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            }

            .avatar {
                border: 3px solid #444;
            }

            .name {
                color: #fff;
            }

            .number {
                color: #bbb;
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
        <p>“哗啦啦少年再见，回头望一眼，时间像风一样掠过指尖。”</br>每次看到你们在人群中为我挥舞双手，我都会想起这句歌词。时间真的过得好快，但你们的支持和陪伴却一直像星星一样，照亮了我的路。</br></br>“我的名字，在你心里是否还有意义?”</br>其实我知道，答案早已藏在你们的每一次呐喊和微笑里。你们的喜欢让我明白，音乐不仅是我的表达，也是我们之间的桥梁。</br></br>未来的路上，也许会有风雨，但请记住：“我们
都是追光的人，哪怕跌倒也要勇敢前行。”</br>希望你们也能像歌词里那样，永远保持少年的勇气和热情，去追逐属于自己的光。</br></br>感谢你们，让我成为更好的自己。</br>下次见面，我们再一起唱响那些属于我们的歌吧!</p>
    </div>

    <footer>© QIQI ISLAND PASSPORT</footer>
</body>
</html>