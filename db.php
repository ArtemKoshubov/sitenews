<?php
$host = "localhost";
$user = "root";
$db = "news";
$password = "";
try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Database connection failed: " . $e->getMessage()]));
}
?>