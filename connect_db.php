<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "steam";

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("connessione fallita: " . $conn->connect_error);
}
?>