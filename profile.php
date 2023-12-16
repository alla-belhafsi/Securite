<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>My profile</h1>
    <?php 
        if(isset($_SESSION["subscriber"])) {
        $infosSession = $_SESSION["subscriber"];
        }
    ?>

    <p>Pseudo : <?= $infosSession["pseudonym"]?></p>
    <p>Pseudo : <?= $infosSession["mail"]?></p>
</body>
</html>