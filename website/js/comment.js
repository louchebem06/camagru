function send(e, form) {
	const id_img = form.id_img.value;
	const comment = document.getElementById(`comment_input_${id_img}`);

	let result = fetch(form.action, {method:'post', body: new FormData(form)})
		.then((response) => response.json())
		.then((responseData) => {
			return responseData;
		})
		.catch(error => console.warn(error));

	result.then(async function(response) {
		console.log(response);
		comment.placeholder = response.msg;
		getComment(id_img);
	});

	comment.value = "";
	e.preventDefault();
}

export {send};
