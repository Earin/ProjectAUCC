<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_signup = "localhost";
$database_signup = "ucc_alumni";
$username_signup = "root";
$password_signup = "";
$signup = mysql_pconnect($hostname_signup, $username_signup, $password_signup) or trigger_error(mysql_error(),E_USER_ERROR); 
?>