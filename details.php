<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ГАЛАКТИЧЕСКИЙ ВЕСТНИК</title>
    <link rel="stylesheet" href="./css/details.css">
</head>
<body>
    <header>
        <div class="logocontainer">
            <img src="./img/logo.png" alt="Logo">
        </div>
    </header>
    <div class="info">
        <?php 
        require 'db.php';
        $newsid = isset($_GET['id']) ? intval($_GET["id"]):0;
        $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->execute([$newsid]);
        $new = $stmt->fetch(PDO::FETCH_ASSOC);
        $date = "";
        if($new){
            if(preg_match('/^(\d{4})-(\d{2})-(\d{2})/',$new["date"],$matches)){
                $day = $matches[3];
                $month = $matches[2];
                $year = $matches[1];
                $date = $day . ".". $month . ".". $year;
            }
            ?>
        
        <div class="linkbox">
            <p class="main">Главная/</p><p class='actual'><?php echo $new["title"];?></p>
        </div>
        <div class="titlebox">
            <h1 class='title'><?php echo $new["title"]; ?></h1>
        </div>
        <div class="newbox">
            <div class="content">
                <p class='date'><?php echo $date; ?></p>
                <h2><?php  echo $new["announce"]; ?></h2>
                <p><?php echo nl2br($new["content"]); ?>
                </p>
                <button class="back" onclick = 'window.history.back();'>Назад к новостям</button>
            </div>
            <div class="image">
                <img src="./img/<?php echo $new['image']?>" alt="">
            </div>
        </div>
        <?php 
        }
        ?>
        <footer>
        <div class="foottext">
            <p>&copy; 2023 — 2412 «Галактический вестник»</p>
        </div>
    </footer>
    </div>
</body>
</html>