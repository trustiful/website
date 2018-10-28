<?php
require_once '../handlers/user_logged_in.php';

require_once '../classes/user.class.php';
$users = User::getAllUsers();
if (count($users) == 0) {
    ?>
    <script>
    alert("Aucun client n'a été enregistré.");
    window.location = "./home.php";
    </script>
    <?php
} else {

    ?>


    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Liste des clients</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    </head>
    <body>
    <h1 class="display-4 text-center" style="padding: 1% !important">Liste des clients</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>Pr&eacute;nom</th>
            <th>Nom</th>
            <th>E-mail</th>
            <th class="text-center">Sexe</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
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
                <td class="text-center">
                    <div id="gender-<?php echo $id; ?>"><?php echo $user->getGender() ?></div>
                </td>
                <td class="text-center">
                    <button class="btn btn-info" value="modify" id="mod-<?php echo $id; ?>">Modifier</button>
                </td>
                <td class="text-center">
                    <input class="btn btn-info" type="button" value="Voir les sites et certificats"
                           onclick="window.location.href='./listWebsites.php?user=<?php echo $id; ?>'"/>
                </td>
                <td class="text-center">
                    <button class="btn btn-info" value="delete">Supprimer</button>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <script>
        $("button").click(function () {
            var id_row = $(this).closest('tr').attr('id');

            switch ($(this).val()) {
                case 'modify':
                    $("#firstname-" + id_row).replaceWith('<input type="text" id="firstname-' + id_row + '" name="firstname" value="' + $("#firstname-" + id_row).text() + '" style="width:100%">');
                    $("#lastname-" + id_row).replaceWith('<input type="text" id="lastname-' + id_row + '" ="lastname" value="' + $("#lastname-" + id_row).text() + '" style="width:100%">');
                    $("#email-" + id_row).replaceWith('<input type="text" id="email-' + id_row + '" name="email" value="' + $("#email-" + id_row).text() + '" style="width:100%">');
                    $("#gender-" + id_row).replaceWith('<select id="gender-' + id_row + '"> <option value="H"' + ($("#gender-" + id_row).text() == "H" ? "selected" : "") + ' >H</option><option value="F" ' + ($("#gender-" + id_row).text() == "F" ? "selected" : "") + '>F</option></select>');
                    $(this).val('update');
                    $(this).text('Enregistrer');
                    break;
                case 'update':
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
                    break;
                case 'delete':
                    var result = confirm('Souhaitez-vous réellement supprimer ce client ainsi que ses sites et certificats ?');
                    if (result) {
                        $.post(
                            '../handlers/user.php',
                            {
                                delete: true,
                                id_user: id_row,
                            },
                            function (data) {
                                if(data == "success"){
                                    alert('Client supprimé avec succès');
                                    location.reload();
                                }
                            },
                            'json'
                        );
                    }
                    break;
            }
        });

    </script>
    <footer>
        <a href="./home.php" class="btn btn-info" role="button"><i class="fas fa-home"></i></a>
    </footer>
    </body>
    </html>
    <?php
}
?>