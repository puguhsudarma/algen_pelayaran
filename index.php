<?php
include "config/library_config.php";
include "config/fungsi_model_data.php";
include "page/exclude.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php printf(title()); ?></title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<link href="assets/style/main.css" rel="stylesheet" type="text/css" />
	<script src="assets/js/jquery-1.8.2.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/main.js"></script>
    <noscript><meta http-equiv="refresh" content="0; URL=page/js.html" /></noscript>
</head>
<!--
	Body Program //============================================
-->
<body>
<?php menu(); ?>
<div id="container">
	<h1><?php printf(title()); ?></h1>
	<div id="body"><?php content(); ?></div>
	<p class="footer">
		Created By <strong>Kelompok Algoritma Genetika</strong>. All Rights Reserved. 2016
	</p>
</div>
</body>
<!--
	Body Program //============================================
-->
</html>