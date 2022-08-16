<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/getUsername.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/getPicture.php");
?>

<footer>
	<?php
	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {

		$sql = "SELECT * FROM `user` WHERE `user_id` != '{$_SESSION['id']}' AND `activate` = '1' ORDER BY `user_id` DESC LIMIT 10";
		$state = $conn->query($sql);
		$users = $state->fetchAll(PDO::FETCH_ASSOC);

		if (validUser($_SESSION['id']) && count($users) >= 1) { 
			?>
			<div class="title">
				<h2>They are new here</h2>
				<?php
					foreach ($users as $key => $value) {
						$id = $value['user_id'];
						$picture = getPicture($id);
						$username = getUsername($id);
						?>
						<a href="/profil.php?id=<?php echo $id ?>">
							<div class="footer_profil">
								<img src="<?php echo $picture ?>" />
								<p><?php echo $username ?></p>
							</div>
						</a>
						<?php
					}
				?>
			</div>
		<?php }
	} ?>
	<div class="lien">
		<a href="https://github.com/louchebem06" target="_blank">Github </a>·
		<a href="https://www.linkedin.com/in/bryan-ledda-26466922a/" target="_blank">Linked </a>·
		<a href="https://www.codingame.com/profile/cf97f475e09be71f91cc804c7896f1398435824" target="_blank">CodinGame </a>·
		<a href="https://www.42nice.fr/" target="_blank">School</a>
	</div>
	<p>© 2022 CAMAGRU PAR BLEDDA</p>
</footer>