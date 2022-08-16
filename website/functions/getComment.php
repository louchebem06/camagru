<?php
function getComment($img_id) {
	require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/getUsername.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/getPicture.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$sql = "SELECT * FROM `comment` WHERE `img_id` = '$img_id' ORDER BY `comment_id` ASC";
	$state = $conn->query($sql);
	$commentTab = $state->fetchAll(PDO::FETCH_ASSOC);

	$return = array();

	foreach ($commentTab as $key => $value) {
		$id_user = $value['user_id'];
		$comment = $value['comment'];
		$data = [
			'username' => getUsername($id_user),
			'picture' => getPicture($id_user),
			'comment' => $comment
		];

		array_push($return, $data);
	}
	
	return ($return);
}
