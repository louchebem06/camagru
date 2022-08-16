<?php
session_start();
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
	header("Location: /editProfil.php");
	exit();
}
$id = $_SESSION['id'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$state = (isset($_POST['notif']) && $_POST['notif'] == "on") ? 1 : 0;

$req = $conn->prepare("UPDATE user SET notif = '{$state}' WHERE user_id = '{$id}'");

$req->execute();

header("Location: /editProfil.php?ok=notif");
exit();
