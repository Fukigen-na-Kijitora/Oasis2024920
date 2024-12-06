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

// 並び替え設定
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'u_id';
$order_dir = isset($_GET['order_dir']) && $_GET['order_dir'] == 'desc' ? 'desc' : 'asc';

// ユーザー情報取得（並び替え）
$query = "SELECT u_id, u_name, u_mail, registration_date FROM Oasis_user ORDER BY $order_by $order_dir";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_users'])) {
    $delete_ids = $_POST['delete_users'];
    if (!empty($delete_ids)) {
        // 配列を安全に処理して削除
        $placeholders = rtrim(str_repeat('?,', count($delete_ids)), ',');
        $query = "DELETE FROM Oasis_user WHERE u_id IN ($placeholders)";
        $stmt = $pdo->prepare($query);
        $stmt->execute($delete_ids);
    }
    header("Location: " . $_SERVER['PHP_SELF']); // リロード
    exit;
}
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
        <h1>ユーザー情報</h1>

        <!-- 並び替えフォーム -->
        <form method="GET">
            <label for="order_by">並び替え</label>
            <select name="order_by" id="order_by" onchange="this.form.submit()">
                <option value="u_id" <?= $order_by === 'u_id' ? 'selected' : '' ?>>ID</option>
                <option value="u_name" <?= $order_by === 'u_name' ? 'selected' : '' ?>>ユーザー名</option>
                <option value="u_mail" <?= $order_by === 'u_mail' ? 'selected' : '' ?>>メールアドレス</option>
                <option value="registration_date" <?= $order_by === 'registration_date' ? 'selected' : '' ?>>登録日</option>
            </select>

            <!-- 昇順・降順ボタン -->
            <button type="submit" name="order_dir" value="<?= $order_dir === 'asc' ? 'desc' : 'asc' ?>">
                <?= $order_dir === 'asc' ? '降順' : '昇順' ?>
            </button>
        </form>

        <div class="search-box">
            <input type="text" placeholder="ユーザー名・idなど">
            <button>検索</button>
        </div>
        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>ユーザー名</th>
                        <th>メールアドレス</th>
                        <th>登録日</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><input type="checkbox" name="delete_users[]" value="<?= htmlspecialchars($user['u_id']) ?>"></td>
                            <td><?= htmlspecialchars($user['u_id']) ?></td>
                            <td><?= htmlspecialchars($user['u_name']) ?></td>
                            <td><?= htmlspecialchars($user['u_mail']) ?></td>
                            <td><?= htmlspecialchars($user['registration_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="delete-button">削除</button>
        </form>
    </div>

    <script>
        // 「すべて選択」チェックボックスの機能
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="delete_users[]"]');
            for (const checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>
</body>
</html>
