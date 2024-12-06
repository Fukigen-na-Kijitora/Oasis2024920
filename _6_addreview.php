<?php
session_start();

// ユーザーがログインしていない場合、ログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: ./_2_login.php');
    exit;
}

// データベース接続（PDO）
$pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;dbname=LAA1602729-oasis;charset=utf8', 'LAA1602729', 'oasis5');

// エラーメッセージを保持する変数
$error_message = "";

// 商品IDを取得
$yama_id = $_POST['yama_id'] ?? null;

// フォームデータの処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // フォームデータを検証
    $evaluation = $_POST['evaluation'] ?? null;
    $review_detail = isset($_POST['review_detail']) ? htmlspecialchars($_POST['review_detail'], ENT_QUOTES, 'UTF-8') : null;

    if ($evaluation === null || $review_detail === null) {
        $error_message = "評価とレビュー詳細は必須項目です。すべてのフィールドを入力してください。";
    } else {
        $review_date = date('Y-m-d H:i:s');
        $review_img = null;

        // 画像アップロード処理
        if (isset($_FILES['review_img']) && $_FILES['review_img']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['review_img']['tmp_name'];
            $file_name = basename($_FILES['review_img']['name']);
            $upload_dir = './images/review_imgs/';
            $review_img = $upload_dir . $file_name;

            if (!move_uploaded_file($file_tmp, $review_img)) {
                $error_message = "画像のアップロードに失敗しました。";
            }
        }

        // データベースに保存
        if (empty($error_message)) {
            $sql = "INSERT INTO Oasis_review (yama_id, user_id, evaluation, review_date, review_detail, review_img) 
                    VALUES (:yama_id, :user_id, :evaluation, :review_date, :review_detail, :review_img)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':yama_id', $_POST['yama_id']);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':evaluation', $evaluation);
            $stmt->bindParam(':review_date', $review_date);
            $stmt->bindParam(':review_detail', $review_detail);
            $stmt->bindParam(':review_img', $review_img);

            $stmt->execute();

            header('Location: ./_3_home.php');
            exit;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="ja">
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylesheet_6.css">
    <title>レビュー投稿</title>
</head>
<body>
    <!-- ロゴ -->
    <div class="header-img">
        <a href="./_3_home.php"><img src="./images/oasislogo.jpg" width="100" height="50" alt="Oasis Logo"></a>
    </div>

    <!-- レビュー投稿フォーム -->
    <form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="yama_id" value="<?php echo htmlspecialchars($yama_id ?? ''); ?>">
        <h2>レビューの記入をしよう！</h2>

        <!-- 星評価 -->
        <label for="evaluation">総合評価<span style="color: red;">(必須)</span>:</label>
        <div class="star-rating">
            <input type="radio" name="evaluation" value="5" id="star5" required>
            <label for="star5">★</label>

            <input type="radio" name="evaluation" value="4" id="star4">
            <label for="star4">★</label>

            <input type="radio" name="evaluation" value="3" id="star3">
            <label for="star3">★</label>

            <input type="radio" name="evaluation" value="2" id="star2">
            <label for="star2">★</label>
            
            <input type="radio" name="evaluation" value="1" id="star1">
            <label for="star1">★</label>
        </div>

        <!-- コメント -->
        <label for="review_detail">コメント<span style="color: red;">(必須)</span>:</label>
        <textarea name="review_detail" id="review_detail" required></textarea>

        <!-- 画像アップロード -->
        <label for="review_img">画像アップロード<span style="color: gray;">(任意)</span>:</label>
        <input type="file" name="review_img" id="review_img">

        <!-- 投稿ボタン -->
        <input type="submit" value="レビューを投稿する">
    </form>
</body>
</html>
