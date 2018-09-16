<?php

require_once '../classes/user.class.php';
require_once '../classes/website.class.php';
require_once '../classes/certificate.class.php';

$res = new stdClass();
$user = new stdClass();
$website = new stdClass();
$certificate = new stdClass();

if (isset($_POST['password'], $_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['gender'])) {
    try {
        $user = User::insertUser($_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['gender']);
        $res->user_registered = true;

    } catch (Exception $err) {
        $res->error = $err->getMessage();
        echo json_encode($res);

    }
} else {
    $res->error = 'Tous les champs client n\'ont pas été renseignés lors de la validation du formulaire';
    echo json_encode($res);

}


if (isset($_POST['url'], $_POST['address'], $_POST['phone'], $_POST['subscription'], $_POST['evaluation_note'], $_POST['rcs_number'])) {
    if ($user instanceof User) {
        try {
            $website = Website::insertWebsite($user->getIdUser(), $_POST['url'], $_POST['address'], $_POST['phone'], $_POST['rcs_number'], $_POST['subscription'], $_POST['evaluation_note']);
            $res->website_registered = true;

        } catch (Exception $err) {
            $res->error = $err->getMessage();
            echo json_encode($res);

        }
    } else {
        $res->error = $err->getMessage();
        echo json_encode('Une erreur est survenue lors de la récupération des données du client');
    }
} else {
    $res->error = 'Tous les champs du site web n\'ont pas été renseignés lors de la validation du formulaire';
    echo json_encode($res);

}


if (isset($_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position'])) {
    if ($website instanceof Website) {
        try {
            $certificate = Certificate::insertCertificate($website->getIdWebsite(), $_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position']);
            $res->certificate_registered = true;

            $website->setIdCertificate($certificate->getIdCertificate());
            $website->update();

        } catch (Exception $err) {
            $res->error = $err->getMessage();
            echo json_encode($res);

        }
    } else {
        $res->error = $err->getMessage();
        echo json_encode('Une erreur est survenue lors de la récupération des données du site web');
    }
} else {
    $res->error = 'Tous les champs du certificat n\'ont pas été renseignés lors de la validation du formulaire';
    echo json_encode($res);

}
echo json_encode($res);
