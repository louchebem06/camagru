<footer>
	<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		if (validUser($_SESSION['id'])) { ?>
			<div class="title">
				<h2>They are new here</h2>
				<a href="#">See more</a>
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