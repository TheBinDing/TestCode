<?php
    // $host = "192.168.2.177"; // Run on Lan
    $host = "192.168.1.30"; // Run on Lan
    // $host = "192.168.100.174"; // Run on WIFI
    // $host = "192.168.100.177"; // Run on WIFI
    $user = "sa";
    $password = "tent";
    $dbname = "HRP";
    $objConncet = mssql_connect($host,$user,$password) or die("Can't connect DB");
    $objDB = mssql_select_db($dbname) or die("Can't select DB");
    $objDB = mysql_query("SET NAMES 'UTF-8'");
?>