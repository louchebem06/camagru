<?php
if (!isset($_POST['id_img']) || empty($_POST['id_img'])) {
	$return = [
		"msg"=>"Not data valid",
	];
	echo json_encode($return);
	exit();
}

$id_img = $_POST['id_img'];
require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/getComment.php");

$data = getComment($id_img);
echo json_encode($data);
exit();
