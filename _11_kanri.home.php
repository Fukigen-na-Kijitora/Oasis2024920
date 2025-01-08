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
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            position: fixed;
            height: 100%;
        }
        .sidebar h2 {
            text-align: center;
        }
        .menu-item {
        margin: 10px 0;
        }
        .menu-item a {
        display: block; /* リンクをブロック全体に拡張 */
        padding: 10px 20px;
        text-decoration: none; /* 下線を削除 */
        color: white;
        background-color: #3498db; /* 背景色 */
        border-radius: 5px;
        transition: background-color 0.3s ease;
        text-align: center; /* テキストを中央揃え */
        }

        .menu-item a:hover {
        background-color: #2980b9; /* ホバー時の色変更 */
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        .button {
            display: inline-block;
            width: 200px;
            height: 100px;
            margin: 20px;
            background-color: #1abc9c;
            color: white;
            text-align: center;
            line-height: 100px;
            font-size: 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>ダッシュボード</h2>
    <div class="menu-item"><a href="_12_kanri.shohin.php">商品追加</a></div>
    <div class="menu-item"><a href="_13_kanri.shohindel.php">商品削除</a></div>
    <div class="menu-item"><a href="_14_kanri.user.php">ユーザー管理</a></div>
    <div class="menu-item"><a href="_15_kanri.add.shohin.php">購入商品管理</a></div>
    <div class="menu-item"><a href="_16_kanri.add.rental.php">レンタル商品管理</a></div>
    <div class="menu-item"><a href="_10_kanri.login.php">ログアウト</a></div>
</div>

<div class="main-content">
    <h1>ダッシュボード</h1>
    <a href="_12_kanri.shohin.php" class="button">商品追加</a>
    <a href="_13_kanri.shohindel.php" class="button" style="background-color: #2ecc71;">商品削除</a>
    <a href="_14_kanri.user.php" class="button" style="background-color: #e67e22;">ユーザー情報</a>
    <a href="_15_kanri.add.shohin.php" class="button" style="background-color: #9b59b6;">購入商品管理</a>
    <a href="_16_kanri.add.rental.php" class="button" style="background-color: #e74c3c;">レンタル商品管理</a>
</div>

</body>
</html>

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
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            position: fixed;
            height: 100%;
        }
        .sidebar h2 {
            text-align: center;
        }
        .menu-item {
        margin: 10px 0;
        }
        .menu-item a {
        display: block; /* リンクをブロック全体に拡張 */
        padding: 10px 20px;
        text-decoration: none; /* 下線を削除 */
        color: white;
        background-color: #3498db; /* 背景色 */
        border-radius: 5px;
        transition: background-color 0.3s ease;
        text-align: center; /* テキストを中央揃え */
        }

        .menu-item a:hover {
        background-color: #2980b9; /* ホバー時の色変更 */
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        .button {
            display: inline-block;
            width: 200px;
            height: 100px;
            margin: 20px;
            background-color: #1abc9c;
            color: white;
            text-align: center;
            line-height: 100px;
            font-size: 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>ダッシュボード</h2>
    <li><a href="_12_kanri.shohin.php">商品追加</a></li>
    <li><a href="_13_kanri.shohindel.php">商品削除</a></li>
    <li><a href="_14_kanri.user.php">ユーザー管理</a></li>
    <li><a href="_15_kanri.add.shohin.php">購入商品管理</a></li>
    <li><a href="_16_kanri.rental.shohin.php">レンタル商品管理</a></li>
    <li><a href="_10_kanri.login.php">ログアウト</a></li>
</div>

<div class="main-content">
    <h1>ダッシュボード</h1>
    <a href="_12_kanri.shohin.php" class="button">商品追加</a>
    <a href="_13_kanri.shohindel.php" class="button" style="background-color: #2ecc71;">商品削除</a>
    <a href="_14_kanri.user.php" class="button" style="background-color: #e67e22;">ユーザー情報</a>
    <a href="_15_kanri.add.shohin.php" class="button" style="background-color: #9b59b6;">購入商品管理</a>
    <a href="_16_kanri.rental.shohin.php" class="button" style="background-color: #e74c3c;">レンタル商品管理</a>
</div>

</body>
</html>
