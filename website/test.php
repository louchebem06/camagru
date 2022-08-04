<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TESTOS</title>
</head>
<body>
	<div class="camera">
		<video id="video">Video stream not available.</video>
	</div>
	<canvas id="canvas"></canvas>
</body>
	<script>
		
		let video = document.getElementById('video');
		let canvas = document.getElementById('canvas');

		function takepicture() {
			const context = canvas.getContext('2d');
			canvas.width = video.videoWidth;
			canvas.height = video.videoHeight;
			context.drawImage(video, 0, 0, canvas.width, canvas.height);

			const data = canvas.toDataURL('image/png');
			console.log(data);
		}

		if (navigator.mediaDevices.getUserMedia) {
			navigator.mediaDevices.getUserMedia({video: true, audio: false})
				.then(function(stream) {
					video.srcObject = stream;
					video.play();
				})
				.catch((err) => {
					console.error(`An error occurred: ${err}`);
				});
		}

		video.addEventListener("click", () => {
			takepicture();
		})

	</script>
</html>
