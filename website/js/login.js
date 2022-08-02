import {addError} from "./addError.js";

function send(e,form) {
	let result = fetch(form.action, {method:'post', body: new FormData(form)})
	.then((response) => response.json())
	.then((responseData) => {
		return responseData;
	})
	.catch(error => console.warn(error));
	
	result.then(async function(response) {
		let msg = response['msg'];

		if (msg == "go home") {
			document.location.href="/";
		} else {
			addError(msg);
		}
	});
	
	e.preventDefault();
}

export {send};
