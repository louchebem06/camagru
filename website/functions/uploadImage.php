<?php
function uploadImage() : string|bool {
	if (!isset($_SESSION['id'])
		|| empty($_SESSION['id'])
		|| !isset($_FILES['file']))
		return (false);
	
	$dir = $_SERVER['DOCUMENT_ROOT'] . "/upload";
	$tmpName = $_FILES['file']['tmp_name'];
	$size = $_FILES['file']['size'];
	$type = $_FILES['file']['type'];
	$type = "." . explode("/", $type)[1];
	$mime = mime_content_type($tmpName);
	$name = bin2hex(openssl_random_pseudo_bytes(16));
	$filename = "{$dir}/{$name}.{$type}";
	if ($size > 2040000 || strncmp($mime, "image", 5) != 0)
		return (false);

	if (!file_exists($dir))
		mkdir($dir);
	move_uploaded_file($tmpName, $filename);

	include($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php"); 

	try {
		$sql = "INSERT INTO `user`(`user_id`, `file`)
		VALUES (:user_id, :file)";
		$res = $conn->prepare($sql);
		$exec = $res->execute(
					array(
						":user_id"=>$_SESSION['id'],
						":file"=>$filename
					)
		);
		if ($exec)
			return $conn->lastInsertId();
		return (false);

	}
	catch (Exception $e) {
		return (false);
	}
}
