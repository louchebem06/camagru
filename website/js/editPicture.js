// Element

const edit = document.getElementById("edit");
const div_canvas = document.getElementById('div_canvas');
const filters = document.getElementById('filter');
const video = document.getElementById('video');
const div_video = document.getElementById('div-video');
const btn_captured = document.getElementById('captured');
const canvas = document.getElementById('canvas');
const src_edit = document.getElementById('src-edit');
const loading = document.getElementById('loading');
const divErrorCamara = document.getElementById('cameraError');
const toggle = document.getElementById("toggle");
const img_input = document.getElementById("img_input");
const btn_save = document.getElementById('btn_save');
const cadre_src = document.getElementById('cadre_src');
const cadre_div = document.getElementById('cadre');

// Function
function writeElement(filter, x, y, sizeX, sizeY) {
	const context = canvas.getContext('2d');
	context.drawImage(filter, x, y, sizeX, sizeY);
}

function takepicture() {
	const context = canvas.getContext('2d');
	const ratio = video.videoWidth / 600;
	edit.width = canvas.width = 600;
	edit.height = canvas.height = video.videoHeight / ratio;
	context.drawImage(video, 0, 0, canvas.width, canvas.height);
	writeElement(cadre_src, 0, 0, canvas.width, canvas.height);
	btn_save.style.display = "block";
}

function inputPicture(img) {
	const context = canvas.getContext('2d');
	createImageBitmap(img)
		.then(imageBitmap => {
			const ratio = imageBitmap.width / 600;
			edit.width = canvas.width = 600;
			edit.height = canvas.height = imageBitmap.height / ratio;
			context.drawImage(imageBitmap, 0, 0, canvas.width, canvas.height);
		});
	btn_save.style.display = "block";
}

function activateWebcam() {
	div_video.style.display = "block";
	function error(err) {
		loading.style.display = "none";
		divErrorCamara.style.display = "block";
		const codeErrorP = document.getElementById('codeCameraError');
		const messageErrorP = document.getElementById('messageCameraError');

		codeErrorP.innerHTML  = "Code: " + err.code;
		messageErrorP.innerHTML  = "Message: " + err.message;
	}

	if (navigator.mediaDevices?.getUserMedia) {
		navigator.mediaDevices.getUserMedia({
			video: true,
			audio: false
		})
		.then(function(stream) {
			divErrorCamara.style.display = "none";
			video.srcObject = stream;
			video.play();
			loading.style.display = "none";
		})
		.catch((err) => {
			error(err);
		});
	} else {
		error({'code': "Jesus", 'message': "Please user localhost for fix error"});
	}
}

function disabledWebcam() {
	try {
		camera = video.srcObject.getTracks()[0];
		camera.stop();
		div_video.style.display = "none";
	} catch (e) {
		div_video.style.display = "none";
	}
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
	writeElement(src_edit, x, y, width, height);
	disabledFilter()
}

function getPicture() {
	const data = canvas.toDataURL('image/png');
	return (data);
}

function modeEdit(toggleState) {
	const msg = document.getElementById("messageMode");
	disabledFilter();
	btn_save.style.display = "none";
	if (!toggleState) {
		msg.innerHTML = "Webcam Mode";
		img_input.style.display = "none";
		canvas.style.display = "none";
		filters.style.display = "none";
		activateWebcam();
	} else {
		msg.innerHTML = "Upload Mode";
		img_input.style.display = "block";
		disabledWebcam();
	}
}

function save() {
	const picture = getPicture();
	const url = "/scripts/base64ToImg.php";

	let data = new URLSearchParams();
	data.append(`data`, `${picture}`);

	let result = fetch(url, {method:'post', body: data})
		.then((response) => response.json())
		.then((responseData) => {
			return responseData;
		})
		.catch(error => console.warn(error));
		
	result.then(async function(response) {
		if (response.msg == "ok") {
			document.location.href="/profil.php"; 
		} else {
			console.log("It should never have happened, please retry btn");
		}
	});
}

function upSize() {
	edit.style.width = src_edit.width + 10 + "px";
}

function downSize() {
	edit.style.width = src_edit.width - 10 + "px";
}

// Default

filters.style.display = "none";
img_input.style.display = "none";
divErrorCamara.style.display = "none";
btn_save.style.display = "none";
activateWebcam();

let filter = [];
let cadre = [];

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

for (let i = 0; i < 4; i++) {
	cadre.push(document.getElementById("cadre-" + i));
	cadre[i].addEventListener("click", e => {
		cadre_src.src = cadre[i].src;
		cadre_src.style.width = "100%";
		cadre_src.style.height = "100%";
		cadre_src.style.borderRadius = "15px";
		btn_captured.style.display = "block";
	});
}

// Event

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
	cadre_div.style.display = "none";
})

document.addEventListener("keydown", e => {
	if (e.key == "Escape" && toggle.checked == false) {
		loading.style.display = "block";
		btn_captured.style.display = "none";
		disabledFilter();
		activateWebcam();
		div_video.style.display = "block";
		canvas.style.display = "none";
		filters.style.display = "none";
		btn_save.style.display = "none";
		cadre_src.src = "";
		cadre_src.style.height = 0;
		cadre_div.style.display = "block";
	}
	else if (e.key == "Escape" && toggle.checked) {
		img_input.style.display = "block";
		img_input.value = null;
		canvas.style.display = "none";
		filters.style.display = "none";
		disabledFilter();
		btn_save.style.display = "none";
	}
	else if (e.key == "m" || e.key == "M") {
		toggle.checked = !toggle.checked;
		img_input.value = null;
		canvas.style.display = "none";
		filters.style.display = "none";
		modeEdit(toggle.checked);
	}
});

toggle.addEventListener('change', e=> {
	modeEdit(toggle.checked);
})

img_input.addEventListener('change', e => {
	inputPicture(e.target.files[0]);
	canvas.style.display = "block";
	filters.style.display = "block";
	img_input.style.display = "none";
});
