<?php
session_start();

require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
	if (validUser($_SESSION['id'])) {
		header("Location: /");
		exit();
	}
}

function printValueGet(string $name) :void {
	if (isset($_GET[$name]) && !empty($_GET[$name]))
		echo "value=\"" . $_GET[$name] . '"';
}

function emailValue() : void {
	printValueGet("email");
}

function usernameValue() : void {
	printValueGet("username");
}

if (isset($_GET['passwordisnotvalid']))
	$error = "Your password is not valid : [minimum 1 uppercase lowercase, symbol, number and 7 char]<br>or password and confirm password is not match";
else if (isset($_GET['empty']))
	$error = "Empty form is not valid";
else if (isset($_GET['emailisnotvalid']))
	$error = "Entry email is not valid";
else if (isset($_GET['userexist']))
	$error = "Username or email already exists";
else if (isset($_GET['error']))
	$error = "An unknown error has occurred";
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
	
	<div class="website">

		<?php if (isset($error) && !empty($error)) { ?>
				<div class="box">
					<p><b>Error: </b><?php echo $error ?></p>
				</div>
		<?php } ?>

		<?php if (!isset($_GET['ok'])) { ?>
			<form class="box form register" method="POST" action="./scripts/registrationForm.php" >
				<div class="input">
					<span class="material-symbols-outlined">mail</span>	
					<input type="email" placeholder="Email" name="email" <?php emailValue() ?> required/>
				</div>
				<div class="input">
					<span class="material-symbols-outlined">person</span>
					<input type="text" placeholder="Username" name="username" <?php usernameValue() ?> required/>
				</div>
				<div class="input">
					<span class="material-symbols-outlined">password</span>
					<input type="password" placeholder="Password" name="password" required/>
				</div>
				<div class="input">
					<span class="material-symbols-outlined">password</span>
					<input type="password" placeholder="Confirm password" name="repassword" required/>
				</div>
				<input class="submit" type="submit" value="Register"/>
			</form>
			<h3 class="or">OR</h3>
			<div class="box">
				<a class="login-btn" href="/login.php">Login</a>
			</div>
		<?php } else { ?>
			<div class="box error">
				<p><b>Succes: </b>Your account has been created, please confirm your email address</p>
			</div>
		<?php } ?>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
</html>
