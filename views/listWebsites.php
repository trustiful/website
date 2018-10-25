<?php

require_once '../handlers/user_logged_in.php';
require_once '../classes/website.class.php';
require_once '../classes/user.class.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des sites</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
</head>
<body>
<?php
try {
    $websites = Website::getAllWebsitesFromUser($_GET['user']);
} catch (Exception $exception) {
    header('Location: ./listUsers.php');
}
if (count($websites) == 0) {
    ?>
    <script>
        alert("Aucun site n'a été enregistré pour ce client.");
        window.location = "./listUsers.php";
    </script>
    <?php
}
else{
$user = User::getUserBy('id_user', $_GET['user']);
?>
<header>
    <a href="./listUsers.php" class="btn btn-info" role="button"><i class="fas fa-arrow-left"></i> Liste des clients</a>
</header>
<h1 class="display-4 text-center" style="padding: 1% !important">Liste des sites web
    de <?php echo $user->getFirstname() . ' ' . $user->getLastname() ?></h1>

<table class="table table-striped">
    <thead>
    <tr>
        <th></th>
        <th>URL</th>
        <th>Adresse</th>
        <th>Num&eacute;ro de t&eacute;l&eacute;phone</th>
        <th>Num&eacute;ro RCS</th>
        <th>Type d'abonnement</th>
        <th>Note du site</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($websites as $website) {
        $id = $website->getIdWebsite();
        ?>

        <tr id="<?php echo $id; ?>">
            <td>
                <div id="id_$website-<?php echo $id; ?>"><?php echo $id; ?></div>
            </td>
            <td>
                <div id="url-<?php echo $id; ?>"><?php echo $website->getUrl(); ?></div>
            </td>
            <td>
                <div id="address-<?php echo $id; ?>"><?php echo $website->getAddress(); ?></div>
            </td>
            <td>
                <div id="phone-<?php echo $id; ?>"><?php echo $website->getPhone(); ?></div>
            </td>
            <td>
                <div id="rcs_number-<?php echo $id; ?>"><?php echo $website->getRcsNumber() ?></div>
            </td>
            <td class="text-center">
                <div id="subscription-<?php echo $id; ?>"><?php echo $website->getSubscription() ?></div>
            </td>
            <td class="text-center">
                <div id="evaluation_note-<?php echo $id; ?>"><?php echo $website->getEvaluationNote() ?></div>
            </td>

            <td class="text-center">
                <button class="btn btn-info" value="modify" id="mod-<?php echo $id; ?>">Modifier</button>
            </td>
            <td class="text-center">
                <input class="btn btn-info" type="button" value="&Eacute;diter le certificat"
                       onclick="window.location.href='./editCertificate.php?user=<?php echo $website->getIdUser(); ?>&id=<?php echo $website->getIdCertificate(); ?>'"/>
            </td>
            <td class="text-center">
                <button class="btn btn-info" value="delete">Supprimer</button>
            </td>
        </tr>
        <?php
    }
    }
    ?>
    </tbody>
</table>
<script>
    $("button").click(function () {
        var id_row = $(this).closest('tr').attr('id');

        switch ($(this).val()) {
            case 'modify':
                $("#url-" + id_row).replaceWith('<input type="url" id="url-' + id_row + '" name="url" value="' + $("#url-" + id_row).text() + '" style="width:100%">');
                $("#address-" + id_row).replaceWith('<input type="text" id="address-' + id_row + '" name="address" value="' + $("#address-" + id_row).text() + '" style="width:100%">');
                $("#phone-" + id_row).replaceWith('<input type="tel" id="phone-' + id_row + '" name="phone" pattern="[0-9]{10}" value="' + $("#phone-" + id_row).text() + '" style="width:100%">');
                $("#rcs_number-" + id_row).replaceWith('<input type="text" id="rcs_number-' + id_row + '" name="rcs_number" value="' + $("#rcs_number-" + id_row).text() + '" style="width:100%">');
                $("#subscription-" + id_row).replaceWith('<select id="subscription-' + id_row + '"> <option value="0"  '+ ($("#subscription-" + id_row).text() == 0 ? "selected" : "" ) +' >Gratuit</option><option value="1" '+ ($("#subscription-" + id_row).text() == 1 ? "selected" : "" ) +'>Payant</option></select>');
                $("#evaluation_note-" + id_row).replaceWith('<input type="number" id="evaluation_note-' + id_row + '" name="evaluation_note" min="1" max="10" value="' + $("#evaluation_note-" + id_row).text() + '" style="width:100%">');
                $(this).val('update');
                $(this).text('Enregistrer');
                break;

            case 'update':
                $.post(
                    '../handlers/website.php',
                    {
                        id_website: id_row,
                        url: $("#url-" + id_row).val(),
                        address: $("#address-" + id_row).val(),
                        phone: $("#phone-" + id_row).val(),
                        rcs_number: $("#rcs_number-" + id_row).val(),
                        subscription: $("#subscription-" + id_row).val(),
                        evaluation_note: $("#evaluation_note-" + id_row).val()
                    },
                    function (data) {
                        $("#url-" + id_row).replaceWith('<div id="url-' + id_row + '">' + $("#url-" + id_row).val() + '</div>');
                        $("#address-" + id_row).replaceWith('<div id="address-' + id_row + '">' + $("#address-" + id_row).val() + '</div>');
                        $("#phone-" + id_row).replaceWith('<div id="phone-' + id_row + '">' + $("#phone-" + id_row).val() + '</div>');
                        $("#rcs_number-" + id_row).replaceWith('<div id="rcs_number-' + id_row + '">' + $("#rcs_number-" + id_row).val() + '</div>');
                        $("#subscription-" + id_row).replaceWith('<div id="subscription-' + id_row + '">' + $("#subscription-" + id_row).val() + '</div>');
                        $("#evaluation_note-" + id_row).replaceWith('<div id="evaluation_note-' + id_row + '">' + $("#evaluation_note-" + id_row).val() + '</div>');
                        $("#mod-" + id_row).val('modify');
                        $("#mod-" + id_row).text('Modifier');
                    },
                    'json'
                );
                break;
            case 'delete':
                var result = confirm('Souhaitez-vous réellement supprimer ce site ainsi que son certificat ?');
                if (result) {
                    $.post(
                        '../handlers/website.php',
                        {
                            delete: true,
                            id_website: id_row,
                        },
                        function (data) {
                            if(data == 'success'){
                                alert('Les site et certificat ont été supprimés avec succès');
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