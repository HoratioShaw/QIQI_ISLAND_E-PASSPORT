<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QIQI ISLAND PASSPORT</title>
    <link rel="icon" href="https://passport.mikey.horatio.cn/favicon.png">
    
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
            background: url('/resource/image/page1/wide.jpg') no-repeat center center/cover;
            padding: 20px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        @media (min-width: 600px) and (max-width: 1024px) and (orientation: portrait) {
            body {
                background: url('/resource/image/page1/narrow.jpg') no-repeat center center/cover;
            }
        }

        @media (max-width: 768px) {
            body {
                background: url('/resource/image/page1/narrow.jpg') no-repeat center center/cover;
            }
        }

        .message-card {
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

        .error {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
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

            .message-card, {
                background: rgba(51, 51, 51, 0.4);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
                color: #fff;
            }

            .error {
                color: #fff;
            }

            footer {
                color: #bbb;
            }
        }
    </style>
</head>
<body>
    <div class="message-card">
        <div class="error"><p>请使用NFC标签进入</p></div>
    </div>

    <footer>© QIQI ISLAND PASSPORT</footer>
</body>
</html>
