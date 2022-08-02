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
	<title>Registration</title>
	<link href="/css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,200" />
</head>
<body>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/header.php") ?>
	
	<div class="website" id="website">

		<form id="form" class="box form register" method="POST" action="./scripts/registrationForm.php" >
			<div class="input">
				<span class="material-symbols-outlined">mail</span>	
				<input type="email" placeholder="Email" name="email" required/>
			</div>
			<div class="input">
				<span class="material-symbols-outlined">person</span>
				<input type="text" placeholder="Username" name="username" required/>
			</div>
			<div class="input">
				<span class="material-symbols-outlined">password</span>
				<input type="password" placeholder="Password" name="password" required/>
			</div>
			<div class="input">
				<span class="material-symbols-outlined">password</span>
				<input type="password" placeholder="Confirm password" name="repassword" required/>
			</div>
			<input class="submit" type="submit"value="Register"/>
		</form>
		<h3 class="or">OR</h3>
		<div class="box">
			<a class="login-btn" href="/login.php">Login</a>
		</div>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
	<script type="module">
		import { send } from "/js/register.js";

		const form = document.querySelector('#form');

		form.addEventListener('submit', e => {
			send(e, form);
		})
	</script>
</html>
