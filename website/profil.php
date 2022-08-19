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
	require($_SERVER['DOCUMENT_ROOT'] . "/functions/isLike.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/functions/nbLike.php");


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
							<input type="hidden" value="<?php echo $img_id ?>" />
							<img src="<?php echo $img_file ?>" alt="picture"/>
							<div class="like_comment">
								<?php
									if (isset($_SESSION['id']) && $_SESSION['id'] == $user_id) { ?>
										<img src="/img/delete.svg" />
								<?php } if (isset($_SESSION['id'])) { ?>
								<img src="/img/comment.svg" />
								<?php } ?>
								<div class="likeBox">
									<img src="
									<?php
										if (isset($_SESSION['id']))
											echo ((isLike($img_id)) ? "/img/like0.svg" : "/img/like1.svg");
										else
											echo "/img/like0.svg";
									?>" />
									<p><?php echo nbLike($img_id) ?></p>
								</div>
							</div>
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

	<script>
		let imgs = document.getElementsByClassName("imgContent");

		for (let img of imgs) {
			img.addEventListener("mouseover", e => {
				let div = img.querySelector('div');
				div.style.visibility = "visible";
				let likeBox = div.querySelector('div');
				let btns = div.querySelectorAll('img');
				let imgLike = likeBox.querySelector('img');
				let counterLike = likeBox.querySelector('p');
				let id_img = img.querySelector('input').value;

				for (let btn of btns) {
					let listName = btn.src.split('/');
					let name = listName[listName.length - 1];

					if (name == "comment.svg") {
						btn.onclick = (e => {
							document.location.href=`/index.php/#${id_img}`; 
						})
					}
					else if (name == "delete.svg") {
						btn.onclick = (e => {
							const url = "/scripts/removeImg.php";

							let data = new URLSearchParams();
							data.append(`id_img`, `${id_img}`);

							let result = fetch(url, {method:'post', body: data})
								.then((response) => response.json())
								.then((responseData) => {
									return responseData;
								})
								.catch(error => console.warn(error)
							);
								
							result.then(async function(response) {
								location.reload();
							});
						})
					}
				}

				imgLike.onclick = (e => {
					const url = "/scripts/likePicture.php";
					let data = new URLSearchParams();
					data.append(`id_img`, `${id_img}`);

					let result = fetch(url, {method:'post', body: data})
						.then((response) => response.json())
						.then((responseData) => {
							return responseData;
						})
						.catch(error => console.warn(error)
					);
						
					result.then(async function(response) {
						if (response?.code == 1 || response?.code == 2) {
							imgLike.src = (response.msg == "Like") ? "/img/like0.svg" : "/img/like1.svg";
							counterLike.innerHTML = response.counter;
						}
					});

				});
			});
			img.addEventListener("mouseout", e => {
				img.querySelector('div').style.visibility = "hidden";
			});
		};
	</script>

</body>
</html>
