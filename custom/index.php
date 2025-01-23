<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $wechat = $_POST['wechat'] ?? '';
    $province = $_POST['province'] ?? '';
    $orderNumber = $_POST['order_number'] ?? '';

    if (empty($name) || empty($gender) || empty($birthday) || empty($wechat) || empty($province) || empty($orderNumber)) {
        die('请完整填写所有字段。');
    }

    $uploadDir = __DIR__ . "/uploads/" . $orderNumber;

    // 如果目录已存在，则删除原文件
    if (is_dir($uploadDir)) {
        array_map('unlink', glob($uploadDir . "/*"));
    } else {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($_FILES['photo']['tmp_name'])) {
        // 获取文件的扩展名
        $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        // 生成带时间戳的文件名：order_number_时间戳.扩展名
        $timestamp = time();
        $photoPath = $uploadDir . "/" . $orderNumber . "_" . $timestamp . '.' . $fileExtension;

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            die('上传照片失败。');
        }
    } else {
        die('请上传照片。');
    }

    // 创建并写入信息文件
    $info = "名称: $name\n性别: $gender\n生日: $birthday\n微信号: $wechat\n出生省份: $province\n订单号: $orderNumber\n";
    file_put_contents($uploadDir . "/" . $orderNumber . ".txt", $info);

    echo "<script>alert('上传成功！');window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>信息上传</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* 修复超出显示器顶部的问题 */
            background-color: #f4f4f4;
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
            box-sizing: border-box;
        }
        .title {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .subtitle {
            margin-bottom: 10px;
            font-size: 16px;
            color: #666;
        }
        .form-wrapper {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            width: 100%;
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
        .form-container input, .form-container select, .form-container button {
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
        .button-link {
            display: block;
            margin-top: 15px;
            padding: 10px 0;
            width: 100%;
            text-align: center;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .button-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">上传定制信息</div>
        <div class="subtitle">如需修改，请重新上传</div>
        <a href="view.php" class="button-link">查看已上传信息</a>
        <div class="form-wrapper">
            <div class="form-container">
                <form method="POST" enctype="multipart/form-data">
                    <label for="name">名称</label>
                    <input type="text" id="name" name="name" placeholder="请输入名称" required>
                    
                    <label for="gender">性别</label>
                    <select id="gender" name="gender" required>
                        <option value="">请选择性别</option>
                        <option value="男">男</option>
                        <option value="女">女</option>
                    </select>
                    
                    <label for="birthday">生日（点按年份可快速跳转需要的年份）</label>
                    <input type="date" id="birthday" name="birthday" required>
                    
                    <label for="wechat">微信号</label>
                    <input type="text" id="wechat" name="wechat" placeholder="请输入微信号" required>
                    
                    <label for="province">出生省份</label>
                    <input type="text" id="province" name="province" placeholder="请输入出生省份" required>
                    
                    <label for="order_number">订单号</label>
                    <input type="text" id="order_number" name="order_number" placeholder="请输入订单号" required>
                    
                    <label for="photo">照片（一寸照）</label>
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                    
                    <button type="submit">提交</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
