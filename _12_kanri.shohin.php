<?php
// データベース接続設定
$host = 'mysql306.phy.lolipop.lan';
$dbname = 'LAA1602729-oasis';
$user = 'LAA1602729';
$password = 'oasis5';
 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
    exit;
}
 
// フォーム送信処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
 
    // 必須項目のチェック
    $yama_name = trim($_POST['yama_name'] ?? '');
    $country_name = trim($_POST['country_name'] ?? '');
    $Region = $_POST['Region'] ?? null;
    $price = $_POST['price'] ?? '';
    $yama_info = trim($_POST['yama_info'] ?? '');
    $yama_img = '';
 
    if (empty($yama_name)) $errors[] = "山名を入力してください。";
    if (empty($country_name)) $errors[] = "国/地域を入力してください。";
    if ($Region === null) $errors[] = "分類を選択してください。";
    if (empty($price) || !is_numeric($price)) $errors[] = "金額を正しく入力してください。";
    if (empty($yama_info)) $errors[] = "詳細を入力してください。";
 
    // 画像のアップロード処理
    if (isset($_FILES['yama_img']) && $_FILES['yama_img']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $yama_img = $upload_dir . basename($_FILES['yama_img']['name']);
        if (!move_uploaded_file($_FILES['yama_img']['tmp_name'], $yama_img)) {
            $errors[] = "画像アップロードに失敗しました。";
        }
    }
 
    // エラーがある場合は表示して処理終了
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        exit;
    }
 
    // データベースに挿入
    try {
        $stmt = $pdo->prepare("INSERT INTO Oasis_yama (yama_name, country_name, Region, price, yama_img, yama_info)
                               VALUES (:yama_name, :country_name, :Region, :price, :yama_img, :yama_info)");
        $stmt->bindParam(':yama_name', $yama_name);
        $stmt->bindParam(':country_name', $country_name);
        $stmt->bindParam(':Region', $Region);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':yama_img', $yama_img);
        $stmt->bindParam(':yama_info', $yama_info);
        $stmt->execute();
 
        echo "<p style='color:green;'>商品が追加されました！</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>データベースエラー: " . $e->getMessage() . "</p>";
    }
}
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品追加</title>
    <style>
        /* 画面左のダッシュボード */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
 
        .sidebar {
            width: 200px;
            background-color: #2c3e50;
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            box-sizing: border-box;
        }
 
        .sidebar h3 {
            margin-bottom: 30px;
        }
 
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin-bottom: 15px;
        }
 
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
 
        h1 {
            margin-bottom: 20px;
        }
 
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
 
        #input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
 
        .radio-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
 
        .radio-group label {
            margin-right: 20px;
            font-weight: normal;
        }
 
        .radio-group input[type="radio"] {
            margin-right: 5px;
            margin-left: 0;
        }
 
        .radio-group span {
 
            margin-right: 15px;
        }
 
        button {
            background-color: #2c3e50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
       
        button:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <ul>
        <li><a href="_12_kanri.shohin.php">商品追加</a></li>
        <li><a href="_13_kanri.shohindel.php">商品削除</a></li>
        <li><a href="_14_kanri.user.php">ユーザー管理</a></li>
        <li><a href="_15_kanri.add.shohin.php">購入商品管理</a></li>
        <li><a href="_16_kanri.add.rental.php">レンタル商品管理</a></li>
    </ul>
</div>
 
<div class="main-content">
    <h1>商品追加</h1>
    <form method="POST" enctype="multipart/form-data">
       
        <label for="country_name">国/地域</label>
        <input type="text" name="country_name" id="input" required>
 
        <div class="radio-group">
            <label>分類</label>
            <span>
                <input type="radio" name="Region" value="0" id="domestic" required><label for="domestic">国内</label>
                <input type="radio" name="Region" value="1" id="overseas"><label for="overseas">海外</label>
            </span>
        </div>
 
        <label for="yama_name">山名</label>
        <input type="text" name="yama_name" id="input" placeholder="例：○○山" required>
 
        <label for="price">金額</label>
        <input type="number" name="price" id="input" placeholder="例：100000000" required>
 
        <label for="yama_info">詳細</label>
        <textarea name="yama_info" id="input" placeholder="例：日本最高峰の山" rows="4" required></textarea>
 
        <label for="yama_img">画像</label>
        <input type="file" name="yama_img" id="input" accept="image/*" required>
 
        <button type="submit">商品を追加する</button>
    </form>
</div>
</body>
</html>
 
 