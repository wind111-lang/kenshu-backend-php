<!DOCTYPE html>
<html>
<head>
    <title>Form</title>
</head>
<body>
<form action="/post" method="post">
    <label for="title">タイトル</label>
    <input type="text" id="title" name="title">
    <br>
    <label for="body">投稿内容</label>
    <input type="text" id="body" name="body">
    <br>
    <input type="submit" value="Submit" >
</form>
　　<h2>投稿一覧</h2>
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <?php echo "投稿ID: ". htmlspecialchars($post['id']); ?>
            <?php echo "ユーザID: ". htmlspecialchars($post['user_id']); ?>
            <?php echo "投稿日時: ". htmlspecialchars($post['posted_at']); ?>
            <?php echo "更新日時: ". htmlspecialchars($post['updated_at']); ?>
            <br>
            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
            <?php echo htmlspecialchars($post['body']); ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>