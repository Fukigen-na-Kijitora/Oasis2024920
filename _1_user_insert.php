<?php
    $pdo = new PDO('mysql:host=mysql306.phy.lolipop.lan;
                    dbname=LAA1602729-oasis;charset=utf8',
                    'LAA1602729',
                    'oasis5');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //データ取得
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);// パスワードハッシュ化


        //データベースに挿入
        $stmt = $pdo->prepare("INSERT INTO Oasis_user (u_name, u_mail, u_password) VALUES (:u_name, :u_mail, :u_password)");
        $stmt->bindParam(':u_name', $name);
        $stmt->bindParam(':u_mail', $email);
        $stmt->bindParam(':u_password', $pass);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $user['u_id'];
        $_SESSION['user_name'] = $user['u_name'];

        // ホーム画面にリダイレクト
        header('Location: _3_home.php');
        exit();
    }

?>