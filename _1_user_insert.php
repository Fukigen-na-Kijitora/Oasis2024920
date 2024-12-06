<?php
session_start();

try {
    $pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;dbname=LAA1602729-oasis;charset=utf8', 'LAA1602729', 'oasis5');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 入力データ取得
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $password_confirm = $_POST['password_confirm'] ?? null;

        // 入力データ検証
        if (empty($name) || empty($email) || empty($password)) {
            die('全てのフィールドを入力してください。');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('正しいメールアドレスを入力してください。');
        }
        if ($password !== $password_confirm) {
            die('パスワードが一致しません。');
        }

        // パスワードのハッシュ化
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // データベースに挿入
        $stmt = $pdo->prepare("INSERT INTO Oasis_user (u_name, u_mail, u_password) VALUES (:u_name, :u_mail, :u_password)");
        $stmt->bindParam(':u_name', $name);
        $stmt->bindParam(':u_mail', $email);
        $stmt->bindParam(':u_password', $hashed_password);
        $stmt->execute();

        // 挿入されたユーザーIDを取得
        $user_id = $pdo->lastInsertId();

        // セッションに保存
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;

        // ホーム画面にリダイレクト
        header('Location: _3_home.php');
        exit();
    }
} catch (PDOException $e) {
    die('データベースエラー: ' . $e->getMessage());
}
?>
