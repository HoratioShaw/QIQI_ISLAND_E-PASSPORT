<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $name = $_POST['name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $wechat = $_POST['wechat'] ?? '';
    $province = $_POST['province'] ?? '';
    $orderNumber = $_POST['order_number'] ?? '';
    $signaturePhoto = $_FILES['signature'] ?? null;

    if ($type === '焦迈奇') {
        if (empty($orderNumber)) {
            die('请填写订单号。');
        }

        $uploadDir = __DIR__ . "/upload/" . $orderNumber;
        if (is_dir($uploadDir)) {
            array_map('unlink', glob($uploadDir . "/*"));
        } else {
            mkdir($uploadDir, 0777, true);
        }

        $info = "类型: 预设\n订单号: $orderNumber\n";
        file_put_contents($uploadDir . "/" . $orderNumber . ".txt", $info);

    } elseif ($type === '定制') {
        if (empty($name) || empty($gender) || empty($birthday) || empty($wechat) || empty($province) || empty($orderNumber)) {
            die('请完整填写所有字段。');
        }

        $uploadDir = __DIR__ . "/upload/" . $orderNumber;
        if (is_dir($uploadDir)) {
            array_map('unlink', glob($uploadDir . "/*"));
        } else {
            mkdir($uploadDir, 0777, true);
        }

        if (!empty($_FILES['photo']['tmp_name'])) {
            $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $timestamp = time();
            $photoPath = $uploadDir . "/avatar_" . $timestamp . '.' . $fileExtension;

            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
                die('上传一寸照失败。');
            }
        } else {
            die('请上传一寸照。');
        }

        if ($signaturePhoto && !empty($signaturePhoto['tmp_name'])) {
            $signatureExtension = pathinfo($signaturePhoto['name'], PATHINFO_EXTENSION);
            $timestamp = time();
            $signaturePath = $uploadDir . "/signature_" . $timestamp . '.' . $signatureExtension;

            if (!move_uploaded_file($signaturePhoto['tmp_name'], $signaturePath)) {
                die('上传签名失败。');
            }
        }

        $info = "类型：定制\n名称: $name\n性别: $gender\n生日: $birthda\n出生地点: $province\n微信号: $wechat\n订单号: $orderNumber\n";
        file_put_contents($uploadDir . "/" . $orderNumber . ".txt", $info);
    }

    echo "<script>alert('上传成功！');window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>信息上传 - QIQI ISLAND PASSPORT</title>
    <link rel="icon" href="../favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;700&display=swap" rel="stylesheet">
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

        .container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            text-align: center;
            width: 90%;
            max-width: 500px;
            animation: fade-in 0.6s ease-out;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        input, select, button {
            width: 100%;
            margin: 8px 0;
            padding: 10px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
        }

        input, select {
            background: rgba(255, 255, 255, 0.6);
        }

        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #0056b3;
        }

        .button-link {
            display: block;
            margin-top: 15px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .button-link:hover {
            background-color: #0056b3;
        }

        label {
            display: block;
            text-align: left;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            color: #000;
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

            .title {
            color: #fff;
            }

            .subtitle {
            color: #fff;
            }

            input, select {
                background: rgba(255, 255, 255, 0.1);
                color: #fff;
            }

            input::placeholder, select::placeholder {
                color: #fff;
            }

            label {
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
        <div class="title">上传信息</div>
        <div class="subtitle">如需修改，请重新上传。<br>如相同订单号内有多份护照，请以订单号-1，订单号-2形式分别上传。</div>
        <a href="view.php" class="button-link">查看已上传信息</a>
        <form method="POST" enctype="multipart/form-data">
            <label for="type">选择类型</label>
            <select id="type" name="type" onchange="toggleFields(this.value)" required>
                <option value="">请选择类型</option>
                <option value="定制">定制</option>
                <option value="焦迈奇">焦迈奇</option>
            </select>

            <div id="customFields" style="display:none;">
                <label for="name">名称</label>
                <input type="text" id="name" name="name" placeholder="名称">
                
                <label for="gender">性别</label>
                <select id="gender" name="gender">
                    <option value="">请选择性别</option>
                    <option value="男">男</option>
                    <option value="女">女</option>
                </select>
                
                <label for="birthday">出生日期</label>
                <input type="date" id="birthday" name="birthday">
                
                <label for="province">出生地点（省份）</label>
                <input type="text" id="province" name="province" placeholder="出生省份">
                
                <label for="wechat">微信号</label>
                <input type="text" id="wechat" name="wechat" placeholder="微信号">
            </div>

            <div id="orderNumberField" style="display:none;">
                <label for="order_number">订单号</label>
                <input type="text" id="order_number" name="order_number" placeholder="订单号" required>
            </div>

            <div id="photoUpload" style="display:none;">
                <label for="photo">一寸照（大小建议3MB内）</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>

            <div id="signatureUpload" style="display:none;">
                <label for="signature">签名照片（可选 不上传默认焦迈奇 大小建议3MB内）</label>
                <input type="file" id="signature" name="signature" accept="image/*">
            </div>

            <button type="submit">提交</button>
        </form>
    </div>
    <footer>© QIQI ISLAND PASSPORT</footer>

    <script>
        function toggleFields(type) {
            if (type === "定制") {
                document.getElementById('customFields').style.display = 'block';
                document.getElementById('photoUpload').style.display = 'block';
                document.getElementById('orderNumberField').style.display = 'block';
                document.getElementById('signatureUpload').style.display = 'block';
            } else if (type === "焦迈奇") {
                document.getElementById('customFields').style.display = 'none';
                document.getElementById('photoUpload').style.display = 'none';
                document.getElementById('orderNumberField').style.display = 'block';
                document.getElementById('signatureUpload').style.display = 'none';
            } else {
                document.getElementById('customFields').style.display = 'none';
                document.getElementById('photoUpload').style.display = 'none';
                document.getElementById('orderNumberField').style.display = 'none';
                document.getElementById('signatureUpload').style.display = 'none';
            }
        }
    </script>
</body>
</html>
