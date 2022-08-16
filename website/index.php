<?php
	session_start();

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		if (!validUser($_SESSION['id'])) {
			header("Location: /scripts/disconnect.php");
			exit();
		}
	}

	require($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");
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
		<?php require($_SERVER['DOCUMENT_ROOT'] . "/functions/getComment.php"); ?>
		<?php
			foreach ($imgTab as $key => $value) {
				$user_id = $value['user_id'];
				$img_id = $value['img_id'];
				$file = $value['file'];
		?>
			<div class="box publication" id="<?php echo $img_id ?>">
				<a href="/profil.php?id=<?php echo $user_id ?>" >
					<div class="user_info_publication">
						<img src="<?php echo getPicture($user_id) ?>"/>
						<p><?php echo getUsername($user_id) ?></p>
					</div>
				</a>
				<img src="<?php echo $file ?>"/>
				<?php
					if (isset($_SESSION['id'])) { ?>
					<form method="POST" action="/scripts/addComment.php">
						<input type="hidden" value="<?php echo $img_id ?>" name="id_img"/>
						<div class="comments_containe" id="comments_<?php echo $img_id ?>">
						</div>
						<div class="comment_publication">
							<img src="/img/comment.svg" />
							<input id="comment_input_<?php echo $img_id ?>" type="text" placeholder="Enter your comment" name="comment" required/>
						</div>
						<div class="submit_publication">
							<input type="submit" />
							<a href="#<?php echo $img_id ?>">Look comment</a>
						</div>
					</form>
				<?php } else { ?>
					<div class="comments_containe" id="comments_<?php echo $img_id ?>">
					</div>
					<div class="submit_publication">
							<a href="#<?php echo $img_id ?>">Look comment</a>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>

	<script>
		function getComment(id_img) {
			const url = "/scripts/getComment.php";

			let data = new URLSearchParams();
			data.append(`id_img`, `${id_img}`);

			let result = fetch(url, {method:'post', body: data})
				.then((response) => response.json())
				.then((responseData) => {
					return responseData;
				})
				.catch(error => console.warn(error));
				
			result.then(async function(response) {
				const comments = document.getElementById(`comments_${id_img}`);
				comments.innerHTML = "";
				for (let res of response) {
					const picture = res['picture'];
					const username = res['username'];
					const com = res['comment'];
					comment = document.createElement("p");
					comment.textContent = com;
					user = document.createElement("p");
					user.textContent = username;
					let img = document.createElement("img");
					img.src = picture;
					let div = document.createElement("div");
					div.appendChild(img);
					div.appendChild(user);
					div.appendChild(comment);
					comments.appendChild(div);
				}
			});
		}

		if (location.hash != '') {
			const id_img = location.hash.slice(1);
			getComment(id_img);
		}

		window.addEventListener('hashchange', e => {
			if (location.hash != '') {
				const id_img = location.hash.slice(1);
				getComment(id_img);
			}
		});
	</script>

	<script type="module">
		import { send } from "/js/comment.js";

		const forms = document.querySelectorAll('form');
		
		for (let form of forms) {
			form.addEventListener('submit', e => {
				send(e, form);
			})
		}
	</script>

</html>
