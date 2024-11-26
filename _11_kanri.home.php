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
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylesheet_3.css">
    <title>ホーム</title>
</head>
<body>
<style>
        .icon {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                object-fit: cover;
                margin: 10px;
              }
        .container {
                text-align: left;
                   }
        .upload-form {
                margin-top: 20px;
                     }
        .icons {
                display: flex;
                justify-content: flex-start; /* より適切なプロパティ値 */
                flex-wrap: wrap;
               }
</style>
</head>
</body>
</html>
<?php
$uploadFileDir = './uploaded_files/';
if (!is_dir($uploadFileDir)) {
    mkdir($uploadFileDir, 0755, true);
}
// アップロードされた画像を保存するディレクトリ
$uploadDir = './uploads/';

// ディレクトリが存在しない場合は作成
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// アップロード処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // 許可される拡張子
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = uniqid() . '.' . $fileExtension; // 一意の名前を付ける
        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $uploadSuccess = "画像がアップロードされました！";
        } else {
            $uploadError = "画像のアップロードに失敗しました。";
        }
    } else {
        $uploadError = "許可されていないファイル形式です。";
    }
}
