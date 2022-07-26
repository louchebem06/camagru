import {addError} from "./addError.js";
import {addSuccess} from "./addSuccess.js"

function send(e,form) {
	let result = fetch(form.action, {method:'post', body: new FormData(form)})
	.then((response) => response.json())
	.then((responseData) => {
		return responseData;
	})
	.catch(error => console.warn(error));
	
	result.then(async function(response) {
		let msg = response['msg'];

		if (msg == "ok") {
			const container = document.getElementById('website');
			container.textContent = '';
			addSuccess("Please check your mail for activate account");
		} else {
			addError(msg);
		}
	});
	
	e.preventDefault();
}

export {send};
