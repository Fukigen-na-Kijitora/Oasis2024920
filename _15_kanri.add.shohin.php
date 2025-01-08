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

// 検索と並び替え処理
$order_by = $_GET['order_by'] ?? 'buy_id';
$order_dir = $_GET['order_dir'] ?? 'asc';
$search = $_GET['search'] ?? '';

$sql = "SELECT buy_id, purchaser_user_name, yama_id, order_date, price, purchaser_country 
        FROM Oasis_buy 
        WHERE purchaser_user_name LIKE :search OR buy_id LIKE :search
        ORDER BY $order_by $order_dir";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入商品管理</title>
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
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #2c3e50;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #34495e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        table th {
            background-color: #2c3e50;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <ul>
        <li><a href="_11_kanri.home.php">管理ホーム</a></li>
        <li><a href="_12_kanri.shohin.php">商品追加</a></li>
        <li><a href="_13_kanri.shohindel.php">商品削除</a></li>
        <li><a href="_14_kanri.user.php">ユーザー管理</a></li>
        <li><a href="_15_kanri.add.shohin.php">購入商品管理</a></li>
        <li><a href="_16_kanri.add.rental.php">レンタル商品管理</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>購入商品管理</h1>
    <form method="GET">
        <input type="text" name="search" placeholder="ユーザー名・idなど" value="<?= htmlspecialchars($search, ENT_QUOTES) ?>">
        <button type="submit">検索</button>
        
        <label for="order_by">並び替え</label>
        <select name="order_by" id="order_by" onchange="this.form.submit()">
            <option value="buy_id" <?= $order_by === 'buy_id' ? 'selected' : '' ?>>標準</option>
            <option value="purchaser_user_name" <?= $order_by === 'purchaser_user_name' ? 'selected' : '' ?>>ユーザー名</option>
            <option value="yama_id" <?= $order_by === 'yama_id' ? 'selected' : '' ?>>山ID</option>
            <option value="order_date" <?= $order_by === 'order_date' ? 'selected' : '' ?>>購入日</option>
            <option value="price" <?= $order_by === 'price' ? 'selected' : '' ?>>価格</option>
        </select>

        <!-- 昇順・降順切り替えボタン -->
        <button type="submit" name="order_dir" value="<?= $order_dir === 'asc' ? 'desc' : 'asc' ?>">
            <?= $order_dir === 'asc' ? '降順' : '昇順' ?>
        </button>
    </form>

    <table>
        <thead>
            <tr>
                <th>購入ID</th>
                <th>ユーザー名</th>
                <th>山ID</th>
                <th>購入日</th>
                <th>価格</th>
                <th>国</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['buy_id'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($row['purchaser_user_name'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($row['yama_id'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($row['order_date'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars(number_format($row['price']), ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($row['purchaser_country'], ENT_QUOTES) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>