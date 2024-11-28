<?php
session_start();

// ユーザーがログインしていない場合、ログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: /_2_login.php');
    exit;
}

// データベース接続（PDO）
$pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;dbname=LAA1602729-oasis;charset=utf8', 'LAA1602729', 'oasis5');

// フォームデータの処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // セッションから user_id を取得
    $user_id = $_SESSION['user_id'];

    // フォームデータを取得
    $yama_id = $_POST['yama_id']; // 選択された山のID
    $evaluation = $_POST['evaluation']; // 星の評価
    $review_detail = htmlspecialchars($_POST['review_detail'], ENT_QUOTES, 'UTF-8'); // コメント
    $review_date = date('Y-m-d H:i:s'); // 現在の日時

    // 画像がアップロードされている場合、処理
    $review_img = null;
    if (isset($_FILES['review_img']) && $_FILES['review_img']['error'] === 0) {
        $file_tmp = $_FILES['review_img']['tmp_name'];
        $file_name = basename($_FILES['review_img']['name']);
        $upload_dir = '../images/review_imgs/';
        $review_img = $upload_dir . $file_name;
        move_uploaded_file($file_tmp, $review_img);
    }

    // レビューをデータベースに挿入
    $sql = "INSERT INTO Oasis_review (yama_id, user_id, evaluation, review_date, review_detail, review_img) 
            VALUES (:yama_id, :user_id, :evaluation, :review_date, :review_detail, :review_img)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':yama_id', $yama_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':evaluation', $evaluation);
    $stmt->bindParam(':review_date', $review_date);
    $stmt->bindParam(':review_detail', $review_detail);
    $stmt->bindParam(':review_img', $review_img);

    $stmt->execute();

    echo "レビューが投稿されました。";
    header('Location: _3_home.php');
    exit;
}

// 商品IDを取得
$yama_id = $_POST['yama_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylesheet_4.css">
    <title>レビュー投稿</title>
</head>
<body>
    <div class="header-img">
        <a href="./_3_home.php"><img src="./images/oasislogo.jpg" width="100" height="50"></a>
    </div>
    <hr>

    <h2>レビューを投稿する</h2>

    <!-- 評価フォーム -->
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="yama_id" value="<?php echo htmlspecialchars($yama_id); ?>"> <!-- yama_idをhiddenで送信 -->

        <label for="evaluation">評価:</label>
        <div class="star-rating">
            <input type="radio" name="evaluation" value="5" id="star5"><label for="star5">★</label>
            <input type="radio" name="evaluation" value="4" id="star4"><label for="star4">★</label>
            <input type="radio" name="evaluation" value="3" id="star3"><label for="star3">★</label>
            <input type="radio" name="evaluation" value="2" id="star2"><label for="star2">★</label>
            <input type="radio" name="evaluation" value="1" id="star1"><label for="star1">★</label>
        </div>

        <br><br>

        <label for="review_detail">レビュー詳細:</label>
        <textarea name="review_detail" id="review_detail" rows="5" required></textarea>
        
        <br><br>

        <label for="review_img">レビュー画像（任意）:</label>
        <input type="file" name="review_img" id="review_img">

        <br><br>

        <input type="submit" value="レビューを投稿する">
    </form>

</body>
</html>
