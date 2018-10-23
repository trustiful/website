<?php

require_once '../handlers/user_logged_in.php';
require_once '../classes/website.class.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des sites</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
            <p>Aucun site web n'a &eacute;t&eacute; enregistr&eacute; pour ce client.</p>
        <?php
    }
    else{
        foreach ($websites as $website) {
            $id = $website->getIdWebsite();
?>
    <table>
        <tr>
            <th></th>
            <th>URL</th>
            <th>Adresse</th>
            <th>Num&eacute;ro de t&eacute;l&eacute;phone</th>
            <th>Num&eacute;ro RCS</th>
            <th>Type d'abonnement</th>
            <th>Note du site</th>
        </tr>
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
            <td>
                <div id="subscription-<?php echo $id; ?>"><?php echo $website->getSubscription() ?></div>
            </td>
            <td>
                <div id="evaluation_note-<?php echo $id; ?>"><?php echo $website->getEvaluationNote() ?></div>
            </td>


            <td>
                <button value="modify" id="mod-<?php echo $id; ?>">Modifier</button>
            </td>
            <td><input type="button" value="&Eacute;diter le certificat"
                       onclick="window.location.href='./editCertificate.php?id=<?php echo $website->getIdCertificate(); ?>'"/></td>
        </tr>
<?php
        }
    }
?>
    </table>
    <script>
    $("button").click(function () {
        var id_row = $(this).closest('tr').attr('id');

        if ($(this).val() == 'modify') {
            $("#url-" + id_row).replaceWith('<input type="url" id="url-' + id_row + '" name="url" value="' + $("#url-" + id_row).text() + '">');
            $("#address-" + id_row).replaceWith('<input type="text" id="address-' + id_row + '" name="address" value="' + $("#address-" + id_row).text() + '">');
            $("#phone-" + id_row).replaceWith('<input type="tel" id="phone-' + id_row + '" name="phone" pattern="[0-9]{10}" value="' + $("#phone-" + id_row).text() + '">');
            $("#rcs_number-" + id_row).replaceWith('<input type="text" id="rcs_number-' + id_row + '" name="rcs_number" value="' + $("#rcs_number-" + id_row).text() + '">');
            $("#subscription-" + id_row).replaceWith('<select id="subscription-' + id_row + '"> <option value="0" selected>Gratuit</option><option value="1">Payant</option></select>');
            $("#evaluation_note-" + id_row).replaceWith('<input type="number" id="evaluation_note-'+ id_row+'" name="evaluation_note" min="1" max="10" value="'+ $("#evaluation_note-" + id_row).text() +'">');
            $(this).val('update');
            $(this).text('Enregistrer');
        }
        else if ($(this).val() == 'update') {
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
        }
    });
    </script>
</body>
</html>