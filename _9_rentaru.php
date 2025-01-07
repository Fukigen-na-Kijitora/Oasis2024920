<?php
session_start();

// ユーザーがログインしていない場合、ログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: ./_2_login.php');
    exit;
}

//CSRFトークンの検証
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("不正なリクエストです。");
}

// ユーザーIDを取得
$user_id = $_SESSION['user_id'];

// データベース接続（PDO）
try {
    $pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;dbname=LAA1602729-oasis;charset=utf8', 'LAA1602729', 'oasis5');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('データベース接続失敗: ' . $e->getMessage());
}

// 現在の日付を取得（レンタル開始日のデフォルトとして使用）
$current_date = date('Y-m-d');

// 山IDとdaypriceを取得
$yama_id = isset($_POST['yama_id']) ? $_POST['yama_id'] : 1;  // デフォルト値を1に設定
$dayprice = 0;

// データベースからdaypriceを取得
$sql = "SELECT dayprice FROM Oasis_yama WHERE yama_id = :yama_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':yama_id', $yama_id, PDO::PARAM_INT);
$stmt->execute();
$yama = $stmt->fetch(PDO::FETCH_ASSOC);
if ($yama) {
    $dayprice = $yama['dayprice'];  // 1日当たりの価格
}

// POSTされたデータがあればレンタル処理を実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // フォームデータを取得
        $u_address = isset($_POST['u_address']) ? htmlspecialchars($_POST['u_address'], ENT_QUOTES, 'UTF-8') : '';
        $purchaser_country = isset($_POST['purchaser_country']) ? htmlspecialchars($_POST['purchaser_country'], ENT_QUOTES, 'UTF-8') : '';
        $purchaser_u_name = isset($_POST['purchaser_u_name']) ? htmlspecialchars($_POST['purchaser_u_name'], ENT_QUOTES, 'UTF-8') : '';
        $u_tell = isset($_POST['u_tell']) ? htmlspecialchars($_POST['u_tell'], ENT_QUOTES, 'UTF-8') : '';
        $payment = isset($_POST['payment']) ? htmlspecialchars($_POST['payment'], ENT_QUOTES, 'UTF-8') : '';
        $rental_start = isset($_POST['rental_start']) ? htmlspecialchars($_POST['rental_start'], ENT_QUOTES, 'UTF-8') : '';
        $rental_finish = isset($_POST['rental_finish']) ? htmlspecialchars($_POST['rental_finish'], ENT_QUOTES, 'UTF-8') : '';

        //  フォームデータがすべて存在するかチェック
        if( $u_address && $u_tell && $purchaser_country && $purchaser_u_name && $payment && $yama_id && $rental_start && $rental_finish){
        // レンタル情報をデータベースに登録
        $sql = "INSERT INTO Oasis_rental (u_id, yama_id, purchaser_country, purchaser_u_name, u_address, u_tell, payment, rental_start, rental_finish, order_date, pay_contirmation_flag) 
                VALUES (:u_id, :yama_id, :purchaser_country, :purchaser_u_name, :u_address, :u_tell, :payment, :rental_start, :rental_finish, CURDATE(), 0)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':u_id', $user_id);
        $stmt->bindParam(':yama_id', $yama_id);
        $stmt->bindParam(':purchaser_country', $purchaser_country);
        $stmt->bindParam(':purchaser_u_name', $purchaser_u_name);
        $stmt->bindParam(':u_address', $u_address);
        $stmt->bindParam(':u_tell', $u_tell);
        $stmt->bindParam(':payment', $payment);
        $stmt->bindParam(':rental_start', $rental_start);
        $stmt->bindParam(':rental_finish', $rental_finish);
        $stmt->execute();

        // データが正常に登録された後、指定したページにリダイレクト
        header('Location: ./_3_home.php');
        exit;
        }else{
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
    <link rel="stylesheet" href="./css/stylesheet_5.css">
    <title>レンタル</title>
    <script>
        function calculatePrice() {
            // 開始日と終了日を取得
            const rentalStart = document.getElementById('rental_start').value;
            const rentalFinish = document.getElementById('rental_finish').value;

            if (rentalStart && rentalFinish) {
                // 日付の差を計算
                const startDate = new Date(rentalStart);
                const finishDate = new Date(rentalFinish);
                const timeDiff = finishDate - startDate;

                if (timeDiff >= 0) {
                    // 日数を計算
                    const rentalDays = timeDiff / (1000 * 3600 * 24); // ミリ秒を日数に変換

                    // 価格計算
                    const dayprice = <?php echo $dayprice; ?>;  // PHPから取得した1日当たりの価格
                    const totalPrice = rentalDays * dayprice;

                    // 金額を表示
                    document.getElementById('calculated_price').innerText = totalPrice.toLocaleString() + '円';
                } else {
                    document.getElementById('calculated_price').innerText = '終了日は開始日以降に設定してください。';
                }
            }
        }
    </script>
</head>
<body>
<div class="header-img">
<a href="./_3_home.php"><img src="./images/oasislogo.jpg" alt="Oasis Logo"></a>

</div>
<hr>
    
<form action="" method="POST">
    <div class="left-column">        
        <!-- 隠しフィールドで選択された山のIDを送信 -->
        <input type="hidden" name="yama_id" value="<?php echo htmlspecialchars($_POST['yama_id'] ?? ''); ?>">
        <fieldset>
            <h3>1. レンタル情報</h3>
            <label for="purchaser_country">国/地域:</label>
            <select id="purchaser_country" name="purchaser_country" required>
                <option value="日本">日本</option>
                <option value="アメリカ">アメリカ</option>
                <option value="イギリス">イギリス</option>
                <option value="カナダ">カナダ</option>
                <option value="オーストラリア">オーストラリア</option>
            </select><br><br>

            <label for="purchaser_u_name">氏名:</label>
            <input type="text" id="purchaser_u_name" name="purchaser_u_name" required><br><br>

            <label for="u_address">住所:</label>
            <input type="text" id="u_address" name="u_address" required><br><br>

            <label for="u_tell">電話番号:</label>
            <input type="text" id="u_tell" name="u_tell" placeholder="例: 000-0000-0000" required><br><br>
        </fieldset>

        <fieldset>
            <h3>2. 支払い方法</h3>
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
            </label><br><br>
        </fieldset>
    </div>

        <div class="right-column">
            <h3>3. レンタル期間</h3>
            <label for="rental_start">開始日:</label>
            <input type="date" name="rental_start" id="rental_start" value="<?php echo $current_date; ?>" required onchange="calculatePrice()"><br><br>

            <label for="rental_finish">終了日:</label>
            <input type="date" name="rental_finish" id="rental_finish" required onchange="calculatePrice()"><br><br>

            <!-- 計算された金額を表示 -->
            <p>レンタル料金: <span id="calculated_price">0円</span></p>
            <div class="terms">
                <input type="checkbox" name="kiyaku" required> 利用規約に同意する
            </div>
            <input type="submit" value="レンタルする">
        </div>
    </form>
</body>
</html>
