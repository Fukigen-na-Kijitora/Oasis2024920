<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ダッシュボード</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: white;
            margin-bottom: 10px;
        }
        .profile h3 {
            margin: 0;
            font-size: 18px;
        }
        .menu {
            width: 100%;
        }
        .menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .menu ul li {
            margin: 15px 0;
        }
        .menu ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 5px;
        }
        .menu ul li a:hover {
            background-color: #34495e;
        }
        .logout {
            margin-top: auto;
            text-align: center;
        }
        .logout a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #e74c3c;
        }
        .logout a:hover {
            background-color: #c0392b;
        }
        .main {
            margin-left: 250px;
            padding: 20px;
        }
        .dashboard-title {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .dashboard-grid .card {
            background-color: #f5f5f5;
            border: 2px solid #ccc;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        .dashboard-grid .card:hover {
            background-color: #eaeaea;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="#" alt="Profile Icon">
            <h3>山崎 亮佑</h3>
        </div>
        <div class="menu">
            <ul>
                <li><a href="#">ダッシュボード</a></li>
                <li><a href="#">商品追加</a></li>
                <li><a href="#">商品削除</a></li>
                <li><a href="#">ユーザー管理</a></li>
                <li><a href="#">購入商品管理</a></li>
                <li><a href="#">レンタル商品管理</a></li>
            </ul>
        </div>
        <div class="logout">
            <a href="#">ログアウト</a>
        </div>
    </div>
    <div class="main">
        <div class="dashboard-title">ダッシュボード</div>
        <div class="dashboard-grid">
            <div class="card">商品追加</div>
            <div class="card">商品削除</div>
            <div class="card">ユーザー情報</div>
            <div class="card">購入商品管理</div>
            <div class="card">レンタル商品管理</div>
        </div>
    </div>
</body>
</html>
