<?php

require_once '../classes/certificate.class.php';
require_once './user_logged_in.php';

if (isset ($_POST['id_certificate'], $_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position'])) {
    Certificate::updateCertificate($_POST['id_certificate'], $_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position']);
    echo json_encode('success');
}

if(isset ($_POST['delete'], $_POST['id_certificate'])){
    try{
        Certificate::deleteCertificate('id_certificate', $_POST['id_certificate']);
        echo json_encode('success');
    } catch (Exception $exception){
        echo json_encode($exception->getMessage());

    }
}