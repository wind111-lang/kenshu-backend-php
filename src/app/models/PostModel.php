<?php

namespace App\app\models;

use App\core\Model;
use PDO;

date_default_timezone_set('Asia/Tokyo');

class PostModel extends Model
{
    //TODO: DB制御
    public function getPost(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM posts INNER JOIN thumb_image ON posts.id = thumb_image.post_id ORDER BY updated_at DESC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLatestId(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT 1');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function sendPost(string $title, string $body, int $user_id): void
    {
        $datetime = date("Y-m-d H:i:s", time());

        $stmt = $this->db->prepare('INSERT INTO posts (user_id, posted_at, updated_at, title, body)
                VALUES (:user_id, :posted_at, :updated_at, :title, :body)');
        $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindParam(':posted_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deletePost(array $post): void
    {
        $datetime = date("Y-m-d H:i:s", time());

        $stmt = $this->db->prepare('INSERT INTO log_posts (id, user_id, posted_at, deleted_at, title, body)
                VALUES (:id, :user_id, :posted_at, :deleted_at, :title, :body)');
        $stmt->bindParam(':id', $post['id'], \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $post['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':posted_at', $post['posted_at'], \PDO::PARAM_STR);
        $stmt->bindParam(':deleted_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':title', $post['title'], \PDO::PARAM_STR);
        $stmt->bindParam(':body', $post['body'], \PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $this->db->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->bindParam(':id', $post['id'], \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updatePost(int $id, string $title, string $body): void
    {
        $datetime = date("Y-m-d H:i:s", time());

        $stmt = $this->db->prepare('UPDATE posts SET updated_at = :updated_at, title = :title, body = :body WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getThumbImageFromPostId(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM thumb_image WHERE post_id = :post_id');
        $stmt->bindParam(':post_id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPostImageFromPostId(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM post_images WHERE post_id = :post_id');
        $stmt->bindParam(':post_id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendPostImage(int $id, string $image): void
    {
        $stmt = $this->db->prepare('INSERT INTO post_images (post_id, img_url) VALUES (:post_id, :img_url)');
        $stmt->bindParam(':post_id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':img_url', $image, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function sendThumbImage(int $id, string $thumb): void
    {
        $stmt = $this->db->prepare('INSERT INTO thumb_image (post_id, thumb_url) VALUES (:post_id, :thumb_url)');
        $stmt->bindParam(':post_id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':thumb_url', $thumb, \PDO::PARAM_STR);
        $stmt->execute();
    }
}
