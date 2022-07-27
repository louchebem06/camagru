<?php
	session_start();

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		if (validUser($_SESSION['id'])) {
			header("Location: /");
			exit();
		}
	}

	if (isset($_GET['empty']))
		$error = "Incorect value send";
	else if (isset($_GET['notFound']))
		$error = "Account not found";
	else if (isset($_GET['activate']))
		$error = "Your account and already activated";
	else if (isset($_GET['error']))
		$error = "An error these product";
	else if (isset($_GET['ok']))
		$ok = "Your account has been activated, you can log in";
	else if (isset($_GET['notActivate']))
		$error = "Your account is not activate";
	else if (isset($_GET['notValid']))
		$error = "Username or password is incorect";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="/css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,200" />
</head>
<body>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/header.php") ?>
	
	<div class="website">

		<?php if (isset($error) && !empty($error)) { ?>
				<div class="box">
					<p><b>Error: </b><?php echo $error ?></p>
				</div>
		<?php } else if (isset($ok) && !empty($ok)){ ?>
				<div class="box">
					<p><b>Success: </b><?php echo $ok ?></p>
				</div>
		<?php } ?>

		<form class="box form register" method="POST" action="./scripts/loginForm.php" >
			<div class="input">
				<span class="material-symbols-outlined">person</span>
				<input type="text" placeholder="Username" name="username" required/>
			</div>
			<div class="input">
				<span class="material-symbols-outlined">password</span>
				<input type="password" placeholder="Password" name="password" required/>
			</div>
			<input class="submit" type="submit" value="Login"/>
		</form>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
</html>
