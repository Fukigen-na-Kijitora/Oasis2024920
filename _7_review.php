<?php
session_start();

// データベース接続
$pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;dbname=LAA1602729-oasis;charset=utf8', 'LAA1602729', 'oasis5');

// yama_id を POST 経由で取得
if (!isset($_POST['yama_id'])) {
    echo "山のIDが指定されていません。";
    exit;
}
$yama_id = $_POST['yama_id'];

// Oasis_yamaテーブルから山の画像を取得
$sql_yama = "SELECT yama_img FROM Oasis_yama WHERE yama_id = :yama_id";
$stmt_yama = $pdo->prepare($sql_yama);
$stmt_yama->bindParam(':yama_id', $yama_id, PDO::PARAM_INT);

try{
    $stmt_yama->execute();
}catch(PDOException $e) {
    error_log($e->getMessage());
    echo "データベースエラーが発生しました。";
    exit;
}

$yama = $stmt_yama->fetch(PDO::FETCH_ASSOC);

if (!$yama) {
    echo "該当する山が見つかりませんでした。";
    exit;
}

// Oasis_reviewテーブルから該当するレビューをすべて取得
$sql_reviews = "SELECT evaluation, review_date, review_detail, review_img 
                FROM Oasis_review WHERE yama_id = :yama_id ORDER BY review_date DESC";
$stmt_reviews = $pdo->prepare($sql_reviews);
$stmt_reviews->bindParam(':yama_id', $yama_id, PDO::PARAM_INT);

try{
    $stmt_reviews->execute();
}catch(PDOException $e) {
    error_log($e->getMessage());
    echo "レビューの取得中にエラーが発生しました。";
    exit;
}

$reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylesheet_4.css">
    <title>レビュー閲覧</title>
</head>
<body>
    <div class="header-img">
        <a href="./_3_home.php"><img src="./images/oasislogo.jpg" width="100" height="50"></a>
    </div>
    <hr>

    <!-- 山の画像 -->
    <div class="yama-image">
        <img src="<?php echo htmlspecialchars($yama['yama_img']); ?>" alt="山の画像">
    </div>

    <!-- レビューリスト -->
    <div class="review-list">
        <?php if (count($reviews) > 0): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <!-- 星評価 -->
                    <div class="stars">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <?php echo $i < $review['evaluation'] ? '★' : '☆'; ?>
                        <?php endfor; ?>
                    </div>
                    <!-- 投稿日時 -->
                    <span class="review-date"><?php echo htmlspecialchars($review['review_date']); ?></span>
                    <!-- レビュー詳細 -->
                    <p><?php echo nl2br(htmlspecialchars($review['review_detail'])); ?></p>
                    <!-- レビュー画像 -->
                    <?php if (!empty($review['review_img']) && file_exists($review['review_img'])): ?>
                        <img src="<?php echo htmlspecialchars($review['review_img']); ?>" alt="レビュー画像">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>まだレビューがありません。</p>
        <?php endif; ?>
    </div>
</body>
</html>
