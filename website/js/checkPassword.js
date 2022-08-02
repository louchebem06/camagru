const username = document.getElementById('username');
const password = document.getElementById('password');
const repassword = document.getElementById('repassword');
let emoji = [];

for (let i = 0; i < 7; i++) {
	let tmp = "emoji-" + i;
	emoji[i] = document.getElementById(tmp);
}

function updateEmoji() {
	// check if value is empty
	emoji[0].textContent = (password.value == username.value) ? "❌" : "✅";
	emoji[1].textContent = (password.value != repassword.value) ? "❌" : "✅";
	emoji[2].textContent = (true /* Check uppercase */) ? "❌" : "✅";
	emoji[3].textContent = (true /* Check lowercase */) ? "❌" : "✅";
	emoji[4].textContent = (true /* Check digit */) ? "❌" : "✅";
	emoji[5].textContent = (true /* Check symbole */) ? "❌" : "✅";
	emoji[6].textContent = (true /* Check len >= 8 */) ? "❌" : "✅";
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
