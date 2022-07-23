<?php
require($_SERVER['DOCUMENT_ROOT'] . "/functions/createUser.php");

if ($_GET['email'] && $_GET["username"] && $_GET["password"])
	echo createUser($_GET['email'], $_GET["username"], $_GET["password"]);
else
	echo "Please input values";
