<?php
$con=mysqli_connect("localhost","root","","csi");
if (!$con) {
	# code...
	die("Connection failed:".mysqli_error());
}
?>