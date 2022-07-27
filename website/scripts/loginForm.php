<?php
session_start();

$page = "/login.php";

if ( !isset($_POST["username"])  || empty($_POST["username"])
	|| !isset($_POST["password"]) || empty($_POST["password"]) ) {
	header("Location: $page?empty");
	exit();
}

require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
require($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM user WHERE username='{$username}'";
$state = $conn->query($sql);
$result = $state->fetch(PDO::FETCH_ASSOC);
if ($result == false) {
	header("Location: $page?notValid");
	exit();
}

$user = $result;
$activate = $user['activate'];
$username_bdd = $user['username'];
$user_id = $user['user_id'];
$password_bdd = $user['password'];

if ($username != $username_bdd || $password_bdd != hash('sha256', $password)) {
	header("Location: $page?notValid");
	exit();
}

if (!$activate) {
	header("Location: $page?notActivate");
	exit();
}

$_SESSION['id'] = $user_id;

header("Location: /");
exit();
