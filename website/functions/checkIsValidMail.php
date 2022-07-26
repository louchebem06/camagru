<?php
function checkIsValidMail(string $mail) : bool {
	if (filter_var($mail, FILTER_VALIDATE_EMAIL))
		return (true);
	return (false);
}
