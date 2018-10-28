<?php

require_once '../classes/certificate.class.php';
require_once '../classes/website.class.php';
require_once './user_logged_in.php';

if (isset ($_POST['id_certificate'], $_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position'])) {
    Certificate::updateCertificate($_POST['id_certificate'], $_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position']);
    echo json_encode('success');
}

if (isset ($_POST['delete'], $_POST['id_certificate'])) {
    try {
        $cert = Certificate::getCerficate($_POST['id_certificate']);
        Certificate::deleteCertificate('id_certificate', $_POST['id_certificate']);
        $website = Website::getWebsiteBy('id_website', $cert->getIdWebsite());
        $website->setIdCertificate(null);
        $website->update();

        echo json_encode('success');
    } catch (Exception $exception) {
        echo json_encode($exception->getMessage());
    }
}
if (isset ($_POST['id_website'], $_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position'])) {
    try {
        $certificate = Certificate::insertCertificate($_POST['id_website'], $_POST['shipping_time'], $_POST['dispute'], $_POST['return_policy'], $_POST['customer_service'], $_POST['position']);
        $website = Website::getWebsiteBy('id_website', $_POST['id_website']);
        $website->setIdCertificate($certificate->getIdCertificate());
        $website->update();
        echo json_encode('success');
    } catch (Exception $exception) {
        echo json_encode($exception->getMessage());
    }
}