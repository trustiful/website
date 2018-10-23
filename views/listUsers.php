<?php
require_once '../handlers/user_logged_in.php';

require_once '../classes/user.class.php';
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
    foreach ($users as $user) {
        $id = $user->getIdUser();
        ?>
        <tr id="<?php echo $id; ?>">
            <td>
                <div id="id_user-<?php echo $id; ?>"><?php echo $id; ?></div>
            </td>
            <td>
                <div id="firstname-<?php echo $id; ?>"><?php echo $user->getFirstname(); ?></div>
            </td>
            <td>
                <div id="lastname-<?php echo $id; ?>"><?php echo $user->getLastname(); ?></div>
            </td>

            <td>
                <div id="email-<?php echo $id; ?>"><?php echo $user->getEmail(); ?></div>
            </td>
            <td>
                <div id="gender-<?php echo $id; ?>"><?php echo $user->getGender() ?></div>
            </td>
            <td>
                <button value="modify" id="mod-<?php echo $id; ?>">Modifier</button>
            </td>
            <td><input type="button" value="Voir les sites et certificats"
                       onclick="window.location.href='./listWebsites.php?user=<?php echo $id; ?>'"/></td>
        </tr>
        <?php
    }
    ?>
</table>
<script>
    $("button").click(function () {
        var id_row = $(this).closest('tr').attr('id');

        if ($(this).val() == 'modify') {
            $("#firstname-" + id_row).replaceWith('<input type="text" id="firstname-' + id_row + '" name="firstname" value="' + $("#firstname-" + id_row).text() + '">');
            $("#lastname-" + id_row).replaceWith('<input type="text" id="lastname-' + id_row + '" ="lastname" value="' + $("#lastname-" + id_row).text() + '">');
            $("#email-" + id_row).replaceWith('<input type="text" id="email-' + id_row + '" name="email" value="' + $("#email-" + id_row).text() + '">');
            $("#gender-" + id_row).replaceWith('<select id="gender-' + id_row + '"> <option value="H" selected>H</option><option value="F">F</option></select>');
            $(this).val('update');
            $(this).text('Enregistrer');
        }
        else if ($(this).val() == 'update') {
            $.post(
                '../handlers/user.php',
                {
                    user_id: id_row,
                    firstname: $("#firstname-" + id_row).val(),
                    lastname: $("#lastname-" + id_row).val(),
                    email: $("#email-" + id_row).val(),
                    gender: $("#gender-" + id_row).find(":selected").text()
                },
                function (data) {
                    $("#firstname-" + id_row).replaceWith('<div id="firstname-' + id_row + '">' + $("#firstname-" + id_row).val() + '</div>');
                    $("#lastname-" + id_row).replaceWith('<div id="lastname-' + id_row + '">' + $("#lastname-" + id_row).val() + '</div>');
                    $("#email-" + id_row).replaceWith('<div id="email-' + id_row + '">' + $("#email-" + id_row).val() + '</div>');
                    $("#gender-" + id_row).replaceWith('<div id="gender-' + id_row + '">' + $("#gender-" + id_row).val() + '</div>');
                    $("#mod-" + id_row).val('modify');
                    $("#mod-" + id_row).text('Modifier');
                },
                'json'
            );
        }
    });

</script>
</body>
</html>