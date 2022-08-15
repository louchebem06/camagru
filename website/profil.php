<?php
	session_start();

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		$id = $_SESSION['id'];
		if (!validUser($_SESSION['id'])) {
			header("Location: /scripts/disconnect.php");
			exit();
		}
	}

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/getUsername.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/functions/getPicture.php");


	if (isset($_GET['id']) && !empty($_GET['id']) && validUser($_GET['id']))
		$id = $_GET['id'];
	else if (isset($_GET['id']) && $id != $_GET['id'])
		$profilNotFound = true;

	$username = getUsername($id);
	$profilPicture = getPicture($id);

	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

	$img_limit = 6;
	$page = 0;
	if (isset($_GET['page']) && !empty($_GET['page']))
		$page = $_GET['page'] - 1;
	
	$offset = $img_limit * $page;

	$sql = "SELECT * FROM `img` WHERE `user_id` = '${id}' ORDER BY `img_id` DESC LIMIT ${img_limit} OFFSET ${offset}";
	$state = $conn->query($sql);
	$imgTab = $state->fetchAll(PDO::FETCH_ASSOC);

	$sql = "SELECT COUNT(img_id) FROM `img` WHERE `user_id` = '${id}'";
	$state = $conn->query($sql);
	$nb_img = $state->fetch(PDO::FETCH_ASSOC);
	$nb_img = $nb_img["COUNT(img_id)"];
	$max_page = ceil($nb_img / $img_limit);
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
	<link href="/css/photo.css" rel="stylesheet" type="text/css">
</head>
<body>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/header.php") ?>
	
	<div class="website">

		<?php if (isset($profilNotFound) && $profilNotFound) { ?>

		<div class="box">
			<p>Profil not found</p>
		</div>

		<?php } else { ?>

		<div class="box profil">
			<img alt="picture-profil" src="<?php echo $profilPicture ?>"/>
			<p><?php echo $username ?></p>
			<?php if (isset($_SESSION['id']) && $id == $_SESSION['id']) { ?>
				<a href="editProfil.php"><b>Edition</b></a>
			<?php } ?>
		</div>

		<div class="box">
			<div class="photoBox">
			<?php
				foreach ($imgTab as $key => $imgInfo) {
					$img_id = $imgInfo['img_id'];
					$user_id = $imgInfo['user_id'];
					$img_file = $imgInfo['file'];
					?>
						<div class="imgContent">
							<img src="<?php echo $img_file ?>" alt="picture"/>
						</div>
					<?php
				}
			?>
			</div>
		</div>

		<div class="box pagination">
			<?php
				$range_page = 4;
				$start = ($page - $range_page < 0) ? 0 : $page - $range_page;
				$limit = ($page + $range_page < $max_page) ? $page +  $range_page : $max_page;
				if ($start != 0) {
					?> <p>...</p> <?php
				}
				for ($i = $start; $i < $limit; $i++)
				{
					$params = $_GET;
					$params['page'] = $i + 1;
					$paramString = http_build_query($params);
					?>
						<a href="<?php echo '/profil.php?' . $paramString ?> ">
						<?php
							if ($i == $page) {
								?> <b><?php echo $i + 1 ?></b> <?php
							} else {
								?> <p><?php echo $i + 1 ?></p> <?php
							}
						?>
						</a>
					<?php
				}
				if ($limit < $max_page) {
					?> <p>...</p> <?php
				}
			?>
		</div>
		
		<?php if (isset($_SESSION['id']) && $id == $_SESSION['id']) { ?>
			<div class="box">
				<a class="disconnect-btn" href="/scripts/disconnect.php">Disconnect</a>
			</div>
		<?php } ?>

		<?php } ?>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
</html>
