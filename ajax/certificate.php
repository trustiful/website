<?php

require_once '../classes/website.class.php';
require_once '../classes/certificate.class.php';

$res = new stdClass();


if(isset($_POST['url'])){
    $website = Website::getWebsiteBy('url', $_POST['url']);
    $certificate = Certificate::getCerficate($website->getIdCertificate());
    $res->html = $certificate->toHTML($website->getSubscription());
    $res->success = true;
}
else{
    $res->error = 'Ce site n\'est pas répertorié chez Trustiful, veuillez contacter l\'administrateur';
    exit;
}
echo json_encode($res);
