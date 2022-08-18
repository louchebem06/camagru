<?php
function isLike($img_id): bool {
	$user_id = $_SESSION['id'];

	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$sql = "SELECT * FROM `like` WHERE `img_id` = '$img_id' AND `user_id` = '$user_id'";
	$state = $conn->query($sql);
	$like = $state->fetch(PDO::FETCH_ASSOC);

	if ($like == false)
		return (true);
	return (false);
}
