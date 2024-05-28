<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Post Detail</title>
</head>
<body>
<h2>投稿詳細</h2>
<ul>
    <li>
        <?php echo "投稿ID: " . htmlspecialchars($post['id']); ?>
        <?php echo "投稿日時: " . htmlspecialchars($post['posted_at']); ?>
        <?php echo "更新日時: " . htmlspecialchars($post['updated_at']); ?>
        <br>
        <?php echo "ユーザID: " . htmlspecialchars($post['user_id']); ?>
        <?php echo "ユーザ名: " . htmlspecialchars($user['username']); ?>
        <br>
        <h3><?php echo "タイトル: " . htmlspecialchars($post['title']); ?></h3>
        <p><?php echo "本文: " . htmlspecialchars($post['body']); ?></p>
        <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $user['username']): ?>
            <button type="button"
                    onclick="location.href='/postupdate?post_id=<?php echo htmlspecialchars($post['id']); ?>'">編集
            </button>
            <form method="post" action="/postdelete">
                <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" value="削除">
            </form>
        <?php endif; ?>
    </li>
</ul>
<a href="/">戻る</a>
</body>
</html>
