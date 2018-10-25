<?php
require_once '../handlers/user_logged_in.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        #container{
            width: 100%;
            padding-top: 3%;
            padding-bottom: 5%;
        }
    </style>
</head>
<body>
<div id="container" class="container text-center">
    <h1 class="display-4">Accueil</h1>

    <a href="./insertWithUser.php" class="btn btn-info" role="button"><i class="fas fa-plus-circle"></i> Ajouter un site + utilisateur</a>
    <a href="./insert.php" class="btn btn-info" role="button"><i class="fas fa-plus-circle"></i> Ajouter un site</a>
    <a href="./listUsers.php" class="btn btn-info" role="button"><i class="fas fa-list-alt"></i> Voir la liste des clients</a>
    <button id="disconnect" class="btn btn-info"><i class="fas fa-power-off"></i> D&eacute;connexion</button>

    <script src="./js/disconnect.js"></script>
</div>
</body>
</html>