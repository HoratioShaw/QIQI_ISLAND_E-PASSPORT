<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QIQI ISLAND PASSPORT</title>
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
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .message-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            padding: 30px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            animation: fade-in 0.6s ease-out;
            transition: transform 0.3s ease;
        }

        .message-card:hover {
            transform: translateY(-5px);
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
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

            .message-card {
                background: #333;
                color: #fff;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            }

            h1 {
                color: #fff;
            }
        }
    </style>
</head>
<body>
    <div class="message-card">
        <h1>请使用 NFC 标签进入</h1>
    </div>
</body>
</html>
