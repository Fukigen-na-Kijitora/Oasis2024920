<?php
session_start();
 
if (!isset($_SESSION['user_id'])) {
    // ログインしていない場合、ログイン画面にリダイレクト
    header('Location: _2_login.php');
    exit();
}

if (isset($_GET['logout'])) {
    // ログアウト処理
    session_unset(); // セッション変数をすべて削除
    session_destroy(); // セッションを破棄
    header('Location: _2_login.php'); // ログインページにリダイレクト
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylesheet_3.css">
    <link rel="icon" href="/favicon.ico" />
    <title>ホーム</title>
</head>
<body>
    <div class="header-img">
        <!-- 検索フォーム -->
        <form method="get" action="./_3_home.php">
            <input type="search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; ?>" placeholder="山の名前で検索">
            <button type="submit">検索</button>
        </form>
        <img src="./images/oasislogo.jpg" width="100" height="50">
    </div>
    <hr>
<?php
    $pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;
                    dbname=LAA1602729-oasis;charset=utf8',
                    'LAA1602729',
                    'oasis5');

    //海外の山画像
    $sql1 = "SELECT `yama_img`, `yama_name` FROM `Oasis_yama` WHERE `Region` = 1 ";
    $result1 = $pdo->query($sql1);
    $rows1 = $result1->fetchAll(PDO::FETCH_ASSOC);
    $rowCount = count($rows1);

    if($rowCount > 0) ?>
        <h2 class="h2">海外</h2>
            <div class="img-container-wrapper">
            <button class="Arrow left" data-target="img-container-1">&lt;</button>
                <div class="img-container" id="img-container-1">
                    <?php foreach ($rows1 as $row) ?>
                        <div class="img-slide">
                            <form action="_4_shohin.php" method="POST">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($row["yama_name"], ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="img-transition">
                                    <img src="<?= $row["yama_img"] ?>" alt="<?= $row["yama_name"] ?>">
                                </button>
                                <p><?= $row["yama_name"] ?></p>
                            </form>
                        </div>
                </div>
                <button class="Arrow right" data-target="img-container-1">&gt;</button>;
            </div>

    <?php
    //国内の山画像
    $sql2 = "SELECT `yama_img`, `yama_name` FROM `Oasis_yama` WHERE `Region` = 0 ";
    $result2 = $pdo->query($sql2);
    $rows2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    $rowCount = count($rows2);

    if($rowCount > 0)?>
        <h2 class="h2">国内</h2>
            <div class="img-container-wrapper">
            <button class="Arrow left" data-target="img-container-2">&lt;</button>
                <div class="img-container" id="img-container-2">
                    <?php foreach ($rows2 as $row) ?>
                        <div class="img-slide">
                            <form action="_4_shohin.php" method="POST">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($row["yama_name"], ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="img-transition">
                                    <img src="<?= $row["yama_img"] ?>" alt="<?= $row["yama_name"] ?>">
                                </button>
                                <p><?= $row["yama_name"] ?></p>
                            </form>
                        </div>
                </div>
            <div class="Arrow right" data-target="img-container-2">&gt;</div>
        </div>
<footer>
    <hr>
    <div class="footer">
        <img src="./images/oasislogo.jpg" width="100" height="50">
        <a href="./_8_kounyurireki.php">購入履歴</a>
        <a href="?logout=true" style="margin-left: 20px;">ログアウト</a>
    </div>
</footer>
<script src="./javascript/userhome.js"></script>
</body>
</html>
 
 