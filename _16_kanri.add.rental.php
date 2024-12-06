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

// 並べ替えと検索処理
$order_by = $_GET['order_by'] ?? 'renral_id';
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM Oasis_rental WHERE purchaser_u_name LIKE :search OR rental_id LIKE :search ORDER BY $order_by";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->execute();
$Oasis_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レンタル商品管理</title>
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
        <li><a>ダッシュボード</a></li>
        <li><a href="_12_kanri.shohin.php">商品追加</a></li>
        <li><a href="_13_kanri.shohindel.php">商品削除</a></li>
        <li><a href="_14_kanri.user.php">ユーザー管理</a></li>
        <li><a href="_15_kanri.add.shohin.php">購入商品管理</a></li>
        <li><a href="_16_kanri.add.rental.php">レンタル商品管理</a></li>
    </ul>
</div>

    <div class="main-content">
        <h1>レンタル商品管理</h1>
        <form method="GET">
            <input type="text" name="search" placeholder="ユーザー名・idなど" value="<?= htmlspecialchars($search, ENT_QUOTES) ?>">
            <button type="submit">検索</button>
            <label for="order_by">並び替え</label>
            <select name="order_by" id="order_by" onchange="this.form.submit()">
                <option value="rental_id" <?= $order_by === 'rental_id' ? 'selected' : '' ?>>標準</option>
                <option value="user_name" <?= $order_by === 'user_name' ? 'selected' : '' ?>>ユーザー名</option>
                <option value="mountain_name" <?= $order_by === 'mountain_name' ? 'selected' : '' ?>>山名</option>
                <option value="rental_date" <?= $order_by === 'rental_date' ? 'selected' : '' ?>>貸出日</option>
                <option value="return_date" <?= $order_by === 'return_date' ? 'selected' : '' ?>>返却日</option>
                <option value="price_per_day" <?= $order_by === 'price_per_day' ? 'selected' : '' ?>>日割り価格</option>
            </select>
        </form>

        <table>
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>id</th>
                    <th>ユーザー名</th>
                    <th>山名</th>
                    <th>貸出日</th>
                    <th>返却日</th>
                    <th>日割り価格</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Oasis_rental as $rental): ?>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><?= htmlspecialchars($rental['rental_id'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($rental['purchaser_u_name'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($rental['yama_name'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($rental['rental_start'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($rental['rental_finish'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars(number_format($rental['order_date']), ENT_QUOTES) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
