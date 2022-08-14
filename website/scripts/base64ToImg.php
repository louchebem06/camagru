<?php
session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id']) || !isset($_POST['data'])) {
	$return = [
		"msg"=>"User not connected or data invalid",
	];
	echo json_encode($return);
	exit();
}

$data = $_POST['data'];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

$name = bin2hex(openssl_random_pseudo_bytes(16));

$dir = $_SERVER['DOCUMENT_ROOT'] . "/upload";
if (!file_exists($dir))
	mkdir($dir);

file_put_contents($dir . '/' . $name . ".png", $data);

require_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$filenameWeb = "/upload/{$name}.png";

try {
	$data = [
		'user_id' => $_SESSION['id'],
		'file' => $filenameWeb
	];
	$sql = "INSERT INTO img (`user_id`, `file`) VALUES (:user_id, :file)";
	$stmt = $conn->prepare($sql);
	$exec = $stmt->execute($data);
	if ($exec)
		$id_picture = $conn->lastInsertId();
	$return = [
		"msg"=>"ok",
		"id_picture"=>$id_picture
	];
		
	echo json_encode($return);
	exit();
} catch (Exception $e) {
	echo json_encode([
		"msg"=>"Error upload in BDD"
	]);
	exit();
}
