<?php
	// session_start();

	// require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

	// if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
	// 	if (!validUser($_SESSION['id'])) {
	// 		header("Location: /scripts/disconnect.php");
	// 		exit();
	// 	}
	// }

	// require($_SERVER['DOCUMENT_ROOT'] . "/functions/getUsername.php");

	$dirFilter = "/img/filter/";
	$filter = [
		$dirFilter . "chapeau0.png",
		$dirFilter . "chapeau1.png",
		$dirFilter . "chapeau2.png",
		$dirFilter . "colier0.png",
		$dirFilter . "colier1.png",
		$dirFilter . "colier2.png",
		$dirFilter . "courone0.png",
		$dirFilter . "courone1.png",
		$dirFilter . "oreole.png"
	];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create your picture</title>
	<link href="/css/style.css" rel="stylesheet" type="text/css">
	<link href="/css/filter.css" rel="stylesheet" type="text/css">
	<link href="/css/webcam.css" rel="stylesheet" type="text/css">
	<link href="/css/loading.css" rel="stylesheet" type="text/css">
</head>
<body>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/header.php") ?>
	
	<div class="website">

		<div class="box filter-elements" id="filter">
			<?php
				$id = 0;
				foreach ($filter as $v) {
					echo "<img id=\"filter-{$id}\" src=\"{$v}\"/>";
					$id++;
				}
			?>
		</div>

		<div class="box">
			<div class="video" id="div-video">
				<video id="video"></video>
				<div class="lds-ripple" id="loading"><div></div><div></div></div>
				<div class="captured" id="captured"></div>
			</div>
			<div class="canvas" id="div_canvas">
				<canvas id="canvas"></canvas>
				<div class="filter-edit nonSelectionnable" id="edit">
					<div class="block nw"></div>
					<div class="block n"></div>
					<div class="block ne"></div>
					<div class="block w"></div>
					<div class="block e" id="right"></div>
					<div class="block sw"></div>
					<div class="block s" id="bottom"></div>
					<div class="block se" id="bottom-right"></div>
					<img id="src-edit" draggable="false" />
					<button onclick="disabledFilter()">Remove</button>
					<button onclick="applyFilter()">Valider</button>
				</div>
			</div>
		</div>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
	<script src="/js/editPicture.js"></script>
</html>
