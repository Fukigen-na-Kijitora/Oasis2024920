<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // ログインしていない場合、ログイン画面にリダイレクト
    header('Location: _10_kanri.login.php');
    exit();
}
?>
<?php
//データベース接続情報
$host = 'localhost';
$dbname = 'LAA1553845-2024php';
$username = 'LAA1553845';
$password = 'pass1234';


// データベースに接続
$pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;
dbname=LAA1602729-oasis;charset=utf8',
'LAA1602729',
'oasis5');

$uploadFileDir = './uploaded_files/';
if (!is_dir($uploadFileDir)) {
    mkdir($uploadFileDir, 0777, true);
}
?>
<?php
class Kanrihome
{
    public function renderPage()
    {
        $page = $_GET['page'] ?? 'dashboard'; // デフォルトはダッシュボード
        $this->renderHeader();
        $this->renderSidebar();
        $this->renderContent($page);
        $this->renderFooter();
    }

    private function renderHeader()
    {
        echo '<!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>管理者ダッシュボード</title>
            <style>
                body { margin: 0; font-family: Arial, sans-serif; }
                .sidebar { width: 250px; background-color: #2c3e50; color: white; height: 100vh; position: fixed; padding: 20px; display: flex; flex-direction: column; }
                .main-content { margin-left: 250px; padding: 20px; }
                .menu ul { list-style: none; padding: 0; margin: 0; }
                .menu ul li { margin: 15px 0; }
                .menu ul li a { color: white; text-decoration: none; padding: 10px; display: block; border-radius: 5px; }
                .menu ul li a:hover { background-color: #34495e; }
                .form-group { margin-bottom: 15px; }
                label { display: block; margin-bottom: 5px; }
                input, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
                .submit-btn { background-color: #f1c40f; color: white; border: none; padding: 10px 20px; cursor: pointer; }
                .dashboard-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
                .card { background-color: #f5f5f5; padding: 20px; text-align: center; cursor: pointer; border: 1px solid #ccc; border-radius: 5px; transition: transform 0.2s; }
                .card:hover { transform: scale(1.05); }
            </style>
        </head>
        <body>';
    }

    private function renderSidebar()
    {
        echo '<div class="sidebar">
            <div class="profile">
                <img src="#" alt="Profile Icon" style="width:80px; height:80px; border-radius:50%; background-color:white;">
                <h3>山崎 亮佑</h3>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="?page=dashboard">ダッシュボード</a></li>
                    <li><a href="?page=add">商品追加</a></li>
                    <li><a href="?page=delete">商品削除</a></li>
                    <li><a href="?page=users">ユーザー管理</a></li>
                </ul>
            </div>
            <div class="logout" style="margin-top:auto;">
                <a href="logout.php" style="color:white; text-decoration:none; padding:10px 20px; background-color:#e74c3c; border-radius:5px;">ログアウト</a>
            </div>
        </div>';
    }

    private function renderContent($page)
    {
        echo '<div class="main-content">';
        switch ($page) {
            case 'dashboard':
                $this->renderDashboard();
                break;
            case 'add':
                $this->renderAddProduct();
                break;
            case 'delete':
                $this->renderDeleteProduct();
                break;
            case 'users':
                $this->renderUserManagement();
                break;
            default:
                echo '<h1>404 ページが見つかりません</h1>';
        }
        echo '</div>';
    }

    private function renderDashboard()
    {
        echo '<h1>ダッシュボード</h1>
        <div class="dashboard-grid">
            <a href="?page=add" class="card">商品追加</a>
            <a href="?page=delete" class="card">商品削除</a>
            <a href="?page=users" class="card">ユーザー管理</a>
        </div>';
    }

    private function renderAddProduct()
    {
        echo '<h1>商品追加</h1>
        <form method="POST" action="?page=save">
            <div class="form-group">
                <label for="name">商品名</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="price">価格</label>
                <input type="number" name="price" id="price" required>
            </div>
            <div class="form-group">
                <label for="details">詳細</label>
                <textarea name="details" id="details" rows="4"></textarea>
            </div>
            <button type="submit" class="submit-btn">追加する</button>
        </form>';
    }

    private function renderDeleteProduct()
    {
        echo '<h1>商品削除</h1>
        <p>ここで商品削除の機能を実装できます。</p>';
    }

    private function renderUserManagement()
    {
        echo '<h1>ユーザー管理</h1>
        <p>ここでユーザー管理の機能を実装できます。</p>';
    }

    private function renderFooter()
    {
        echo '</body></html>';
    }
}

// クラスを呼び出してページをレンダリング
$kanriShohin = new KanriShohin();
$kanriShohin->renderPage();
