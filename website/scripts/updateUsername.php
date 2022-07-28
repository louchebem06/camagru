<?php
session_start();
if (!isset($_SESSION['id']) || empty($_SESSION['id'])
	|| !isset($_POST['username']) || empty($_POST['username'])) {
	header("Location: /editProfil.php");
	exit();
}
$id = $_SESSION['id'];
$username = $_POST['username'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$req = $conn->prepare("UPDATE user SET username = '{$username}' WHERE user_id = '{$id}'");

try {
	$req->execute();
} catch (Exception $e) {
	header("Location: /editProfil.php?e=username");
	exit();
}
header("Location: /editProfil.php?ok=username");
exit();
