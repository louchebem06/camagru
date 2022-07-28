<?php
session_start();

$page = "/login.php";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
	header("Location: $page?activate" . $value);
	exit();
}

if (!isset($_GET['t']) || empty($_GET['t'])) {
	header("Location: $page?empty" . $value);
	exit();
}

require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
$token = $_GET['t'];

$sql = "SELECT * FROM user WHERE token='{$token}'";
$state = $conn->query($sql);
$result = $state->fetch(PDO::FETCH_ASSOC);
if (count($result) < 1) {
	header("Location: $page?notFound" . $value);
	exit();
}

$user = $result;
$activate = $user['activate'];
$user_id = $user['user_id'];

if ($activate) {
	header("Location: $page?activate" . $value);
	exit();
}

$sql = "UPDATE user SET activate='1' WHERE user_id='{$user_id}'";
$result = $conn->exec($sql);

if ($result != 1) {
	header("Location: $page?error" . $value);
	exit();
}

header("Location: $page?ok" . $value);
exit();
