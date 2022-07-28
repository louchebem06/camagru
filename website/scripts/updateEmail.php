<?php
session_start();
if (!isset($_SESSION['id']) || empty($_SESSION['id'])
	|| !isset($_POST['email']) || empty($_POST['email'])) {
	header("Location: /editProfil.php");
	exit();
}
$id = $_SESSION['id'];
$email = $_POST['email'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/checkIsValidMail.php");

if (!checkIsValidMail($email)) {
	header("Location: /editProfil.php?notValid=email");
	exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$req = $conn->prepare("UPDATE user SET email = '{$email}' WHERE user_id = '{$id}'");

try {
	$req->execute();
} catch (Exception $e) {
	header("Location: /editProfil.php?e=email");
	exit();
}
header("Location: /editProfil.php?ok=email");
exit();
