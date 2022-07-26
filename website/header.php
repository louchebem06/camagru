<header>
	<div class="content">
		<h1>Camagru</h1>
		<div class="icons">
			<a href="/">
				<?php if (basename($_SERVER['PHP_SELF']) == "index.php") { ?>
					<img alt="logo home" src="/img/home1.svg"/>
				<?php } else { ?>
					<img alt="logo home" src="/img/home0.svg"/>
				<?php } ?>
			</a>
			<?php
				if (isset($_SESSION['id'])) {
					require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/getPicture.php");
			?>
				<a href="/createPicture.php">
					<img alt="logo add picture" src="/img/add.svg" />
				</a>
				<a href="/profil.php">
					<img class="userImg" alt="picture profile" src="<?php echo getPicture() ?>" />
				</a>

				<a href="/scripts/disconnect.php">
					<img src="/img/logout.svg" />
				</a>
			<?php } else { ?>
			<a href="/registration.php">
				<?php if (basename($_SERVER['PHP_SELF']) == "registration.php") { ?>
					<img alt="logo home" src="/img/reg1.svg"/>
				<?php } else { ?>
					<img alt="logo home" src="/img/reg0.svg"/>
				<?php } ?>
			</a>
			<?php } ?>
		</div>
	</div>
</header>