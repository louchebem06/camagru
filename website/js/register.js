function addError(msg) {
	var div = document.getElementById('error');
	if (div)
		div.remove();
	var newDiv = document.createElement("div");
	newDiv.setAttribute('id','error');
	var p = document.createElement("p");
	var b = document.createElement("b");
	var pmsg = document.createTextNode(msg);
	var bmsg = document.createTextNode("Error: ");
	b.appendChild(bmsg);
	p.appendChild(b);
	p.appendChild(pmsg);
	newDiv.appendChild(p);
	newDiv.classList.add("box");
	var currentDiv = document.getElementById('website');
	currentDiv.prepend(newDiv);
}

function addSuccess(msg) {
	var div = document.getElementById('error');
	if (div)
		div.remove();
	var newDiv = document.createElement("div");
	newDiv.setAttribute('id','error');
	var p = document.createElement("p");
	var b = document.createElement("b");
	var pmsg = document.createTextNode(msg);
	var bmsg = document.createTextNode("Success: ");
	b.appendChild(bmsg);
	p.appendChild(b);
	p.appendChild(pmsg);
	newDiv.appendChild(p);
	newDiv.classList.add("box");
	var currentDiv = document.getElementById('website');
	currentDiv.prepend(newDiv);
}

function send(e,form) {
	result = fetch(form.action, {method:'post', body: new FormData(form)})
	.then((response) => response.json())
	.then((responseData) => {
		return responseData;
	})
	.catch(error => console.warn(error));
	
	result.then(async function(response) {
		msg = response['msg'];
		await msg;

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
