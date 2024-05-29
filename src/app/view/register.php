<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Register</title>
</head>
<body>
<h2>新規登録</h2>
<form action="/executeRegister" method="post">
    <!--TODO: 登録フォームを作成-->
    <label for="email">Email:</label>
    <input type="email" id="email" name="email">
    <br>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username">
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <br>
    <!--TODO:画像アップロード機能を作成-->
    <label for="user_image">Image:</label>
    <input type="file" id="user_image" name="user_image">
    <br>
    <input type="submit" value="Register">
</form>
<a href="/login">戻る</a>
</body>
</html>
