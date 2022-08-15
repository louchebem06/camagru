<?php
	session_start();

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		if (!validUser($_SESSION['id'])) {
			header("Location: /scripts/disconnect.php");
			exit();
		}
	}

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/getUsername.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/functions/getPicture.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$sql = "SELECT * FROM `img` ORDER BY `img_id` DESC";
	$state = $conn->query($sql);
	$imgTab = $state->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Camagru</title>
	<link href="/css/style.css" rel="stylesheet" type="text/css">
	<link href="/css/publication.css" rel="stylesheet" type="text/css">
</head>
<body>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/header.php") ?>
	
	<div class="website">

		<?php
			foreach ($imgTab as $key => $value) {
				$user_id = $value['user_id'];
				$img_id = $value['img_id'];
				$file = $value['file'];
		?>
			<div class="box publication">
				<a href="/profil.php?id=<?php echo $user_id ?>" >
					<div class="user_info_publication">
						<img src="<?php echo getPicture($user_id) ?>"/>
						<p><?php echo getUsername($user_id) ?></p>
					</div>
				</a>
				<img src="<?php echo $file ?>"/>
				<?php
					if (isset($_SESSION['id'])) { ?>
					<form>
						<div class="comment_publication">
							<img src="/img/comment.svg" />
							<input type="text" placeholder="Enter your comment" />
						</div>
						<div class="submit_publication">
							<input type="submit" />
							<a href="#">Look comment</a>
						</div>
					</form>
				<?php } else { ?>
					<div class="submit_publication">
							<a href="#">Look comment</a>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
</html>
