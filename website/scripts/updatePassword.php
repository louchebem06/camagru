<?php
session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])
	|| !isset($_POST['password']) || empty($_POST['password'])
	|| !isset($_POST['repassword']) || empty($_POST['repassword'])) {
	header("Location: /editProfil.php");
	exit();
}
$id = $_SESSION['id'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/checkSecurePassword.php");

if (!checkSecurePassword($password) || $password != $repassword) {
	header("Location: /editProfil.php?e=password");
	exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$hash = hash('sha256', $password);

$req = $conn->prepare("UPDATE user SET password = '{$hash}' WHERE user_id = '{$id}'");

$req->execute();

header("Location: /editProfil.php?ok=password");
exit();
