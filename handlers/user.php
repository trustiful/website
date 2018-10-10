<?php

require_once '../classes/user.class.php';

if (isset ($_GET['getUsersList'])) {
    $users = User::getAllUsers();
    echo json_encode($users);
}