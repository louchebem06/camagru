<?php
	session_start();

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		if (validUser($_SESSION['id'])) {
			header("Location: /");
			exit();
		}
	}
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
	
	<div id="website" class="website">

		<form id="form" class="box form register" method="POST" action="./scripts/loginForm.php">
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

		<div class="box" >
			<a href="/resetPassword.php">Forget password ?</a>
		</div>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>

	<script type="module">
		import { send } from "/js/login.js";

		const form = document.querySelector('#form');

		form.addEventListener('submit', e => {
			send(e, form);
		})
	</script>

</html>
