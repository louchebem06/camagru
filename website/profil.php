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
	require($_SERVER['DOCUMENT_ROOT'] . "/functions/getPicture.php");

	$username = getUsername();
	$profilPicture = getPicture();
	$publication = 0;
	$subscribe = 0;
	$subscription = 0;

	function nbPublication() : void {
		global $publication;

		echo "{$publication} publication" . ($publication > 1 ? "s" : "" ) ;
	}

	function nbSubscribe() : void {
		global $subscribe;

		echo "{$subscribe} subscribe" . ($subscribe > 1 ? "s" : "" ) ;
	}

	function nbSubscription() : void {
		global $subscription;

		echo "{$subscription} subscription" . ($subscription > 1 ? "s" : "" ) ;
	}
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

		<div class="box profil">
			<img alt="picture-profil" src="<?php echo $profilPicture ?>"/>
			<div class="info-profil">
				<div class="first">
					<p><?php echo $username ?></p>
					<a href="#"><b>Edition</b></a>
				</div>
				<div class="second">
					<p><?php nbPublication()?></p>
					<p><?php nbSubscribe()?></p>
					<p><?php nbSubscription()?></p>
				</div>
			</div>
		</div>

		<div class="box">
			<a class="disconnect-btn" href="/scripts/disconnect.php">Disconnect</a>
		</div>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
</html>
