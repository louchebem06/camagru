<?php
if (!isset($_POST['email']) || empty($_POST['email'])) {
	$return = [
		"msg"=>"Data not valid",
	];
	echo json_encode($return);
	exit();
}

$random = openssl_random_pseudo_bytes(16);
$token = bin2hex($random);
$mail = $_POST['email'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
$req = $conn->prepare("UPDATE user SET reset_token = '{$token}' WHERE email = '{$mail}'");

try {
	$req->execute();
} catch (Exception $e) {
	$return = [
		"msg"=>"User not found",
	];
	echo json_encode($return);
	exit();
}

$headers = 'Content-Type: text/html; charset="UTF-8"'."n";
$subject = 'Reset password';
$message = "Link for reset password <a href=\"http://{$_SERVER['HTTP_HOST']}/resetPassword.php?t={$token}\" target=\"_blank\">HERE</a>";
mail($mail, $subject, $message, $headers);

$return = [
	"msg"=>"Email for reset send",
];
echo json_encode($return);
exit();
