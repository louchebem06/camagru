<?php
session_start();

if (!isset($_POST['id_img']) || empty($_POST['id_img'])
	|| !isset($_POST['comment']) || empty($_POST['comment'])
	|| !isset($_SESSION['id']) || empty($_SESSION['id']) ) {
		$return = [
			"msg"=>"Data not valid",
		];
		echo json_encode($return);
		exit();
}

$img_id = $_POST['id_img'];
$comment = $_POST['comment'];
$user_id = $_SESSION['id'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

try {
	$data = [
		'img_id' => $img_id,
		'user_id' => $user_id,
		'comment' => $comment
	];
	$sql = "INSERT INTO comment (`img_id`, `user_id`, `comment`) VALUES (:img_id, :user_id, :comment)";
	$stmt = $conn->prepare($sql);
	$exec = $stmt->execute($data);
	
	$return = [
		"msg"=>"Comment add with success",
	];
	echo json_encode($return);
	exit();
} catch (Exception $e) {
	echo json_encode([
		"msg"=>$e
	]);
	exit();
}
