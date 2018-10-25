<?php

require_once '../classes/user.class.php';
require_once '../classes/certificate.class.php';
require_once '../classes/website.class.php';
require_once './user_logged_in.php';

if (isset ($_GET['getUsersList'])) {
    $users = User::getAllUsers();
    echo json_encode($users);
}

if (isset ($_POST['user_id'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['gender'])) {
    $user = User::updateUser($_POST['user_id'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['gender']);
    echo json_encode('success');
}

if (isset ($_POST['delete'], $_POST['id_user'])) {
    try {
        $userWebsites = Website::getAllWebsitesFromUser($_POST['id_user']);
        foreach ($userWebsites as $website){
            Certificate::deleteCertificate('id_website', $website->getIdWebsite());
            Website::deleteWebsite($website->getIdWebsite());
        }
        User::deleteUser($_POST['id_user']);
        echo json_encode('success');

    } catch (Exception $exception) {
        echo json_encode($exception->getMessage());

    }
}