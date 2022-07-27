<?php
function getUsername() : string {
	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$sql = "SELECT username FROM user WHERE user_id='{$_SESSION['id']}'";
	$state = $conn->query($sql);
	$result = $state->fetch(PDO::FETCH_ASSOC);
	if ($result == false)
		return ("error");
	return ($result['username']);
}
