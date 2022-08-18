<?php
session_start();

if (!isset($_POST['id_img']) || empty($_POST['id_img'])
	|| !isset($_SESSION['id']) || empty($_SESSION['id']) ) {
		$return = [
			"code"=> -1,
			"msg"=>"Data not valid",
		];
		echo json_encode($return);
		exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
require($_SERVER['DOCUMENT_ROOT'] . "/functions/nbLike.php");

$img_id = $_POST['id_img'];
$user_id = $_SESSION['id'];

$sql = "SELECT * FROM `like` WHERE `img_id` = '$img_id' AND `user_id` = '$user_id'";
$state = $conn->query($sql);
$like = $state->fetch(PDO::FETCH_ASSOC);

if ($like != false) {
	$id_like = $like['like_id'];
	$sql = "DELETE FROM `like` WHERE like_id=${id_like}";
	$conn->exec($sql);
	$return = [
		"code"=> 2,
		"counter"=> nbLike($img_id),
		"msg"=>"Like",
	];
	echo json_encode($return);
	exit();
}

try {
	$data = [
		'img_id' => $img_id,
		'user_id' => $user_id,
	];
	$sql = "INSERT INTO `like` (`img_id`, `user_id`) VALUES (:img_id, :user_id)";
	$stmt = $conn->prepare($sql);
	$exec = $stmt->execute($data);
	
	$return = [
		"code"=> 1,
		"counter"=> nbLike($img_id),
		"msg"=>"Dislike",
	];
	echo json_encode($return);
	exit();
} catch (Exception $e) {
	echo json_encode([
		"msg"=>$e
	]);
	exit();
}
