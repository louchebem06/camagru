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
		$headers = 'From: camagru@42nice.fr' . "\r\n" .
		'Reply-To: camagru@42nice.fr' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		$subject = "Confirm your account camagru";
		$message = "Hi {$username}, please valid your account http://{$_SERVER['HTTP_HOST']}/activate.php?t={$token}";
		mail($email, $subject, $message, $headers);
		return (true);
	}
	return (false);
}
