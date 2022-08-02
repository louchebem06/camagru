export function addError(msg) {
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
