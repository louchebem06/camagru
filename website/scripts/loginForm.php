<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if ( !isset($_POST["username"])  || empty($_POST["username"])
	|| !isset($_POST["password"]) || empty($_POST["password"]) ) {
	$return = [
		"msg"=>"Incorect value send",
	];
	
	echo json_encode($return);
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
	$return = [
		"msg"=>"Username or password is incorect",
	];
	
	echo json_encode($return);
	exit();
}

$user = $result;
$activate = $user['activate'];
$username_bdd = $user['username'];
$user_id = $user['user_id'];
$password_bdd = $user['password'];

if ($username != $username_bdd || $password_bdd != hash('sha256', $password)) {
	$return = [
		"msg"=>"Username or password is incorect",
	];
	
	echo json_encode($return);
	exit();
}

if (!$activate) {
	$return = [
		"msg"=>"Your account is not activate",
	];
	
	echo json_encode($return);
	exit();
}

$_SESSION['id'] = $user_id;

$return = [
	"msg"=>"go home",
];

echo json_encode($return);
exit();
