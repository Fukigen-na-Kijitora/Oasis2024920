<?php
// データベース接続設定
$host = 'localhost'; // データベースホスト名
$dbname = 'your_database_name'; // データベース名
$user = 'your_username'; // ユーザー名
$password = 'your_password'; // パスワード

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
    exit;
}

// ユーザー情報取得
$query = "SELECT id, name, email, registration_date FROM users";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理</title>
    <style>
        /* 全体のスタイル */
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
        .sidebar a:hover {
            text-decoration: underline;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
            background-color: #fff;
        }
        h1 {
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #2c3e50;
            color: #fff;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input[type="text"] {
            padding: 8px;
            width: 300px;
        }
        .search-box button {
            padding: 8px 15px;
            background-color: #2c3e50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .search-box button:hover {
            background-color: #34495e;
        }
        .delete-button {
            padding: 8px 15px;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <!-- サイドバー -->
    <div class="sidebar">
        <h3>山崎 亮佑</h3>
        <a href="#">ダッシュボード</a>
        <a href="#">商品追加</a>
        <a href="#">商品削除</a>
        <a href="#">ユーザー管理</a>
        <a href="#">購入商品管理</a>
        <a href="#">レンタル商品管理</a>
        <a href="#">ログアウト</a>
    </div>

    <!-- メインコンテンツ -->
    <div class="main-content">
        <h1>ユーザー情報</h1>
        <div class="search-box">
            <input type="text" placeholder="ユーザー名・idなど">
            <button>検索</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>ID</th>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>登録日</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><input type="checkbox" value="<?= htmlspecialchars($user['id']) ?>"></td>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['registration_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="delete-button">削除</button>
    </div>
</body>
</html>
