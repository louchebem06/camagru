<?php
function validUser(int $user_id) : bool {
	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$sql = "SELECT * FROM user WHERE user_id='{$user_id}'";
	$state = $conn->query($sql);
	$result = $state->fetch(PDO::FETCH_ASSOC);

	if ($result == false)
		return (false);
	return (true);
}
