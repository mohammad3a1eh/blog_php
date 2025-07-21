<?php
const DATABASE_HOST = "localhost:3306";
const DATABASE_NAME = "blog_app";
const DATABASE_USER = "root";
const DATABASE_PASS = "";
const RESULTS_PER_PAGE = 5;

try {
    $pdo = new PDO("mysql:host=".DATABASE_HOST.";dbname=".DATABASE_NAME.";charset=utf8", DATABASE_USER, DATABASE_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}