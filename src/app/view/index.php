<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Form</title>
</head>
<body>

<?php if (isset($_SESSION['username'])): ?>
    <?php echo htmlspecialchars($_SESSION['username']) . "さん, ようこそ!"; ?>
    <form action="/logout" method="get"><input type="submit" value="ログアウト"></form>
    <br>
    <form action="/post" method="post" enctype="multipart/form-data">
        <label for="title">タイトル</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="body">投稿内容</label>
        <input type="text" id="body" name="body" required>
        <br>
        <!--TODO: 複数画像アップロード機能を作成-->
        <label for="thumb_image">サムネイル画像:</label>
        <input type="file" id="thumb_image" name="thumb_image" accept="image/*" required>
        <br>
        <label for="post_image">記事画像:</label>
        <input type="file" id="post_images" name="post_images[]" accept="image/*" multiple required>
        <br>
        <!--TODO: タグ機能を作成-->
        <label for="tags">タグ:</label>
        <br>
        総合<input type="checkbox" id="tags" name="tags[]" value="総合">
        テクノロジー<input type="checkbox" id="tags" name="tags[]" value="テクノロジー">
        モバイル<input type="checkbox" id="tags" name="tags[]" value="モバイル">
        アプリ<input type="checkbox" id="tags" name="tags[]" value="アプリ">
        エンタメ<input type="checkbox" id="tags" name="tags[]" value="エンタメ">
        ビューティー<input type="checkbox" id="tags" name="tags[]" value="ビューティー">
        <br>
        ファッション<input type="checkbox" id="tags" name="tags[]" value="ファッション">
        ライフスタイル<input type="checkbox" id="tags" name="tags[]" value="ライフスタイル">
        ビジネス<input type="checkbox" id="tags" name="tags[]" value="ビジネス">
        グルメ<input type="checkbox" id="tags" name="tags[]" value="グルメ">
        スポーツ<input type="checkbox" id="tags" name="tags[]" value="スポーツ">
        <br>
        <input type="submit" value="Submit">
    </form>
<?php else: ?>
    <form action="/login" method="get"><input type="submit" value="ログイン"></form>
    <form action="/register" method="get"><input type="submit" value="新規登録"></form>
<?php endif; ?>
<?php if (isset($err)): ?>
    <p><?php echo $err; ?></p>
<?php endif; ?>
　　<h2>投稿一覧</h2>
<ul>
    <?php if (empty($posts)): ?>
        <p>投稿がありません</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <li>
                <?php echo "投稿ID: " . htmlspecialchars($post['id']); ?>
                <?php echo "投稿日時: " . htmlspecialchars($post['posted_at']); ?>
                <?php echo "更新日時: " . htmlspecialchars($post['updated_at']); ?>
                <br>
                <img src="<?php echo "/src/images/users/" . htmlspecialchars($users[$post['user_id'] - 1]['user_image']) ?>"
                     alt="<?php echo $users[$post['user_id'] - 1]['username'] ?>" width="25px" height="25px">
                <?php echo "ユーザID: " . htmlspecialchars($post['user_id']); ?>
                <?php echo "ユーザ名: " . htmlspecialchars($users[$post['user_id'] - 1]['username']); ?>
                <?php if (isset($_SESSION['username']) && ($_SESSION['username'] == $users[$post['user_id'] - 1]['username'])): ?>
                    <form method="post" action="/postDelete">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                        <input type="submit" value="削除">
                    </form>
                <?php endif; ?>
                <br>
                <h3>
                    <a href="/postDetail?post_id=<?php echo htmlspecialchars($post['id']); ?>">
                        <?php echo htmlspecialchars($post['title']) ?><br>
                        <img src="<?php echo "/src/images/posts/thumb/" . htmlspecialchars($post['thumb_url']) ?>"
                             alt="<?php echo $post['title'] ?>" width="200px" height="200px">
                    </a>
                </h3>
                <p>タグ:</p>
                <?php foreach ($tags as $tag): ?>
                    <?php if ($tag['post_id'] == $post['id']): ?>
                        <?php echo htmlspecialchars($tag['tag']); ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
</body>
</html>
