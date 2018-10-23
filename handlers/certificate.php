<?php

require_once '../classes/certificate.class.php';
require_once './user_logged_in.php';

if (isset ($_POST['id_certificate'], $_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position'])) {
    $certificatet = Certificate::updateCertificate($_POST['id_certificate'], $_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position']);
    echo json_encode('success');
}
