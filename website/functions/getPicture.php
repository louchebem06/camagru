<?php
function getPicture(int $id = NULL) : string {
	if ($id == NULL)
		$id = $_SESSION['id'];
	
	return ("/img/defaultUser.jpeg");
}