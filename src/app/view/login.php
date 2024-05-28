<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Login</title>
</head>
<body>
<h2>ログイン</h2>
<form action="/executeLogin" method="post">
    <!--TODO: ログインフォームを作成, CSRF対応-->
    <label for="username">Username:</label>
    <input type="text" id="username" name="username">
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <br>
    <input type="submit" value="Login">
    <a href="/register">未登録の方はこちら</a>
</form>
</body>
</html>
