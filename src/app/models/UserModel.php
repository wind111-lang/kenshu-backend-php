<?php

namespace App\app\models;

use App\core\Model;
use PDO;

date_default_timezone_set('Asia/Tokyo');

class UserModel extends Model
{
    //TODO: UserのDB制御
    public function getUser(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM userinfo');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByName(string $username): array
    {
        $stmt = $this->db->prepare('SELECT * FROM userinfo WHERE username = :username');
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById(int $id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM userinfo WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerUser(string $email, string $username, string $password, string $user_image): void
    {
        $datetime = date("Y-m-d H:i:s", time());

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare('INSERT INTO userinfo (email, username, password, created_at, updated_at, user_image)
                VALUES (:email, :username, :password, :created_at, :updated_at, :image)');
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':image', $user_image, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteUser(string $email, string $username, string $password, string $image, string $created_at)
    {
        $datetime = date("Y-m-d H:i:s", time());

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare('INSERT INTO log_userinfo (email, username, password, created_at, updated_at, image)
                VALUES (:email, :username, :password, :created_at, :updated_at, :image)');
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':deleted_at', $datetime, \PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function updateUser()
    {

    }
}
