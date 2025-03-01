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

    $photoFiles = glob($uploadDir . "/*.{jpg,jpeg,png,gif,bmp}", GLOB_BRACE);
    $photo = !empty($photoFiles) ? basename($photoFiles[0]) : '';
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../favicon.png">
    <title>查看已上传信息</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            background-color: #f4f4f4;
            overflow-y: auto;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .title {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .subtitle {
            margin-bottom: 20px;
            font-size: 16px;
            color: #666;
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
            width: 100%;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ccc;
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

        .info-content {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            white-space: pre-wrap;
            text-align: left;
        }

        .photo-preview {
            margin-top: 20px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            overflow: hidden;
            background-color: #f9f9f9;
            text-align: left;
            min-height: 300px;
            box-sizing: border-box;
        }

        .photo-preview h3,
        .info-content h3 {
            margin-bottom: 10px;
            text-align: left;
            width: 100%;
        }

        .photo-preview img {
            max-width: auto;
            max-height: 200px;
            object-position: center;
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
                </form>
            </div>
        </div>

        <?php if (isset($infoContent)): ?>
            <div class="info-content">
                <h3>订单信息：</h3>
                <pre><?php echo nl2br(htmlspecialchars($infoContent)); ?></pre>
            </div>
            <?php if ($photo): ?>
                <div class="photo-preview">
                    <h3>上传的照片：</h3>
                    <img src="upload/<?php echo $orderNumber . '/' . $photo; ?>" alt="上传的照片">
                </div>
            <?php else: ?>
                <div class="photo-preview">
                    <p>没有上传照片。</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>