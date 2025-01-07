<?php
session_start();

// セッション確認：ログイン状態でなければログイン画面へリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: _10_kanri.login.php');
    exit(); // ここで終了しているか確認
}

// アップロード用ディレクトリ
$uploadDir = './uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// アップロード処理
$uploadMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // 許可される拡張子
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = uniqid() . '.' . $fileExtension; // 一意の名前を付ける
        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $uploadMessage = "画像がアップロードされました！";
        } else {
            $uploadMessage = "画像のアップロードに失敗しました。";
        }
    } else {
        $uploadMessage = "許可されていないファイル形式です。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylesheet_3.css">
    <title>ダッシュボード - 画像アップロード</title>
    <style>
        /* グローバルスタイル */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }

        .sidebar .profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: white;
            margin-bottom: 10px;
        }

        .sidebar .profile h3 {
            margin: 0;
            font-size: 18px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            width: 100%;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
        }

        .sidebar .logout {
            margin-top: auto;
            margin-bottom: 20px;
        }

        .sidebar .logout a {
            color: white;
            text-decoration: none;
            background-color: #e74c3c;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
        }

        .sidebar .logout a:hover {
            background-color: #c0392b;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .upload-form {
            text-align: center;
            margin: 20px 0;
        }

        .icons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .icon {
            width: 100px;
            height: 100px;
            border-radius: 30px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        .message {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <!-- サイドバー -->
    <div class="sidebar">
    <ul>
        <li><a href="_12_kanri.shohin.php">商品追加</a></li>
        <li><a href="_13_kanri.shohindel.php">商品削除</a></li>
        <li><a href="_14_kanri.user.php">ユーザー管理</a></li>
        <li><a href="_15_kanri.add.shohin.php">購入商品管理</a></li>
        <li><a href="_16_kanri.add.rental.php">レンタル商品管理</a></li>
    </ul>
</div>

    

    <!-- ヘッダー部分の読み込み（パスを修正） -->
    <?php
    // header.phpが同じディレクトリに存在する場合
    // もし異なる場所にある場合、適切な相対パスまたは絶対パスを指定してください
    include './header.php'; // 修正された     
    ?>

    <!-- コンテンツ部分 -->
    <div class="content">
        <h1>ダッシュボード</h1>
        <div class="dashboard-buttons">
            <div class="button" style="background-color: #3498db;">
                <a href="add_product.php">商品追加</a>
            </div>
            <div class="button" style="background-color: #2ecc71;">
                <a href="delete_product.php">商品削除</a>
            </div>
            <div class="button" style="background-color: #f39c12;">
                <a href="user_info.php">ユーザー情報</a>
            </div>
            <div class="button" style="background-color: #9b59b6;">
                <a href="purchase_management.php">購入商品管理</a>
            </div>
            <div class="button" style="background-color: #e74c3c;">
                <a href="rental_management.php">レンタル商品管理</a>
            </div>
        </div>
    </div>
</body>
</html>
