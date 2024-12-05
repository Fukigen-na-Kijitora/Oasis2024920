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

// 削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    if (!empty($_POST['delete_ids'])) {
        $delete_ids = implode(',', array_map('intval', $_POST['delete_ids']));
        $query = "DELETE FROM products WHERE id IN ($delete_ids)";
        $pdo->exec($query);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// 商品情報取得
$query = "SELECT yama_id, yama_name, country_name, price FROM Oasis_yama";
$stmt = $pdo->query($query);
$Oasis_yama = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
    <style>
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
    <ul>
        <li><a>ダッシュボード</a></li>
        <li><a href="_12_kanri.shohin.php">商品追加</a></li>
        <li><a href="_13_kanri.shohindel.php">商品削除</a></li>
        <li><a href="_14_kanri.user.php">ユーザー管理</a></li>
        <li><a href="_15_kanri.add.shohin.php">購入商品管理</a></li>
        <li><a href="_16_kanri.add.rental.php">レンタル商品管理</a></li>
    </ul>
</div>

    <!-- メインコンテンツ -->
    <div class="main-content">
        <h1>商品一覧</h1>
        <form method="POST" action="">
            <div class="search-box">
                <input type="text" placeholder="商品名・国名など">
                <button type="button">検索</button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>商品名</th>
                        <th>国名</th>
                        <th>価格</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Oasis_yama as $product): ?>
                        <tr>
                            <td><input type="checkbox" name="delete_ids[]" value="<?= htmlspecialchars($product['id']) ?>"></td>
                            <td><?= htmlspecialchars($product['yama_id']) ?></td>
                            <td><?= htmlspecialchars($product['yama_name']) ?></td>
                            <td><?= htmlspecialchars($product['country_name']) ?></td>
                            <td><?= htmlspecialchars($product['price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="delete" class="delete-button">削除</button>
        </form>
    </div>

    <script>
        // 全選択/全解除
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="delete_ids[]"]');
            for (const checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>
</body>
</html>

