<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding-top: 100px;
        }
        .button-container {
            position: relative;
            width: 300px;
            height: 300px;
            margin: 0 auto;
        }
        .button {
            position: absolute;
            width: 100px;
            height: 100px;
            background-color: #1abc9c;
            color: white;
            text-align: center;
            line-height: 100px;
            font-size: 16px;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #16a085;
        }
        .button:nth-child(1) {
            top: 0;
            left: 50%;
            transform: translate(-50%, 0);
        }
        .button:nth-child(2) {
            top: 35%;
            left: 0;
            transform: translate(0, -50%);
        }
        .button:nth-child(3) {
            top: 35%;
            right: 0;
            transform: translate(0, -50%);
        }
        .button:nth-child(4) {
            bottom: 0;
            left: 25%;
            transform: translate(-50%, 0);
        }
        .button:nth-child(5) {
            bottom: 0;
            right: 25%;
            transform: translate(50%, 0);
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>ダッシュボード</h2>
    <div class="menu-item"><a href="#">商品追加</a></div>
    <div class="menu-item"><a href="#">商品削除</a></div>
    <div class="menu-item"><a href="#">ユーザー管理</a></div>
    <div class="menu-item"><a href="#">購入商品管理</a></div>
    <div class="menu-item"><a href="#">レンタル商品管理</a></div>
    <div class="menu-item"><a href="#">ログアウト</a></div>
</div>

<div class="main-content">
    <h1>ダッシュボード</h1>
    <a href="商品追加.php" class="button">商品追加</a>
    <a href="商品削除.php" class="button" style="background-color: #2ecc71;">商品削除</a>
    <a href="ユーザー情報.php" class="button" style="background-color: #e67e22;">ユーザー情報</a>
    <a href="購入商品管理.php" class="button" style="background-color: #9b59b6;">購入商品管理</a>
    <a href="レンタル商品管理.php" class="button" style="background-color: #e74c3c;">レンタル商品管理</a>
</div>

</body>
</html>
