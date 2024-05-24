<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Post Detail</title>
</head>
<body>
     <h2>投稿詳細</h2>
    <ul>
        <li>
            <?php echo "投稿ID: ". htmlspecialchars($post['id']); ?>
            <?php echo "ユーザID: ". htmlspecialchars($post['user_id']); ?>
            <?php echo "投稿日時: ". htmlspecialchars($post['posted_at']); ?>
            <?php echo "更新日時: ". htmlspecialchars($post['updated_at']); ?>
            <br>
            <h3><?php echo "タイトル: ". htmlspecialchars($post['title']); ?></h3>
            <p><?php echo "本文: ". htmlspecialchars($post['body']); ?></p>
        </li>
    </ul>
    <a href = "/">戻る</a>
</body>
</html>

