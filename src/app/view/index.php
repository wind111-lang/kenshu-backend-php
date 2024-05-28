<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Form</title>
</head>
<body>

<?php if (isset($_SESSION['username'])): ?>
    <?php echo htmlspecialchars($_SESSION['username']) . "でログイン中"; ?>
    <a href="/logout">ログアウト</a>
    <br>
    <form action="/post" method="post">
        <label for="title">タイトル</label>
        <input type="text" id="title" name="title">
        <br>
        <label for="body">投稿内容</label>
        <input type="text" id="body" name="body">
        <br>
        <input type="submit" value="Submit">
    </form>
<?php else: ?>
    <a href="/login">ログイン</a>
    <a href="/register">新規登録</a>
<?php endif; ?>
　　<h2>投稿一覧</h2>
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <?php echo "投稿ID: " . htmlspecialchars($post['id']); ?>
            <?php echo "投稿日時: " . htmlspecialchars($post['posted_at']); ?>
            <?php echo "更新日時: " . htmlspecialchars($post['updated_at']); ?>
            <br>
            <?php echo "ユーザID: " . htmlspecialchars($post['user_id']); ?>
            <?php echo "ユーザ名: " . htmlspecialchars($users[$post['user_id'] - 1]['username']); ?>
            <?php if (isset($_SESSION['username']) && ($_SESSION['username'] == $users[$post['user_id'] - 1]['username'])): ?>
                <form method="post" action="/postdelete">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                    <input type="submit" value="削除">
                </form>
            <?php endif; ?>
            <br>
            <h3>
                <a href="/postdetail?post_id=<?php echo htmlspecialchars($post['id']); ?>"><?php echo htmlspecialchars($post['title']) ?></a>
            </h3>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
