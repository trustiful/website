<?php

require_once '../classes/website.class.php';
require_once './user_logged_in.php';

if (isset ($_POST['id_website'], $_POST['url'], $_POST['address'], $_POST['phone'], $_POST['rcs_number'], $_POST['subscription'], $_POST['evaluation_note'])) {
    $website = Website::updateWebsite($_POST['id_website'], $_POST['url'], $_POST['address'], $_POST['phone'], $_POST['rcs_number'], $_POST['subscription'], $_POST['evaluation_note']);
    echo json_encode('success');
}