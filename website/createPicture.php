<?php
	session_start();

	require($_SERVER['DOCUMENT_ROOT'] . "/functions/validUser.php");

	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		if (!validUser($_SESSION['id'])) {
			header("Location: /scripts/disconnect.php");
			exit();
		}
	}

	if (!isset($_SESSION['id'])) {
		header("Location: /");
		exit();
	}

	$dirFilter = "/img/filter/";
	$dirCadre = "/img/cadre/";

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

	$cadre = [
		$dirCadre . "0.png",
		$dirCadre . "1.png",
		$dirCadre . "2.png",
		$dirCadre . "3.png"
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
	<link href="/css/toggle.css" rel="stylesheet" type="text/css">
</head>
<body>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/header.php") ?>
	
	<div class="website">

		<div class="box">
			<h2>Help</h2>
			<p>Press `Escape/Echap` for reset</p>
			<p>Press `M/m` for change mode</p>
		</div>

		<div class="box toggleWebcam">
			<label class="switch">
				<input type="checkbox" id="toggle">
				<span class="slider round"></span>
			</label>
			<p id="messageMode">Webcam Mode</p>
		</div>

		<div class="box filter-elements" id="cadre">
			<?php
				$id = 0;
				foreach ($cadre as $v) {
					echo "<img id=\"cadre-{$id}\" src=\"{$v}\"/>";
					$id++;
				}
			?>
		</div>

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
			<input type="file" accept="image/*" id="img_input"/>
			<div class="video" id="div-video">
				<video id="video"></video>
				<div class="cadre_div" id="cadre_div">
					<img src="" id="cadre_src"/>
				</div>
				<div class="lds-ripple" id="loading"><div></div><div></div></div>
				<div class="captured" id="captured"></div>
				<div id="cameraError">
					<img src="/img/webcamoff.svg" alt="Logo Camera Error" />
					<p id="codeCameraError"></p>
					<p id="messageCameraError"></p>
				</div>
			</div>
			<div class="canvas" id="div_canvas">
				<canvas id="canvas"></canvas>
				<div class="filter-edit nonSelectionnable" id="edit">
					<img id="src-edit" draggable="false" />
					<button onclick="disabledFilter()">Remove</button>
					<button onclick="applyFilter()">Valider</button>
					<button onclick="upSize()">Size up</button>
					<button onclick="downSize()">Size down</button>
				</div>
			</div>
		</div>

		<div class="box" id="btn_save">
			<button onclick="save()">Sauvegarder</button>
		</div>
		
		<div class="box" id="newPicture" style="display: none;"></div>

	</div>

</body>
	<script src="/js/editPicture.js"></script>
</html>
