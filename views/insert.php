<?php
require_once '../handlers/user_logged_in.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un site</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
</head>
<body>
<div id="container" class="container text-center">
    <form id="register">
        <h1 class="display-4"> Utilisateur</h1>

        <div class="form-group">
            <label for="users">Choisir l&apos;utilisateur &agrave; qui ajouter un site</label>
            <select class="form-control text-center" id="users"></select>
        </div>

        <hr/>

        <h1 class="display-4">Site</h1>

        <div class="form-group">
            <label for="url">URL</label>
            <input class="form-control" type="url" id="url" name="url" placeholder="http:// ou https://" required>
        </div>

        <div class="form-group">
            <label for="address">Adresse</label>
            <input class="form-control" type="text" id="address" name="address" required>
        </div>

        <div class="form-group">
            <label for="phone">T&eacutel&eacute;phone</label>
            <input class="form-control" type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="0601020304"
                   required>
        </div>

        <div class="form-group">
            <label for="evaluation_note">Note &eacute;valuation</label>
            <input class="form-control" type="number" id="evaluation_note" name="evaluation_note" min="1" max="10" required>
        </div>

        <div class="form-group">
            <label for="immat_place">Lieu d&apos;immatriculation</label>
            <input class="form-control" type="text" id="immat_place" name="immat_place" placeholder="Paris" required>
        </div>

        <div class="form-group">
            <label for="siren">Num&eacute;ro SIREN</label>
            <input class="form-control" type="text" id="siren" name="siren" pattern="[0-9]{9}" placeholder="123456789" required>
        </div>

        <div class="form-group">
            <label for="rcs_number">Num&eacute;ro RCS</label>
            <input class="form-control" type="text" id="rcs_number" name="rcs_number" value="RCS " disabled>
        </div>

        <div class="form-group">
            <p>Type d&apos;abonnement</p>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" id="free" type="radio" name="subscription" value="0" checked>
            <label class="form-check-label" for="free">Gratuit</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" id="payed" type="radio" name="subscription" value="1">
            <label class="form-check-label" for="payed">Payant</label>
        </div>

        <hr/>

        <h1 class="display-4">Certificat</h1>

        <div class="form-group">
            <label for="shipping_time">Dur&eacute;e de livraison (en heure)</label>
            <input class="form-control" type="number" id="shipping_time" name="shipping_time" min=0 required>
        </div>

        <div class="form-group">
            <label for="dispute">Nombre de litiges</label>
            <input class="form-control" type="number" id="dispute" name="dispute" min=0 required>
        </div>

        <div class="form-group">
            <label for="return_policy">Politiques de retour (en jour)</label>
            <input class="form-control" type="number" id="return_policy" name="return_policy" min=0 required>
        </div>

        <div class="form-group">
            <label for="customer_service">R&eacute;activit&eacute; / Service client (en heure)</label>
            <input class="form-control" type="number" id="customer_service" name="customer_service" min=0 required>
        </div>

        <div id="button-div">
            <button class="btn" type="submit" id="submit">Enregistrer</button>
            <a href="./home.php" class="btn btn-danger" role="button">Annuler</a>
        </div>

        <script>
            $(document).ready(function () {
                $.get(
                    '../handlers/user.php?getUsersList=true', function (data) {
                        data.forEach(function (user) {
                            $('#users').append($('<option>', {
                                value: user.id_user,
                                text: user.firstname + ' ' + user.lastname
                            }))
                        });
                    },
                    'json'
                );

                $("#immat_place").focusout(function () {
                    $("#rcs_number").val('RCS ' + $("#immat_place").val() + ' ' + $("#siren").val());
                });
                $("#siren").focusout(function () {
                    $("#rcs_number").val('RCS ' + $("#immat_place").val() + ' ' + $("#siren").val());
                });

                $("#submit").click(function (e) {
                    var valid = true;
                    $("input").each(function () {
                        console.log($(this).val());
                        if ($(this).val() == "") {
                            valid = false;
                            return;
                        }
                    });
                    if(valid){
                        $.post(
                            '../handlers/register.php',
                            {
                                id_user: $("#users").val(),
                                url: $("#url").val(),
                                address: $("#address").val(),
                                phone: $("#phone").val(),
                                rcs_number: $("#rcs_number").val(),
                                subscription: $("input[name=subscription]:checked", "#register").val(),
                                evaluation_note: $("#evaluation_note").val(),

                                shipping_time: $("#shipping_time").val(),
                                dispute: $("#dispute").val(),
                                return_policy: $("#return_policy").val(),
                                customer_service: $("#customer_service").val(),
                                position: 0 /* $("input[name=position]:checked", "#register").val()*/,
                            },
                            function (data) {
                                if(data.website_registered && data.certificate_registered){
                                    alert('Le site et certificat ont bien été enregistrés');
                                    window.location = './home.php';
                                }
                            },
                            'json'
                        );
                    }
                });
            });
        </script>
    </form>
</div>
<footer>
    <a href="./home.php" class="btn btn-info" role="button"><i class="fas fa-home"></i></a>
</footer>
</body>
</html>