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
                $("#submit").click(function (e) {
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
                            '../handlers/certificate.php',
                            {
                                id_website: <?php echo $_GET['id']; ?>,
                                shipping_time: $("#shipping_time").val(),
                                dispute: $("#dispute").val(),
                                return_policy: $("#return_policy").val(),
                                customer_service: $("#customer_service").val(),
                                position: 0 /* $("input[name=position]:checked", "#register").val()*/,
                            }, function (data) {
                                if (data == 'success') {
                                    alert('Le nouveau certificat a été ajouté avec succès');
                                    window.location = "./listWebsites.php?user=<?php echo $_GET['user'] ?>";
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