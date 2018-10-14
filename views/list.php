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
            <th>Sexe</th>
        </tr>
        <?php
        foreach ($users as $user){
            ?>
        <tr id="<?php echo $user->getIdUser(); ?>">
            <td><div class="id_user"><?php echo $user->getIdUser(); ?></div></td>
            <td><div class="firstname"><?php echo $user->getFirstname(); ?></div></td>
            <td><div class="lastname"><?php echo $user->getLastname(); ?></div></td>
            <td><div class="email"><?php echo $user->getEmail(); ?></div></td>
            <td><div class="gender"><?php echo $user->getGender() ?></div></td>
            <td><button value="modify">Modifier</button></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <script>
        $("button").click(function() {
            if($(this).val() == 'modify'){
                var id_row = $(this).closest('tr').attr('id');
                $("tr#" +id_row +" div.firstname").replaceWith('<input type="text" id="firstname" name="firstname" value="'+  $("tr#" +id_row +" div.firstname").text()+ '">');
                $("tr#" +id_row +" div.lastname").replaceWith('<input type="text" id="lastname" name="lastname" value="'+  $("tr#" +id_row +" div.lastname").text()+ '">');
                $("tr#" +id_row +" div.email").replaceWith('<input type="text" id="email" name="email" value="'+  $("tr#" +id_row +" div.email").text()+ '">');
                $("tr#" +id_row +" div.gender").replaceWith('<select id="gender"> <option value="H" selected>H</option><option value="F">F</option></select>');
                $(this).val('update');
                $(this).text('Enregistrer');
            }
            else if ($(this).val() == 'update'){
                alert($(this).val());
            }

        });

    </script>
</body>
</html>