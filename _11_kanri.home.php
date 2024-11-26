<?php
session_start();

// セッション確認：ログイン状態でなければログイン画面へリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: _10_kanri.login.php');
    exit();
}

// データベース接続
try {
    $pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;dbname=LAA1602729-oasis;charset=utf8', 'LAA1602729', 'oasis5');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続に失敗しました: " . $e->getMessage());
}

// アップロード用ディレクトリ
$uploadDir = './uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// アップロード処理
$uploadMessage = "";
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
            $uploadMessage = "画像がアップロードされました！";

            // データベースにファイルパスを保存（例）
            $stmt = $pdo->prepare("INSERT INTO uploaded_files (file_name, file_path, uploaded_at) VALUES (?, ?, NOW())");
            $stmt->execute([$fileName, $destination]);
        } else {
            $uploadMessage = "画像のアップロードに失敗しました。";
        }
    } else {
        $uploadMessage = "許可されていないファイル形式です。";
    }
}
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
