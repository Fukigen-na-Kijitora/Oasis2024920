<?php
session_start();
 

// ユーザーがログインしていない場合、ログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: /_2_login.php');
    exit;
}
 
// ユーザーIDを取得
$user_id = $_SESSION['user_id'];
 
// データベース接続（PDO）
$pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;dbname=LAA1602729-oasis;charset=utf8', 'LAA1602729', 'oasis5');
 
// POSTされたデータがあれば購入処理を実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // フォームデータを取得 (issetでチェック)
        $u_address = isset($_POST['u_address']) ? htmlspecialchars($_POST['u_address'], ENT_QUOTES, 'UTF-8') : '';
        $purchaser_country = isset($_POST['purchaser_country']) ? htmlspecialchars($_POST['purchaser_country'], ENT_QUOTES, 'UTF-8') : '';
        $purchaser_user_name = isset($_POST['purchaser_user_name']) ? htmlspecialchars($_POST['purchaser_user_name'], ENT_QUOTES, 'UTF-8') : '';
        $payment = isset($_POST['payment']) ? htmlspecialchars($_POST['payment'], ENT_QUOTES, 'UTF-8') : '';
        $yama_id = isset($_POST['yama_id']) ? $_POST['yama_id'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
 
        // フォームデータがすべて存在するかチェック
        if ($u_address && $purchaser_country && $purchaser_user_name && $payment && $yama_id && $price) {
            // 注文情報をデータベースに保存
            $sql = "INSERT INTO Oasis_buy (u_id, yama_id, payment, order_date, price, purchaser_country, purchaser_user_name, u_address) 
                    VALUES (:u_id, :yama_id, :payment, CURDATE(), :price, :purchaser_country, :purchaser_user_name, :u_address)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':u_id', $user_id);
            $stmt->bindParam(':yama_id', $yama_id);
            $stmt->bindParam(':payment', $payment);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':purchaser_country', $purchaser_country);
            $stmt->bindParam(':purchaser_user_name', $purchaser_user_name);
            $stmt->bindParam(':u_address', $u_address);
            $stmt->execute();
 
            // 購入が完了したらリダイレクト
            header('Location: /_3_home.php');
            exit;
        } else {
            echo "すべてのフィールドを入力してください。";
        }
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
}
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./css/stylesheet_4.css">
<title>購入情報入力</title>
</head>
<body>
<div class="header-img">
<a href="./_3_home.php"><img src="./images/oasislogo.jpg" width="100" height="50"></a>
</div>
<hr>
 
    <h2>購入情報入力</h2>
 
    <form action="" method="POST">
<!-- 隠しフィールドで選択された山のIDと価格を送信 -->
<input type="hidden" name="yama_id" value="<?php echo htmlspecialchars($_POST['yama_id'] ?? ''); ?>">
<input type="hidden" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>">
 
        <fieldset>
<h3>1.購入者様情報</h3>
<label for="purchaser_country">国/地域:</label>
<select id="purchaser_country" name="purchaser_country" required>
<option value="日本">日本</option>
<option value="アメリカ">アメリカ</option>
<option value="イギリス">イギリス</option>
<option value="カナダ">カナダ</option>
<option value="オーストラリア">オーストラリア</option>
</select><br><br>
 
            <label for="u_address">住所:</label>
<input type="text" id="u_address" name="u_address" required><br><br>
 
            <label for="purchaser_user_name">氏名:</label>
<input type="text" id="purchaser_user_name" name="purchaser_user_name" required><br><br>
</fieldset>
 
        <fieldset>
<h3>2.お支払方法</h3>
 
            <label>
<input type="radio" name="payment" value="VISA" required>
<img src="./images/visa.png" alt="VISA" width="100">
</label>
<label>
<input type="radio" name="payment" value="JCB" required>
<img src="./images/jcb.png" alt="JCB" width="100">
</label>
<label>
<input type="radio" name="payment" value="PayPay" required>
<img src="./images/Paypay.jpg" alt="PayPay" width="100">
</label>
</fieldset>
 
        <fieldset>
<input type="checkbox" name="kiyaku" required> 利用規約に同意する
<input type="submit" value="購入する">
</fieldset>
</form>
 
</body>
</html>