<?php
function getNotification(int $id = NULL) : bool {
	if ($id == NULL)
		$id = $_SESSION['id'];

	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$sql = "SELECT notif FROM user WHERE user_id='{$id}'";
	$state = $conn->query($sql);
	$result = $state->fetch(PDO::FETCH_ASSOC);
	if ($result == false)
		return ("error");
	return ($result['notif']);
}
