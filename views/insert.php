<?php
require_once '../handlers/user_logged_in.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un site</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<form id="register">

    <p>e-mail</p>
    <input type="email" id="email" name="email">

    <p>Mot de passe</p>
    <input type="password" id="password" name="password">

    <p>Pr&eacutenom</p>
    <input type="text" id="firstname" name="firstname">

    <p>Nom</p>
    <input type="text" id="lastname" name="lastname">

    <p>Sexe</p>
    <input type="radio" name="gender" value="H"> H
    <input type="radio" name="gender" value="F"> F
    <div>
        <input type="submit" id="submit" value="Enregistrer">
    </div>
</form>
</body>
</html>