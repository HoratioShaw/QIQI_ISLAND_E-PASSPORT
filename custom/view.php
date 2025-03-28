<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderNumber = $_POST['order_number'] ?? '';

    if (empty($orderNumber)) {
        echo "<script>alert('请填写订单号！'); window.location.href='';</script>";
        exit;
    }

    $uploadDir = __DIR__ . "/upload/" . $orderNumber;

    if (!is_dir($uploadDir)) {
        echo "<script>alert('订单号未找到，请确认是否上传过或订单号是否正确！'); window.location.href='';</script>";
        exit;
    }

    $infoFile = $uploadDir . "/" . $orderNumber . ".txt";
    $infoContent = file_exists($infoFile) ? file_get_contents($infoFile) : '';

    function convertToPng($filePath) {
        $pathInfo = pathinfo($filePath);
        $pngFile = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.png';

        if (!file_exists($pngFile)) {
            $mimeType = mime_content_type($filePath);

            if ($mimeType === 'image/heif' || $mimeType === 'image/heic') {
                $command = "ffmpeg -f hevc -i " . escapeshellarg($filePath) . " " . escapeshellarg($pngFile) . " -y 2>&1";
            } else {
                $command = "ffmpeg -i " . escapeshellarg($filePath) . " " . escapeshellarg($pngFile) . " -y 2>&1";
            }

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                $command = "convert " . escapeshellarg($filePath) . " " . escapeshellarg($pngFile);
                exec($command, $output, $returnVar);
            }

            // file_put_contents("ffmpeg_log.txt", "Command: $command\nOutput:\n" . implode("\n", $output) . "\nReturn Code: $returnVar\n", FILE_APPEND);

            if ($returnVar === 0 && file_exists($pngFile)) {
                unlink($filePath);
            }
        }

        return basename($pngFile);
    }

    $photoFiles = glob($uploadDir . "/avatar*", GLOB_BRACE);
    $photo = !empty($photoFiles) ? convertToPng($photoFiles[0]) : '';

    $signatureFiles = glob($uploadDir . "/signature*", GLOB_BRACE);
    $signaturePhoto = !empty($signatureFiles) ? convertToPng($signatureFiles[0]) : '';
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../resource/images/favicon/favicon.png">
    <title>查看已上传信息 - QIQI ISLAND PASSPORT</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: url('../../resource/images/page1/wide.jpg') no-repeat center center/cover;
            padding: 20px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        @media (min-width: 600px) and (max-width: 1024px) and (orientation: portrait) {
            body {
                background: url('../../resource/images/page1/narrow.jpg') no-repeat center center/cover;
            }
        }

        @media (max-width: 768px) {
            body {
                background: url('../../resource/images/page1/narrow.jpg') no-repeat center center/cover;
            }
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 500px;
            animation: fade-in 0.6s ease-out;
            transition: background 0.3s ease;
        }

        .title {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .subtitle {
            margin-bottom: 20px;
            font-size: 16px;
            color: #333;
        }

        .form-wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-bottom: 20px;
        }

        .form-container {
            flex: 1;
        }

        .form-container label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input, .form-container button {
            background: rgba(255, 255, 255, 0.6);
            width: 100%;
            margin: 5px 0;
            padding: 10px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .form-container .reupload-button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin-top: 10px;
            border: none;
        }

        .form-container .reupload-button:hover {
            background-color: #0056b3;
        }

        .info-content,
        .photo-preview {
            margin-top: 20px;
            padding: 15px;
            border-radius: 15px;
            width: 100%;
            box-sizing: border-box;
            white-space: pre-wrap;
            text-align: left;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .photo-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
        }

        .photo-preview .photo-item {
            text-align: center;
            margin-bottom: 20px;
            width: 100%;
        }

        .photo-preview h3 {
            margin-bottom: 10px;
            text-align: center;
        }

        .photo-preview img {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            object-position: center;
            margin: 0 auto;
            display: block;
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

            .container {
                background: rgba(51, 51, 51, 0.4);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
                color: #fff;
            }

            .title, .subtitle {
                color: #fff;
            }

            .form-container input {
                background: rgba(255, 255, 255, 0.1);
                color: #fff;
            }
            .form-container input::placeholder {
                color: #fff;
            }
            footer {
                color: #bbb;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">查看已上传信息</div>
        <div class="subtitle">如需修改请返回上一页面重新上传</div>
        <div class="form-wrapper">
            <div class="form-container">
                <form method="POST">
                    <label for="order_number">订单号</label>
                    <input type="text" id="order_number" name="order_number" placeholder="请输入订单号" required>
                    <button type="submit">查看</button>
                    <a href="index.php">
                        <button type="button" class="reupload-button">重新上传信息</button>
                    </a>
                </form>
            </div>
        </div>

        <?php if (isset($infoContent)): ?>
            <div class="info-content">
                <h3>订单信息：</h3>
                <pre><?php echo nl2br(htmlspecialchars($infoContent)); ?></pre>
            </div>
            <div class="photo-preview">
                <?php if ($photo): ?>
                    <div class="photo-item">
                        <h3>上传的头像：</h3>
                        <img src="upload/<?php echo $orderNumber . '/' . $photo; ?>" alt="上传的头像">
                    </div>
                <?php else: ?>
                    <div class="photo-item">
                        <h3>没有上传头像。</h3>
                    </div>
                <?php endif; ?>

                <?php if ($signaturePhoto): ?>
                    <div class="photo-item">
                        <h3>上传的签名：</h3>
                        <img src="upload/<?php echo $orderNumber . '/' . $signaturePhoto; ?>" alt="签名照片">
                    </div>
                <?php else: ?>
                    <div class="photo-item">
                        <h3>没有上传签名。</h3>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <footer>© QIQI ISLAND PASSPORT</footer>
</body>
</html>
