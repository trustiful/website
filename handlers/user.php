<?php

require_once '../classes/user.class.php';
require_once './user_logged_in.php';

if (isset ($_GET['getUsersList'])) {
    $users = User::getAllUsers();
    echo json_encode($users);
}

if (isset ($_POST['user_id'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['gender'])) {
    $user = User::updateUser($_POST['user_id'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['gender']);
    echo json_encode('success');
}