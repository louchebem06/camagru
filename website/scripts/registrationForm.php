<?php
$page = "/registration.php";

if ( !isset($_POST["email"]) || empty($_POST["email"])
	|| !isset($_POST["username"])  || empty($_POST["username"])
	|| !isset($_POST["password"]) || empty($_POST["password"])
	|| !isset($_POST["repassword"]) || empty($_POST["repassword"]) ) {
		header("Location: $page?empty");
		exit();
}

$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$repassword = $_POST["repassword"];

$value = "&email=$email&username=$username";

require($_SERVER['DOCUMENT_ROOT'] . "/functions/checkSecurePassword.php");
require($_SERVER['DOCUMENT_ROOT'] . "/functions/checkIsValidMail.php");

if ($password !== $repassword || !checkSecurePassword($password)) {
	header("Location: $page?passwordisnotvalid" . $value);
	exit();
}

if (!checkIsValidMail($email)) {
	header("Location: $page?emailisnotvalid" . $value);
	exit();
}

require($_SERVER['DOCUMENT_ROOT'] . "/functions/createUser.php");

$user = createUser($email, $username, $password);

if (gettype($user) == "object") {
	header("Location: $page?userexist" . $value);
	exit();
}

header("Location: $page?" . ($user ? "ok" : "error" . $value));
exit();
