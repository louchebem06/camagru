<?php
function checkSecurePassword(string $password) : bool {
	$len			= strlen($password);
	$uppercase		= preg_match('@[A-Z]@', $password);
	$lowercase		= preg_match('@[a-z]@', $password);
	$number    		= preg_match('@[0-9]@', $password);
	$specialChars	= preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || $len < 8)
		return (false);
	return (true);
}
