<?php
$servername = "localhost";
$username = "id8499309_jesus";
$password = "12qwaszx";
$database = "id8499309_ticketdatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    console.log("Connected successfully");
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>