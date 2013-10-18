<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'idevelop_song');
define('DB_PASSWORD', 'ng7epq');
define('DB_DATABASE', 'idevelop_song');
class DB_Class 
{
function __construct() 
{
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or 
die('Oops connection error -> ' . mysql_error());
mysql_select_db(DB_DATABASE, $connection) 
or die('Database error -> ' . mysql_error());
}
}
?>
