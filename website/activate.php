<?php
if (!isset($_GET['t']) || empty($_GET['t'])) {
	echo "Token not found or empty";
	exit();
}

require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
$token = $_GET['t'];

$sql = "SELECT * FROM user WHERE token='{$token}'";
$state = $conn->query($sql);
$result = $state->fetch(PDO::FETCH_ASSOC);
if (count($result) < 1) {
	echo "Account not found";
	exit();
}

$user = $result;
$activate = $user['activate'];
$user_id = $user['user_id'];

if ($activate) {
	echo "Your account and already activated";
	exit();
}

$sql = "UPDATE user SET activate='1' WHERE user_id='{$user_id}'";
$result = $conn->exec($sql);

if ($result != 1) {
	echo "An error these product";
	exit();
}

echo "Your account has been activated, you can log in";
?>