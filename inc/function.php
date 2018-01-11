<?php
function checklogin($ses_user){
	if(empty($ses_user)){
		// exit("<script>alert('Please Login');window.location='login.php';</script>");
		exit("<script>window.location='login.php';</script>");
	}
}

function check_user_login($ses_name='user'){
    if(empty($_SESSION[$ses_name])){
        exit("<script>window.location='login.php';</script>");
    }
}
?>