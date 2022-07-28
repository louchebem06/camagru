<?php
session_start();
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
	header("Location: /editProfil.php");
	exit();
}
$id = $_SESSION['id'];

require($_SERVER['DOCUMENT_ROOT'] . "/functions/uploadImage.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$id_img = uploadImage();

if ($id_img == false) {
	header("Location: /editProfil.php?e=errorUpload");
	exit();
}

$req = $conn->prepare("UPDATE user SET img_id = '{$id_img}' WHERE user_id = '{$id}'");

try {
	$req->execute();
} catch (Exception $e) {
	header("Location: /editProfil.php?e=img");
	exit();
}
header("Location: /editProfil.php?ok=img");
exit();
