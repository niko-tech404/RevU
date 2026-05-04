<?php
session_start();
include 'connect_db.php';
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}
$id_u = $_SESSION['id_utente'];
// fa questo per eliminare l utente dal db
$conn->query("DELETE FROM utenti WHERE id = $id_u");
session_destroy();
header("Location: signup.php");
?>
