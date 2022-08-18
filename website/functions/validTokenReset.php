<?php
function validTokenReset(string $token) {
	require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$sql = "SELECT * FROM user WHERE reset_token='{$token}'";
	$state = $conn->query($sql);
	$result = $state->fetch(PDO::FETCH_ASSOC);
	if ($result == false)
		return false;
	return ($result['user_id']);
}
