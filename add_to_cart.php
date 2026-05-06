<?php
session_start();
if (!isset($_SESSION['carrello'])) $_SESSION['carrello'] = [];
$id = (int)($_GET['id'] ?? 0);

if ($id > 0 && !in_array($id, $_SESSION['carrello'])) {
    $_SESSION['carrello'][] = $id;
}

header("Location: cart.php");
exit();