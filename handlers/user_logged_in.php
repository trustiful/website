<?php

require_once '../classes/user.class.php';
session_start();
$res = new stdClass();
if(!isset($_SESSION['user'])){
    header('Location: ../views/login.html');
}