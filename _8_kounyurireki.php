<?php
session_start();

// セッションからユーザーIDを取得
if (!isset($_SESSION['user_id'])) {
    echo "ログインが必要です。";
    exit;
}
$user_id = $_SESSION['user_id'];

try {
    // データベース接続
    $pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;dbname=LAA1602729-oasis;charset=utf8', 'LAA1602729', 'oasis5');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 購入情報を取得 (購入テーブルと山情報をJOIN)
    $purchaseSql = "
        SELECT 
            p.purchaser_country, p.purchaser_user_name, p.u_address, p.payment, p.yama_id, y.yama_name, y.yama_img, y.price
        FROM 
            Oasis_buy p
        INNER JOIN 
            Oasis_yama y ON p.yama_id = y.yama_id
        WHERE 
            p.u_id = :user_id
    ";
    $purchaseStmt = $pdo->prepare($purchaseSql);
    $purchaseStmt->bindParam(':user_id', $user_id);
    $purchaseStmt->execute();
    $purchaseHistory = $purchaseStmt->fetchAll(PDO::FETCH_ASSOC);

    // レンタル情報を取得 (レンタルテーブルと山情報をJOIN)
    $rentalSql = "
        SELECT 
            r.purchaser_country, r.purchaser_u_name, r.u_address, r.u_tell, r.payment, 
            r.rental_start, r.rental_finish, r.yama_id, y.yama_name, y.yama_img, y.dayprice
        FROM 
            Oasis_rental r
        INNER JOIN 
            Oasis_yama y ON r.yama_id = y.yama_id
        WHERE 
            r.u_id = :user_id
    ";
    $rentalStmt = $pdo->prepare($rentalSql);
    $rentalStmt->bindParam(':user_id', $user_id);
    $rentalStmt->execute();
    $rentalHistory = $rentalStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylesheet_4.css">
    <title>購入履歴</title>
</head>
<body>
    <div class="header-img">
        <a href="./_3_home.php"><img src="./images/oasislogo.jpg" width="100" height="50"></a>
    </div>
    <hr>
    <h1>購入履歴</h1>

    <!-- 購入情報表示 -->
    <h2>購入情報</h2>
    <?php if (!empty($purchaseHistory)): ?>
        <table border="1">
            <tr>
                <th>国/地域</th>
                <th>氏名</th>
                <th>住所</th>
                <th>支払方法</th>
                <th>山の名前</th>
                <th>山の画像</th>
                <th>値段</th>
            </tr>
            <?php foreach ($purchaseHistory as $purchase): ?>
                <tr>
                    <td><?= htmlspecialchars($purchase['purchaser_country'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($purchase['purchaser_user_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($purchase['u_address'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($purchase['payment'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($purchase['yama_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><img src="<?= htmlspecialchars($purchase['yama_img'], ENT_QUOTES, 'UTF-8') ?>" alt="山の画像" width="100"></td>
                    <td><?= htmlspecialchars($purchase['price'], ENT_QUOTES, 'UTF-8') ?>円</td>
                    <td>
                    <!-- レビューを書くボタン -->
                        <form action="_6_addreview.php" method="POST">
                            <input type="hidden" name="yama_id" value="<?= htmlspecialchars($purchase['yama_id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="submit" value="レビューを書く">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>購入履歴がありません。</p>
    <?php endif; ?>

    <!-- レンタル情報表示 -->
    <h2>レンタル情報</h2>
    <?php if (!empty($rentalHistory)): ?>
        <table border="1">
            <tr>
                <th>国/地域</th>
                <th>氏名</th>
                <th>住所</th>
                <th>電話番号</th>
                <th>支払方法</th>
                <th>レンタル開始日</th>
                <th>レンタル終了日</th>
                <th>山の名前</th>
                <th>山の画像</th>
                <th>レンタル料金</th>
            </tr>
            <?php foreach ($rentalHistory as $rental): ?>
                <?php 
                    // レンタル日数を計算
                    $rentalStartDate = strtotime($rental['rental_start']);
                    $rentalFinishDate = strtotime($rental['rental_finish']);
                    $rentalDays = ($rentalFinishDate - $rentalStartDate) / (60 * 60 * 24); // 日数を計算

                    // レンタル料金を計算
                    $rentalPrice = $rental['dayprice'] * $rentalDays;
                ?>
                <tr>
                    <td><?= htmlspecialchars($rental['purchaser_country'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($rental['purchaser_u_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($rental['u_address'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($rental['u_tell'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($rental['payment'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= date('Y年m月d日', strtotime($rental['rental_start'])) ?></td>
                    <td><?= date('Y年m月d日', strtotime($rental['rental_finish'])) ?></td>
                    <td><?= htmlspecialchars($rental['yama_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><img src="<?= htmlspecialchars($rental['yama_img'], ENT_QUOTES, 'UTF-8') ?>" alt="山の画像" width="100"></td>
                    <td><?= number_format($rentalPrice) ?>円</td> <!-- 計算されたレンタル料金を表示 -->
                    <td>
                    <!-- レビューを書くボタン -->
                        <form action="_6_addreview.php" method="POST">
                            <input type="hidden" name="yama_id" value="<?= htmlspecialchars($rental['yama_id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="submit" value="レビューを書く">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>レンタル履歴がありません。</p>
    <?php endif; ?>
</body>
</html>
