<?php
require_once '../handlers/user_logged_in.php';

require_once '../classes/user.class.php';
require_once '../classes/website.class.php';
require_once '../classes/certificate.class.php';

$users = User::getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des clients</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <table>
        <tr>
            <th></th>
            <th>Pr&eacute;nom</th>
            <th>Nom</th>
            <th>E-mail</th>
            <th>Mot de passe</th>
            <th>Sexe</th>
        </tr>
        <?php
        foreach ($users as $user){
            ?>
        <tr>
            <td><?php echo $user->getIdUser(); ?></td>
            <td><?php echo $user->getFirstname(); ?></td>
            <td><?php echo $user->getLastname(); ?></td>
            <td><?php echo $user->getEmail(); ?></td>
            <td> ********** </td>
            <td><?php echo $user->getGender() ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>