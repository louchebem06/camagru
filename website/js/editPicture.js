// Element

const edit = document.getElementById("edit");
const editRight = document.getElementById("right");
const editBottom = document.getElementById("bottom");
const editBottomRight = document.getElementById("bottom-right");
const div_canvas = document.getElementById('div_canvas');
const filters = document.getElementById('filter');
const video = document.getElementById('video');
const div_video = document.getElementById('div-video');
const btn_captured = document.getElementById('captured');
const canvas = document.getElementById('canvas');
const src_edit = document.getElementById('src-edit');
const loading = document.getElementById('loading');

// Function

function takepicture() {
	const context = canvas.getContext('2d');
	edit.width = canvas.width = video.videoWidth;
	edit.height = canvas.height = video.videoHeight;
	context.drawImage(video, 0, 0, canvas.width, canvas.height);
}

function writeElement(filter, x, y, sizeX, sizeY) {
	const context = canvas.getContext('2d');
	context.drawImage(filter, x + 3, y + 3, sizeX, sizeY);
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
			loading.style.display = "none";
			btn_captured.style.display = "block";
		})
		.catch((err) => {
			console.error(`An error occurred: ${err}`);
		});
	}
}

function disabledWebcam() {
	camera = video.srcObject.getTracks()[0];
	camera.stop();
}

function disabledFilter() {
	edit.style.top = 0;
	edit.style.left = 0;
	edit.style.display = "none";
}

function applyFilter() {
	const width = src_edit.clientWidth;
	const height = src_edit.clientHeight;
	const canvas_info = div_canvas.getBoundingClientRect();
	const picture_info = src_edit.getBoundingClientRect();
	const y = picture_info.top - canvas_info.top;
	const x = picture_info.left - canvas_info.left;
	console.log(canvas_info, picture_info);
	writeElement(src_edit, x, y, width, height);
	// disabledFilter()
}

function getPicture() {
	const data = canvas.toDataURL('image/png');
	return (data);
}

// Default

filters.style.display = "none";

activateWebcam();

let filter = [];

for (let i = 0; i < 9; i++) {
	filter.push(document.getElementById("filter-" + i));
	filter[i].addEventListener("click", e => {
		src_edit.src = filter[i].src;
		edit.style.display = "block";
		edit.style.top = 0;
		edit.style.left = 0;
		edit.style.width = "100px";
		edit.style.height = "auto";
	});
}

// Event

editRight.addEventListener('mousedown', function(e) {
	let cb = e => {
		edit.style.width = e.pageX - edit.getBoundingClientRect().left + 'px';
		edit.style.height = edit.clientHeight + "px";
	}
	window.addEventListener('mousemove', cb);
	window.addEventListener('mouseup', () => window.removeEventListener('mousemove', cb), { once: true });
})

editBottom.addEventListener('mousedown', function(e) {
	let cb = e => {
		edit.style.height = e.pageY - edit.getBoundingClientRect().top + 'px';
		edit.style.width = edit.clientWidth + "px";
	}
	window.addEventListener('mousemove', cb);
	window.addEventListener('mouseup', () => window.removeEventListener('mousemove', cb), { once: true });
})

editBottomRight.addEventListener('mousedown', function(e) {
	let cb = e => {
		edit.style.width = e.pageX - edit.getBoundingClientRect().left + 'px';
		edit.style.height = e.pageY - edit.getBoundingClientRect().top + 'px';;
	}
	window.addEventListener('mousemove', cb);
	window.addEventListener('mouseup', () => window.removeEventListener('mousemove', cb), { once: true });
})

edit.addEventListener('mousedown', function(e) {
	let cb = e => {
		let top = parseInt(edit.style.top);
		let left = parseInt(edit.style.left);
		edit.style.top = top + e.offsetY - (edit.clientHeight / 2) + 'px';
		edit.style.left = left + e.offsetX - (edit.clientWidth / 2) + 'px';
	}
	edit.addEventListener('mousemove', cb);
	window.addEventListener('mouseup', () => edit.removeEventListener('mousemove', cb), { once: true });
})

btn_captured.addEventListener("click", () => {
	takepicture();
	div_video.style.display = "none";
	canvas.style.display = "block";
	filters.style.display = "block";
	disabledWebcam();
})

document.addEventListener("keydown", e => {
	if (e.key == "Escape") {
		loading.style.display = "block";
		btn_captured.style.display = "none";
		disabledFilter();
		activateWebcam();
		div_video.style.display = "block";
		canvas.style.display = "none";
		filters.style.display = "none";
	}
});
