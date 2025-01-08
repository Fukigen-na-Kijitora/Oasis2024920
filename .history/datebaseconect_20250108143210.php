<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// .envファイルを読み込む
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    // 環境変数からデータベース接続情報を取得
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');
    $charset = getenv('DB_CHARSET');

    // PDOを使用してデータベースに接続
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $user, $password);

    // エラーモードを例外に設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "データベースに接続成功！";
} catch (PDOException $e) {
    // 接続エラー時の処理
    echo "データベース接続失敗: " . $e->getMessage();
}
