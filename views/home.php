<?php
    require_once '../handlers/user_logged_in.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <p>Accueil</p>

    <a href="./insert.php"> Ajouter un nouveau site</a>
    <a href="./insertWithUser.php"> Ajouter un nouveau site + utilisateur</a>
    <a href="./list.php"> Voir la liste des sites enregistr&eacutes</a>
    <a href="" id="disconnect">D&eacuteconnexion</a>
    <script src="./js/disconnect.js"></script>
</body>
</html>