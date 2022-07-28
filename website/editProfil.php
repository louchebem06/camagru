<?php
	session_start();

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		if (!validUser($_SESSION['id'])) {
			header("Location: /scripts/disconnect.php");
			exit();
		}
	} else {
		header("Location: /login.php");
		exit();
	}

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/getUsername.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/functions/getMail.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/functions/getPicture.php");

	$username = getUsername();
	$mail = getMail();
	$profilPicture = getPicture();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profil</title>
	<link href="/css/style.css" rel="stylesheet" type="text/css">
	<link href="/css/profil.css" rel="stylesheet" type="text/css">
</head>
<body>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/header.php") ?>
	
	<div class="website">

		<div class="box formEditProfil">
			<p>
				<?php
					if (isset($_GET['e']) && $_GET['e'] == "email")
						echo "Email choise exist!";
					else if (isset($_GET['ok']) && $_GET['ok'] == "email")
						echo "Email changed";
					else if (isset($_GET['notValid']) && $_GET['notValid'] == "email")
						echo "Email not valid";
				?>
			</p>
			<h2>Mail</h2>
			<form method="POST" action="/scripts/updateEmail.php">
				<input type="email" placeholder="Email" value="<?php echo $mail ?>" name="email" required/>
				<input class="submit" type="submit" value="Save"/>
			</form>
		</div>
		<div class="box formEditProfil">
			<p>
				<?php
					if (isset($_GET['e']) && $_GET['e'] == "username")
						echo "Username choise exist!";
					else if (isset($_GET['ok']) && $_GET['ok'] == "username")
						echo "Username changed";
				?>
			</p>
			<h2>Username</h2>
			<form method="POST" action="/scripts/updateUsername.php">
				<input type="text" placeholder="Username" value="<?php echo $username ?>" name="username" required/>
				<input class="submit" type="submit" value="Save"/>
			</form>
		</div>
		<div class="box formEditProfil">
			<h2>Password</h2>
			<form method="POST" action="#">
				<input type="password" placeholder="password" name="password" required/>
				<input type="password" placeholder="confirm password" name="repassword" required/>
				<input class="submit" type="submit" value="Save"/>
			</form>
		</div>
		<div class="box formEditProfil">
			<h2>Image</h2>
			<form method="POST" action="#" enctype="multipart/form-data">
				<input type="file" name="picture" accept="image/*" />
				<input class="submit" type="submit" value="Save"/>
			</form>
			<a href="#">Remove actual picture</a>
		</div>

		<div class="box">
			<a href="/profil.php">Return to profil</a>
		</div>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
</html>
