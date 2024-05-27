<?php

namespace App\core;

use PDO, PDOException;

const DB_HOST = 'postgres';
const DB_NAME = 'postsdb';
const DB_USER = 'prtimes';
const DB_PASS = 'prtimes';
const DB_PORT = '5432';
class Model
{
    protected $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('pgsql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';', DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}
