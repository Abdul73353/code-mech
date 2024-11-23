<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_breakcon = "localhost";
$database_breakcon = "breakdown";
$username_breakcon = "root";
$password_breakcon = "";
$breakcon = mysql_pconnect($hostname_breakcon, $username_breakcon, $password_breakcon) or trigger_error(mysql_error(),E_USER_ERROR); 
?>