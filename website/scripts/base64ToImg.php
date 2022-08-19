<?php
session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id']) || !isset($_POST['data'])) {
	$return = [
		"msg"=>"User not connected or data invalid",
	];
	echo json_encode($return);
	exit();
}

$filter = array();
$data = json_decode($_POST['data']);
foreach ($data as $d) {
	foreach ($d as $k => $v) {
		if ($k == "cadre") {
			$cadre = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . $v);
		}
		else if ($k == "picture") {
			$picture = $v;
		} else {
			array_push($filter, $d);
		}
		break ;
	}
}

/*
	todo fix filter element placing
*/
function writeElement($dest, $src, $x, $y, $width, $height) {
	$newSrc = imagecreatetruecolor($width, $height);   
	imagealphablending($newSrc, false);
	imagesavealpha($newSrc, true);

	imagecopyresampled($newSrc, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));
	imagecopy($dest, $newSrc, 0, 0, $x, $y, $width, $height);
}

$image_parts = explode(";base64,", $picture);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_en_base64 = base64_decode($image_parts[1]);

$img = imagecreatefromstring($image_en_base64);
writeElement($img, $cadre, 0, 0,imagesx($img), imagesy($img));

foreach ($filter as $d) {
	$filter = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . $d->filter);
	$x = $d->x;
	$y = $d->y;
	$width = $d->width;
	$height = $d->height;
	writeElement($img, $filter, intval($x), intval($y), intval($width), intval($height));
}

$name = bin2hex(openssl_random_pseudo_bytes(16));

$dir = $_SERVER['DOCUMENT_ROOT'] . "/upload";
if (!file_exists($dir))
	mkdir($dir);

imagepng($img, $dir . '/' . $name . ".png");

require_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$filenameWeb = "/upload/{$name}.png";

try {
	$data = [
		'user_id' => $_SESSION['id'],
		'file' => $filenameWeb
	];
	$sql = "INSERT INTO img (`user_id`, `file`) VALUES (:user_id, :file)";
	$stmt = $conn->prepare($sql);
	$exec = $stmt->execute($data);
	if ($exec)
		$id_picture = $conn->lastInsertId();
	$return = [
		"msg"=>"ok",
		"id_picture"=>$id_picture,
		"file"=>$filenameWeb
	];
		
	echo json_encode($return);
	exit();
} catch (Exception $e) {
	echo json_encode([
		"msg"=>"Error upload in BDD"
	]);
	exit();
}
