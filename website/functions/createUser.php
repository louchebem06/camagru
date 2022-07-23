<?php
function createUser(string $email, string $username, string $password) : bool {
	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");
	
	$random = openssl_random_pseudo_bytes(16);;
	$token = bin2hex($random);;
	$hash = hash('sha256', $password);

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

	if ($exec)
		return (true);
	return (false);
}
