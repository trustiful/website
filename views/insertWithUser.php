<?php
require_once '../handlers/user_logged_in.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un site et un utilisateur</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
</head>
<body>
<div id="container" class="container text-center">
    <form id="register">
        <h1 class="display-4">Utilisateur</h1>
        <input type="hidden" id="email" name="email" value="-">

        <input type="hidden" id="password" name="password" value="-">

        <div class="form-group">
            <label for="firstname">Pr&eacute;nom</label>
            <input class="form-control" type="text" id="firstname" name="firstname" required/>
        </div>

        <div class="form-group">
            <label>Nom</label>
            <input class="form-control" type="text" id="lastname" name="lastname" required/>
        </div>

        <div class="form-group">
            <label>Sexe</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" id="h" type="radio" name="gender" value="H" checked>
            <label class="form-check-label" for="h">H</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" id="f" type="radio" name="gender" value="F">
            <label class="form-check-label" for="f">F</label>
        </div>

        <hr/>

        <h1 class="display-4">Site</h1>

        <div class="form-group">
            <label>URL</label>
            <input class="form-control" type="url" id="url" name="url" placeholder="ex. : http://... ou https://..."
                   required/>
        </div>

        <div class="form-group">
            <label>Adresse</label>
            <input class="form-control" type="text" id="address" name="address" required/>
        </div>

        <div class="form-group">
            <label>T&eacute;l&eacute;phone</label>
            <input class="form-control" type="tel" id="phone" name="phone" pattern="[0-9]{10}"
                   placeholder="ex. : 0601020304" required/>
        </div>

        <div class="form-group">
            <label>Note &eacute;valuation</label>
            <input class="form-control" type="number" id="evaluation_note" name="evaluation_note" min="1" max="10"
                   required/>
        </div>

        <div class="form-group">
            <label>Lieu d&apos;immatriculation</label>
            <input class="form-control" type="text" id="immat_place" name="immat_place" placeholder="ex. : Paris"
                   required/>
        </div>

        <div class="form-group">
            <label>Num&eacute;ro SIREN</label>
            <input class="form-control" type="text" id="siren" name="siren" pattern="[0-9]{9}"
                   placeholder="ex. : 123456789" required/>
        </div>

        <div class="form-group">
            <label>Num&eacute;ro RCS</label>
            <input class="form-control" type="text" id="rcs_number" name="rcs_number" value="RCS " disabled>
        </div>

        <div class="form-group">
            <label>Type d&apos;abonnement</label>
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
            <label>Dur&eacute;e de livraison (en heure)</label>
            <input class="form-control" type="number" id="shipping_time" name="shipping_time" min=0 required/>
        </div>

        <div class="form-group">
            <label>Nombre de litiges</label>
            <input class="form-control" type="number" id="dispute" name="dispute" min=0 required/>
        </div>

        <div class="form-group">
            <label>Politiques de retour (en jour)</label>
            <input class="form-control" type="number" id="return_policy" name="return_policy" min=0 required/>
        </div>

        <div class="form-group">
            <label>R&eacute;activit&eacute; / Service client (en heure)</label>
            <input class="form-control" type="number" id="customer_service" name="customer_service" min=0 required/>
        </div>

        <!--<label>Position du certificat</label>
        <input type="radio" name="position" value="0"> Vertical
        <input type="radio" name="position" value="1"> Horizontal-->

        <div id="button-div">
            <button class="btn" type="submit" id="submit">Enregistrer</button>
            <a href="./home.php" class="btn btn-danger" role="button">Annuler</a>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {

        $("#immat_place").focusout(function () {
            $("#rcs_number").val('RCS ' + $("#immat_place").val() + ' ' + $("#siren").val());
        });
        $("#siren").focusout(function () {
            $("#rcs_number").val('RCS ' + $("#immat_place").val() + ' ' + $("#siren").val());
        });

        $("#submit").click(function () {
            var valid = true;
            $("input").each(function () {
                console.log($(this).val());
                if ($(this).val() == "") {
                    valid = false;
                    return;
                }
            });
            if (valid) {
                $.post(
                    '../handlers/register.php',
                    {
                        email: $("#firstname").val() + $("#lastname").val() + Date.now(),
                        password: $("#password").val(),
                        firstname: $("#firstname").val(),
                        lastname: $("#lastname").val(),
                        gender: $("input[name=gender]:checked", "#register").val(),
                        role: "client",

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
                        console.log(data);
                        if (data.user_registered && data.website_registered && data.certificate_registered) {
                            alert('Les données ont bien été enregistrées');
                            window.location = './home.php';
                        } else {
                            alert('Un problème est survenu lors de l\'insertion des données);
                        }
                    },
                    'json'
                );
            }
        });
    });
</script>
<footer>
    <a href="./home.php" class="btn btn-info" role="button"><i class="fas fa-home"></i></a>
</footer>
</body>
</html>