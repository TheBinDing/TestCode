<?php
session_start();
date_default_timezone_set('Asia/Bangkok');

require("PHPMailer_5.2.4/class.phpmailer.php");
require("AjaxSave.php");
require("inc/connect.php");

$response = array();
$mode = $_POST['mode'];
$arr = $_POST;

switch ($mode)
{
    case 'sendMail' :
        $response = sendMail($arr);
    break;
    case 'loadTest' :
        $response = loadTest($arr);
    break;
    case 'load_num_employee' :
        $response = load_num_employee($arr);
    break;
}

echo json_encode($response);

?>