<?php
session_start();

if (!isset($_POST['id_user']) || empty($_POST['id_user'])
	|| !isset($_POST['password']) || empty($_POST['password'])
	|| !isset($_POST['token']) || empty($_POST['token'])) {
	$return = [
		"code"=>0,
		"msg"=>"Data not valid",
	];
	echo json_encode($return);
	exit();
}

$id_user = $_POST['id_user'];
$password = $_POST['password'];
$token = $_POST['token'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/checkSecurePassword.php");

if (!checkSecurePassword($password)) {
	$return = [
		"code"=>1,
		"msg"=>"Password is not valid",
	];
	echo json_encode($return);
	exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$hash = hash('sha256', $password);

try {
$req = $conn->prepare("UPDATE user SET password = '{$hash}', reset_token = NULL
						WHERE user_id = '{$id_user}' AND reset_token = '{$token}'");

$req->execute();

$return = [
	"code"=>2,
	"msg"=>"ok",
];
echo json_encode($return);
exit();
} catch(Exception $e) {
	$return = [
		"code"=>3,
		"msg"=>"Troll",
	];
	echo json_encode($return);
	exit();
}
