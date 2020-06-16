<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_teste = "localhost";
$database_teste = "kb";
$username_teste = "root";
$password_teste = "";
$teste = mysql_pconnect($hostname_teste, $username_teste, $password_teste) or trigger_error(mysql_error(),E_USER_ERROR); 
?>