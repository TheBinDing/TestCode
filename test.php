<?php
    /**
    * Simple example script using PHPMailer with exceptions enabled
    * @package phpmailer
    * @version $Id$
    */

    @session_start();
    date_default_timezone_set('Asia/Bangkok');

    require("PHPMailer_5.2.4/class.phpmailer.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">
    <link href="css/clockpicker.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/switchery/switchery.css" rel="stylesheet">
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<body>
    <div class="row">
        <div id="page-wrapper" class="gray-bg">
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <h1>
                <div class="btn-group">
                    <a class="btn-white btn btn-xs" onClick="test();" role="button">แก้ไข</a>
                </div>
            </h1>    
            </div>
        </div>
        <div class="col-xs-12 col-sm-1"></div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/plugins/datapicker/bootstrap-datepicker-thai.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/clockpicker.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/footable/footable.all.min.js"></script>
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/switchery/switchery.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/pace.js"></script>
<script type="text/javascript">
    jQuery(function( $ ) {
        travflex.compulsory.Criteria = {};

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
    });

    var travflex = {
        compulsory: new Object()
    };

    function test() {
        travflex.compulsory.Criteria['mode'] = 'sendMail';
        travflex.compulsory.Criteria['detail'] = 'Test';
        travflex.compulsory.Criteria['subject'] = 'www.google.co.th';
        travflex.compulsory.Criteria['from'] = 'apichat.si@thaipolycons.co.th';
        travflex.compulsory.Criteria['name'] = 'apichat';
        travflex.compulsory.Criteria['send'] = '1';
        var ajax_config = {
            url: "AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: travflex.compulsory.Criteria,
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            if(response == 1) {
                swal("เรียบร้อยจร่ะ!");
            } else {
                swal("Error!");
            }
        });
    }
</script>

<html>