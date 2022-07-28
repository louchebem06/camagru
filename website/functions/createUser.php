<?php
function createUser(string $email, string $username, string $password) {
	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");

	$random = openssl_random_pseudo_bytes(16);
	$token = bin2hex($random);
	$hash = hash('sha256', $password);

	try {
		$sql = "INSERT INTO `user`(`email`, `username`, `password`, `token`)
				VALUES (:email, :username, :password, :token)";
		$res = $conn->prepare($sql);
		$exec = $res->execute(
					array(
						":email"=>$email,
						":username"=>$username,
						":password"=>$hash,
						":token"=>$token
					)
		);
	}
	catch (Exception $e) {
		return $e;
	}
	if ($exec) {
		$headers = 'Content-Type: text/html; charset="UTF-8"'."n";
		$subject = 'Confirm your account camagru';
		$message = "Hi {$username}, please valid your account <a href=\"http://{$_SERVER['HTTP_HOST']}/activate.php?t={$token}\" target=\"_blank\">Activate</a>";
		mail($email, $subject, $message, $headers);
		return (true);
	}
	return (false);
}
