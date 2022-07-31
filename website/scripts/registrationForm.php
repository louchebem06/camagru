<?php
$page = "/registration.php";

if ( !isset($_POST["email"]) || empty($_POST["email"])
	|| !isset($_POST["username"])  || empty($_POST["username"])
	|| !isset($_POST["password"]) || empty($_POST["password"])
	|| !isset($_POST["repassword"]) || empty($_POST["repassword"]) ) {
		$return = [
			"msg"=>"Empty form is not valid",
		];
		
		echo json_encode($return);
		exit();
}

$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$repassword = $_POST["repassword"];

require($_SERVER['DOCUMENT_ROOT'] . "/functions/checkSecurePassword.php");
require($_SERVER['DOCUMENT_ROOT'] . "/functions/checkIsValidMail.php");

if ($password !== $repassword
	|| !checkSecurePassword($password)
	|| $password == $username
	|| $password == $email ) {
	$return = [
		"msg"=>"Your password is not valid : [password dont match username or email, minimum 1 uppercase lowercase, symbol, number and 7 char] or password and confirm password is not match",
	];
	
	echo json_encode($return);
	exit();
}

if (!checkIsValidMail($email)) {
	$return = [
		"msg"=>"Entry email is not valid",
	];
	
	echo json_encode($return);
	exit();
}

require($_SERVER['DOCUMENT_ROOT'] . "/functions/createUser.php");

$user = createUser($email, $username, $password);

if (gettype($user) == "object") {
	$return = [
		"code"=>'2',
		"msg"=>"Username or email already exists",
	];
	
	echo json_encode($return);
	exit();
}

if (!$user) {
	$return = [
		"msg"=>"An unknown error has occurred",
	];
	
	echo json_encode($return);
	exit();
}

$return = [
	"msg"=>"ok",
];
echo json_encode($return);
exit();
