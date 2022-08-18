<?php
	session_start();

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/functions/validTokenReset.php");

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
	<title>Reset Password</title>
	<link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/header.php") ?>
	
	<div id="website" class="website">
		
		<h1>Reset Password</h1>
		
		<?php
			if (isset($_GET['t']) && !empty($_GET['t'])) {
				$id_user = validTokenReset($_GET['t']);
				if ($id_user == false)
					goto other;
				?>
				<div class="box">

					<input type="hidden" value="<?php echo $_GET['t'] ?>" id="reset_token"/>
					<input type="hidden" value="<?php echo $id_user ?>" id="id_user"/>
					<input type="password" placeholder="New Password" id="password" />
					<input type="submit" value="save" onclick="setNewPassword()" />

				</div>
				<?php
			} else {
				other:
		?>
		<div class="box">

			<input type="email" placeholder="Email for reset password" id="email" />
			<input type="submit" value="reset password" onclick="resetPassword()" />

		</div>
		<?php } ?>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>

	<script>
		function setNewPassword() {
			const token = document.getElementById('reset_token');
			const id_user = document.getElementById('id_user');
			const newPassword = document.getElementById('password');

			const url = "/scripts/updatePasswordByReset.php";

			let data = new URLSearchParams();
			data.append(`id_user`, `${id_user.value}`);
			data.append(`token`, `${token.value}`);
			data.append(`password`, `${password.value}`);

			let result = fetch(url, {method:'post', body: data})
				.then((response) => response.json())
				.then((responseData) => {
					return responseData;
				})
				.catch(error => console.warn(error)
			);
				
			result.then(async function(response) {
				console.log(response);
			});
		}
	</script>

	<script>
		function resetPassword() {
			const url = "/scripts/resetPassword.php";
			const mail = document.getElementById('email');

			let data = new URLSearchParams();
			data.append(`email`, `${mail.value}`);

			let result = fetch(url, {method:'post', body: data})
				.then((response) => response.json())
				.then((responseData) => {
					return responseData;
				})
				.catch(error => console.warn(error)
			);
				
			result.then(async function(response) {
				console.log(response);
			});
		}
	</script>

</html>
