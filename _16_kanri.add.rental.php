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
$order_by = $_GET['order_by'] ?? 'r.rental_id';
$search = $_GET['search'] ?? '';

$sql = "
    SELECT 
        r.rental_id,
        u.user_name AS user_name,
        y.yama_name AS mountain_name,
        r.rental_start,
        r.return_finish,
        y.dayprice
    FROM Oasis_rental r
    JOIN Oasis_user u ON r.u_id = u.u_id
    JOIN Oasis_yama y ON r.yama_id = y.yama_id
    WHERE u.user_name LIKE :search OR y.mountain_name LIKE :search OR r.id LIKE :search
    ORDER BY $order_by";

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
            <input type="text" name="search" placeholder="ユーザー名・山名・idなど" value="<?= htmlspecialchars($search, ENT_QUOTES) ?>">
            <button type="submit">検索</button>
            <label for="order_by">並び替え</label>
            <select name="order_by" id="order_by" onchange="this.form.submit()">
                <option value="r.id" <?= $order_by === 'r.id' ? 'selected' : '' ?>>標準</option>
                <option value="u.user_name" <?= $order_by === 'u.user_name' ? 'selected' : '' ?>>ユーザー名</option>
                <option value="y.mountain_name" <?= $order_by === 'y.mountain_name' ? 'selected' : '' ?>>山名</option>
                <option value="r.rental_date" <?= $order_by === 'r.rental_date' ? 'selected' : '' ?>>貸出日</option>
                <option value="r.return_date" <?= $order_by === 'r.return_date' ? 'selected' : '' ?>>返却日</option>
                <option value="r.daily_price" <?= $order_by === 'r.daily_price' ? 'selected' : '' ?>>日割り価格</option>
            </select>
        </form>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>ユーザー名</th>
                    <th>山名</th>
                    <th>貸出日</th>
                    <th>返却日</th>
                    <th>日割り価格</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($row['user_name'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($row['mountain_name'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($row['rental_date'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($row['return_date'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars(number_format($row['daily_price']), ENT_QUOTES) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
