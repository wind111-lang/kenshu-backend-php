<?php

namespace App\app\models;

use App\core\Model;

date_default_timezone_set('Asia/Tokyo');

class PostModel extends Model
{
    //TODO: DB制御
    public function getPost(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM posts ORDER BY updated_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function sendPost($title, $body)
    {
        $id = 1;
        $datetime = date("Y-m-d H:i:s", time());
        $stmt = $this->db->prepare('INSERT INTO posts (user_id, posted_at, updated_at, title, body) 
                VALUES (:user_id, :posted_at, :updated_at, :title, :body)');
        $stmt->bindParam(':user_id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':posted_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, \PDO::PARAM_STR);
        $stmt->execute();

    }

    public function deletePost()
    {

    }

    public function updatePost()
    {

    }
}
