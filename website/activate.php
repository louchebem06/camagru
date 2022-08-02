<?php
	session_start();

	function errorMsg() : string {
		if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
			return "Your account and already activated";
		}
		
		if (!isset($_GET['t']) || empty($_GET['t'])) {
			return "No token detect";
		}
		
		require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
		$token = $_GET['t'];
		
		$sql = "SELECT * FROM user WHERE token='{$token}'";
		$state = $conn->query($sql);
		$result = $state->fetch(PDO::FETCH_ASSOC);
		
		if (!$result) {
			return "Account not found";
		}
		
		$user = $result;
		$activate = $user['activate'];
		$user_id = $user['user_id'];
		
		if ($activate) {
			return "Your account and already activated";
		}
		
		$sql = "UPDATE user SET activate='1' WHERE user_id='{$user_id}'";
		$result = $conn->exec($sql);
		
		if ($result != 1) {
			return "An error these product";
		}
		
		return "Your account has been activated, you can log in";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Activate</title>
	<link href="/css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,200" />
</head>
<body>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/header.php") ?>
	
	<div id="website" class="website">

		<div class="box">
			<p> <?php echo errorMsg(); ?> </p>
		</div>

		<?php if (!(isset($_SESSION['id']) && !empty($_SESSION['id']))) { ?>
		<div class="box">
			<a class="login-btn" href="/login.php">Login</a>
		</div>
		<?php } ?>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
</html>
