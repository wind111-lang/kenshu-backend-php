<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Post Detail</title>
</head>
<body>
<?php if (isset($err)): ?>
    <p><?php echo $err; ?></p>
<?php endif; ?>
<h2>投稿詳細</h2>
<ul>
    <li>
        <?php echo "投稿ID: " . htmlspecialchars($post['id']); ?>
        <?php echo "投稿日時: " . htmlspecialchars($post['posted_at']); ?>
        <?php echo "更新日時: " . htmlspecialchars($post['updated_at']); ?>
        <br>
        <img src="<?php echo "/src/images/users/" . htmlspecialchars($user['user_image']); ?>"
             alt="<?php echo $user['username'] ?>" width="25px" height="25px">
        <?php echo "ユーザID: " . htmlspecialchars($post['user_id']); ?>
        <?php echo "ユーザ名: " . htmlspecialchars($user['username']); ?>
        <h3><?php echo "タイトル: " . htmlspecialchars($post['title']); ?></h3>
        <img src="<?php echo "/src/images/posts/thumb/" . htmlspecialchars($thumb['thumb_url']); ?>"
             alt="<?php echo $thumb['thumb_url'] ?>" width="200px" height="200px">
        <p><?php echo "本文: " . htmlspecialchars($post['body']); ?></p>
        <?php foreach ($images as $postImage): ?>
            <img src="<?php echo "/src/images/posts/post/" . htmlspecialchars($postImage['img_url']); ?>"
                 alt="<?php echo $postImage['img_url'] ?>" width="150px" height="150px">
        <?php endforeach; ?>
        <br>
        <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $user['username']): ?>
            <button type="button"
                    onclick="location.href='/postUpdate?post_id=<?php echo htmlspecialchars($post['id']); ?>'">編集
            </button>
            <form method="post" action="/postDelete">
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
