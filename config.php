<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id8499309_jesus');
define('DB_PASSWORD', '12qwaszx');
define('DB_NAME', 'id8499309_ticketdatabase');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>