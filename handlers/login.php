<?php

require_once '../classes/user.class.php';

$res = new stdClass();

if(isset($_POST['email']) && ($_POST['password'])){
    try {
        User::login($_POST['email'], $_POST['password']);
        if(isset($_SESSION['user'])){
            $res->logged_in = true;
            echo json_encode($res);
        }
        else{
            $res->error = 'La combinaison email / mot de passe est incorrecte';
            echo json_encode($res);
        }
    } catch (Exception $e) {
        $res->error = $e->getMessage();
        echo json_encode($res);
    }
} else {
    $res->error = 'L\'email et/ou le mot de passe n\'ont pas été renseignés';
    echo json_encode($res);
}