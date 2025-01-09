<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylesheet_2.css">
    <title>新規登録</title>
</head>
<body>
    <div class="login-container">
        <h2>新規登録</h2>
        <form action="./_1_user_insert.php" method="POST">
            <div class="form-group">
                <label for="name">お名前</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">新規登録</button>
        </form>
        <p><a href="./_2_login.php">ログインはこちら</a></p>
    </div>
</body>
</html>