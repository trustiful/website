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

    <h1> Utilisateur</h1>

    <p> Choisir l'utilisateur &agrave; qui ajouter un site</p>
    <select id="users">

    </select>

    <h1>Site</h1>

    <p>URL</p>
    <input type="url" id="url" name="url" placeholder="http:// ou https://">

    <p>Adresse</p>
    <input type="text" id="address" name="address">

    <p>T&eacutel&eacutephone</p>
    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="0601020304" required>

    <p>Type d'abonnement</p>
    <input type="radio" name="subscription" value="0"> Gratuit
    <input type="radio" name="subscription" value="1"> Payant

    <p>Note &eacutevaluation</p>
    <input type="number" id="evaluation_note" name="evaluation_note" min="1" max="10">

    <p>Lieu d'immatriculation</p>
    <input type="text" id="immat_place" name="immat_place" placeholder="Paris" required>

    <p>Num&eacutero SIREN</p>
    <input type="text" id="siren" name="siren" pattern="[0-9]{9}" placeholder="123456789">

    <p>Numéro RCS</p>
    <input type="text" id="rcs_number" name="rcs_number" value="RCS " disabled>


    <h1>Certificat</h1>

    <p>Durée de livraison</p>
    <input type="number" id="shipping_time" name="shipping_time">

    <p>Nombre de litiges</p>
    <input type="number" id="dispute" name="dispute">

    <p>Politiques de retour</p>
    <input type="number" id="return_policy" name="return_policy">

    <p>Réactivité /Service client</p>
    <input type="number" id="customer_service" name="customer_service">

    <div>
        <input type="submit" id="submit" value="Enregistrer">
    </div>
    <script>
        $(document).ready(function () {
            $.get(
                '../handlers/user.php?getUsersList=true', function (data) {
                    data.forEach( function(user){
                        $('#users').append($('<option>', {
                            value: user.id_user,
                            text: user.firstname+' '+user.lastname
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
                e.preventDefault();

                $.post(
                    '../handlers/register.php',
                    {
                        id_user : $("#users").val(),
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

                    },
                    'json'
                );
            });
        });
    </script>
</form>

</body>
</html>