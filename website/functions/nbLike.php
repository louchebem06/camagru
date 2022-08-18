<?php
function nbLike($img_id) {
	$user_id = $_SESSION['id'];

	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$sql = "SELECT COUNT(like_id) FROM `like` WHERE `img_id` = '$img_id' AND `user_id` = '$user_id'";
	$state = $conn->query($sql);
	$like = $state->fetch(PDO::FETCH_ASSOC);
	
	return ($like["COUNT(like_id)"]);
}
