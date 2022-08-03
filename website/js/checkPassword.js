const username = document.getElementById('username');
const password = document.getElementById('password');
const repassword = document.getElementById('repassword');
let emoji = [];

for (let i = 0; i < 7; i++) {
	let tmp = "emoji-" + i;
	emoji[i] = document.getElementById(tmp);
}

function contentUpper(str) {
	for (let c of str) {
		if (c >= 'A' && c <= 'Z')
			return (true);
	}
	return (false);
}

function contentLower(str) {
	for (let c of str) {
		if (c >= 'a' && c <= 'z')
			return (true);
	}
	return (false);
}

function contentDigit(str) {
	for (let c of str) {
		if (c >= '0' && c <= '9')
			return (true);
	}
	return (false);
}

function contentSymbole(str) {
	const format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

	return (format.test(str));
}

function updateEmoji() {
	emoji[0].textContent = (password.value == "" || password.value == username.value) ? "❌" : "✅";
	emoji[1].textContent = (password.value == "" || password.value != repassword.value) ? "❌" : "✅";
	emoji[2].textContent = (!contentUpper(password.value)) ? "❌" : "✅";
	emoji[3].textContent = (!contentLower(password.value)) ? "❌" : "✅";
	emoji[4].textContent = (!contentDigit(password.value)) ? "❌" : "✅";
	emoji[5].textContent = (!contentSymbole(password.value)) ? "❌" : "✅";
	emoji[6].textContent = (password.value.length < 8) ? "❌" : "✅";
}

updateEmoji();

password.addEventListener('input', e => {
	updateEmoji();
});

repassword.addEventListener('input', e => {
	updateEmoji();
});

username.addEventListener('input', e => {
	updateEmoji();
});
