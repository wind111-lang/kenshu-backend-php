<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Login</title>
</head>
<body>
<form action="/login" method="post">
    <!--TODO: ログインフォームを作成, CSRF対応-->
    <label for="username">Username:</label>
    <input type="text" id="username" name="username">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <input type="submit" value="Login">
</form>
</body>
</html>
