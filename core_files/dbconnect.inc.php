<?php

$database_name = 'attendance';
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';
$mysql_error = 'The connection to the database was unsucessful';

$mysql_connect = mysql_connect($mysql_host, $mysql_user, $mysql_pass);




if (!(@$mysql_connect && @mysql_select_db($database_name))) {
    die($mysql_error);
}
//else{
//    echo 'am in j';
//}
