<?php
session_start();

if (!isset($_POST['id_img']) || empty($_POST['id_img'])
	|| !isset($_SESSION['id']) || empty($_SESSION['id']) ) {
		$return = [
			"msg"=>"Data not valid",
		];
		echo json_encode($return);
		exit();
}

require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
require($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");

$id_img = $_POST['id_img'];
$id_user = $_SESSION['id'];

$sql = "SELECT * FROM `img` WHERE `img_id` = '${id_img}'";
$state = $conn->query($sql);
$imgData = $state->fetch(PDO::FETCH_ASSOC);

if (!$imgData || $imgData['user_id'] != $id_user) {
	$return = [
		"msg"=>"Not authorizer",
	];
	echo json_encode($return);
	exit();
}

$file = $imgData['file'];

$sql = "DELETE FROM `img` WHERE `img_id` = '${id_img}'";
$conn->exec($sql);

unlink($_SERVER['DOCUMENT_ROOT'] . $file);

$return = [
	"msg"=>"ok",
];
echo json_encode($return);
exit();
