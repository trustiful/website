<?php

session_start();

session_unset();

session_destroy();

$res = new stdClass();
$res->disconnected = true;
echo json_encode($res);