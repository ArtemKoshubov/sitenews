<?php
require "db.php";
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
$data = json_decode(file_get_contents("php://input"),true);
$page = $data["page"];
$pageLimit = 4;
$displ = ($page - 1) * $pageLimit;
$stmt = $pdo->prepare("SELECT * FROM news ORDER BY id DESC LIMIT :displ, :pageLimit");
$stmt->bindValue(':displ',$displ,PDO::PARAM_INT);
$stmt->bindValue(':pageLimit',$pageLimit,PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->query("SELECT COUNT(*) as total FROM news");
$totalItems = $stmt->fetchColumn();
$pages =  ceil($totalItems/$pageLimit);
$response = [
    "success"=>true,
    "page"=>$page,
    "pages"=>$pages,
    "allnews"=>$totalItems,
    "news"=>$items
];  
echo json_encode($response,JSON_UNESCAPED_UNICODE);
?>