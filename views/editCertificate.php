<?php

require_once '../handlers/user_logged_in.php';
require_once '../classes/certificate.class.php';
require_once '../classes/website.class.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>&Eacute;dition du certificat</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
</head>
<body>
<?php
try {
    $certificate = Certificate::getCerficate($_GET['id']);
} catch (Exception $exception) {
    header('Location: ./listUsers.php');
}
?><?php
if (!$certificate) {
    ?>
    <script>
        alert("Aucun certificat n'a été enregistré pour ce site.");
        window.location = "./listWebsites.php?user=<?php echo $_GET['user']; ?>";
    </script>
    <?php
}
else{
$website = Website::getWebsiteBy('id_website', $certificate->getIdWebsite());

$id = $certificate->getIdCertificate();
?>
<header>
    <a href="./listWebsites.php?user=<?php echo $_GET['user']; ?>" class="btn btn-info" role="button"><i class="fas fa-arrow-left"></i> Liste des sites</a>
</header>
<h1 class="display-4 text-center" style="padding: 1% !important">Certificat du
    site <?php echo $website->getUrl(); ?></h1>
<table class="table table-striped text-center">
    <tr>
        <th></th>
        <th>D&eacute;lais de livraison</th>
        <th>Nombre de litiges</th>
        <th>Politique de retour</th>
        <th>R&eacute;activité du service client</th>
        <th>Position</th>
        <th></th>
        <th></th>
    </tr>
    <tr id="<?php echo $id; ?>" class="text-center">
        <td>
            <div id="id_certificate-<?php echo $id; ?>"><?php echo $id; ?></div>
        </td>
        <td>
            <div id="shipping_time-<?php echo $id; ?>"><?php echo $certificate->getShippingTime(); ?></div>
        </td>
        <td>
            <div id="dispute-<?php echo $id; ?>"><?php echo $certificate->getDispute(); ?></div>
        </td>
        <td>
            <div id="return_policy-<?php echo $id; ?>"><?php echo $certificate->getReturnPolicy(); ?></div>
        </td>
        <td>
            <div id="customer_service-<?php echo $id; ?>"><?php echo $certificate->getCustomerService() ?></div>
        </td>
        <td>
            <div id="position-<?php echo $id; ?>"><?php echo $certificate->getPosition() ?></div>
        </td>
        <td>
            <button class="btn btn-info" value="modify" id="mod-<?php echo $id; ?>">Modifier</button>
        </td>
        <td>
            <button class="btn btn-info" value="delete" id="del-<?php echo $id; ?>">Supprimer</button>
        </td>
    </tr>
    <?php
    }
    ?>
</table>
<script>
    $("button").click(function () {
        var id_row = $(this).closest('tr').attr('id');

        switch ($(this).val()) {
            case 'modify':
                $("#shipping_time-" + id_row).replaceWith('<input type="number" id="shipping_time-' + id_row + '" name="shipping_time" value="' + $("#shipping_time-" + id_row).text() + '">');
                $("#dispute-" + id_row).replaceWith('<input type="number" id="dispute-' + id_row + '" name="dispute" value="' + $("#dispute-" + id_row).text() + '">');
                $("#return_policy-" + id_row).replaceWith('<input type="number" id="return_policy-' + id_row + '" name="return_policy" value="' + $("#return_policy-" + id_row).text() + '">');
                $("#customer_service-" + id_row).replaceWith('<input type="number" id="customer_service-' + id_row + '" name="customer_service" value="' + $("#customer_service-" + id_row).text() + '">');
                $("#position-" + id_row).replaceWith('<select id="position-' + id_row + '"> <option value="0" '+ ($("#position-" + id_row).text() == 0 ? "selected" : "" ) +'>Vertical</option><option value="1" '+ ($("#position-" + id_row).text() == 1 ? "selected" : "" ) +' >Horizontal</option></select>');
                $(this).val('update');
                $(this).text('Enregistrer');
                break;

            case 'update':
                $.post(
                    '../handlers/certificate.php',
                    {
                        id_certificate: id_row,
                        shipping_time: $("#shipping_time-" + id_row).val(),
                        dispute: $("#dispute-" + id_row).val(),
                        return_policy: $("#return_policy-" + id_row).val(),
                        customer_service: $("#customer_service-" + id_row).val(),
                        position: $("#position-" + id_row).val(),
                    },
                    function (data) {
                        $("#shipping_time-" + id_row).replaceWith('<div id="shipping_time-' + id_row + '">' + $("#shipping_time-" + id_row).val() + '</div>');
                        $("#dispute-" + id_row).replaceWith('<div id="dispute-' + id_row + '">' + $("#dispute-" + id_row).val() + '</div>');
                        $("#return_policy-" + id_row).replaceWith('<div id="return_policy-' + id_row + '">' + $("#return_policy-" + id_row).val() + '</div>');
                        $("#customer_service-" + id_row).replaceWith('<div id="customer_service-' + id_row + '">' + $("#customer_service-" + id_row).val() + '</div>');
                        $("#position-" + id_row).replaceWith('<div id="position-' + id_row + '">' + $("#position-" + id_row).val() + '</div>');
                        $("#mod-" + id_row).val('modify');
                        $("#mod-" + id_row).text('Modifier');
                    },
                    'json'
                );
                break;

            case 'delete':
                var result = confirm('Souhaitez-vous réellement supprimer ce certificat ?');
                if (result) {
                    $.post(
                        '../handlers/certificate.php',
                        {
                            delete: true,
                            id_certificate: id_row,
                        },function (data) {
                            if(data == 'success'){
                                alert('Le certificat a été supprimé avec succès');
                                window.location = "./listWebsites.php?user=<?php echo $_GET['user'] ?>";
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