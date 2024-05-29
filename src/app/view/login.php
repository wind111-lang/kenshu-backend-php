<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Login</title>
</head>
<body>
<h2>ログイン</h2>
<?php if (isset($err)): ?>
    <p><?php echo $err; ?></p>
<?php endif; ?>
<form action="/executeLogin" method="post">
    <!--TODO: ログインフォームを作成, CSRF対応-->
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="submit" value="Login">
    <a href="/register">未登録の方はこちら</a>
</form>
</body>
</html>
