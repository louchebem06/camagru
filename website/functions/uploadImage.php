<?php
function uploadImage() {
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
	$filenameReal = "{$dir}/{$name}.{$type}";
	$filenameWeb = "/upload/{$name}.{$type}";

	if ($size > 2040000 || strncmp($mime, "image", 5) != 0)
		return (false);

	if (!file_exists($dir))
		mkdir($dir);
	move_uploaded_file($tmpName, $filenameReal);

	include($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	try {
		$data = [
			'user_id' => $_SESSION['id'],
			'file' => $filenameWeb
		];
		$sql = "INSERT INTO img (`user_id`, `file`) VALUES (:user_id, :file)";
		$stmt = $conn->prepare($sql);
		$exec = $stmt->execute($data);
		if ($exec)
			return ($conn->lastInsertId());
		return (false);
	}
	catch (Exception $e) {
		return (false);
	}
}
