<?php

const DB_HOST = 'postgres';
const DB_NAME = 'postsdb';
const DB_USER = 'prtimes';
const DB_PASS = 'prtimes';
const DB_PORT = '5432';

try{
    $db = new PDO('pgsql:host='.DB_HOST.';dbname='.DB_NAME.';port='.DB_PORT.';', DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo 'Connection Refused: '.$e->getMessage();
    exit;
}