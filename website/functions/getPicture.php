<?php
function getPicture(int $id = NULL) : string {
	if ($id == NULL)
		$id = $_SESSION['id'];

	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$sql = "SELECT img_id FROM user WHERE user_id='{$id}'";
	$state = $conn->query($sql);
	$result = $state->fetch(PDO::FETCH_ASSOC);
	if ($result == false)
		return ("/img/defaultUser.jpeg");
	$img_id = $result['img_id'];
	$sql = "SELECT file FROM img WHERE img_id='{$img_id}'";
	$state = $conn->query($sql);
	$result = $state->fetch(PDO::FETCH_ASSOC);
	if ($result == false)
		return ("/img/defaultUser.jpeg");
	return ($result['file']);
}
