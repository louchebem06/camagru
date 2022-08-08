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
			<video id="video">Video stream not available.</video>
			<canvas id="canvas"></canvas>
		</div>
		
	</div>

	<?php include($_SERVER['DOCUMENT_ROOT'] . "/footer.php") ?>

</body>
	<script>
		
		let filters = document.getElementById('filter');
		let video = document.getElementById('video');
		let canvas = document.getElementById('canvas');

		filters.style.display = "none";

		function takepicture() {
			const context = canvas.getContext('2d');
			canvas.width = video.videoWidth;
			canvas.height = video.videoHeight;
			context.drawImage(video, 0, 0, canvas.width, canvas.height);

			const data = canvas.toDataURL('image/png');
		}

		function writeElement(filter, x, y, sizeX, sizeY) {
			const context = canvas.getContext('2d');
			context.drawImage(filter, x, y, sizeX, sizeY);
		}
		function activateWebcam() {
			if (navigator.mediaDevices.getUserMedia) {
				navigator.mediaDevices.getUserMedia({
					video: true,
					audio: false
				})
				.then(function(stream) {
					video.srcObject = stream;
					video.play();
				})
				.catch((err) => {
					console.error(`An error occurred: ${err}`);
				});
			}
		}

		function disabledWebcam() {
			/* TODO DISABLED WEBCAM */
		}

		activateWebcam();

		video.addEventListener("click", () => {
			takepicture();
			video.style.display = "none";
			canvas.style.display = "block";
			filters.style.display = "block";
			disabledWebcam();
		})

		let filter = [];
		for (let i = 0; i < 9; i++) {
			filter.push(document.getElementById("filter-" + i))
		}
		
		for (let i = 0; i < 9; i++) {
			filter[i].addEventListener("click", e => {
				writeElement(filter[i], 10, 10, 150, 150);
			});
		}

		document.addEventListener("keydown", e => {
			if (e.key == "Escape") {
				activateWebcam();
				video.style.display = "block";
				canvas.style.display = "none";
				filters.style.display = "none";
			}
		});

	</script>
</html>
