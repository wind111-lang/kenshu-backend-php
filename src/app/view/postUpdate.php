<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Post Update</title>
</head>
<body>
<h2>投稿編集</h2>
<ul>
    <li>
        <?php echo "投稿ID: " . htmlspecialchars($post['id']); ?>
        <?php echo "ユーザID: " . htmlspecialchars($post['user_id']); ?>
        <?php echo "投稿日時: " . htmlspecialchars($post['posted_at']); ?>
        <?php echo "更新日時: " . htmlspecialchars($post['updated_at']); ?>
        <br>
        <h3><?php echo "タイトル: " . htmlspecialchars($post['title']); ?></h3>
        <p><?php echo "本文: " . htmlspecialchars($post['body']); ?></p>
        <form method="post" action="/executeUpdate">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
            <label for="title">タイトル</label>
            <input type="text" id="title" name="title">
            <br>
            <label for="body">投稿内容</label>
            <input type="text" id="body" name="body">
            <br>
            <input type="submit" value="投稿更新">
        </form>
    </li>
</ul>
<a href="/">戻る</a>
</body>
</html>
