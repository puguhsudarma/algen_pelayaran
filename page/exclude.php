<?php
function title(){
	$title = isset($_GET['page']) ? $_GET['page'] : "";
	switch($title){
		case "datanamapelabuhan"	: $title = "Data Nama Pelabuhan";						break;
		case "datajarak"			: $title = "Data Jarak Antar Pelabuhan";				break;
		case "algen"				: $title = "Algoritma Genetika TSP Pelayaran Laut";		break;
		case ""						:
		default 					: $title = "Program Kelompok Algoritma Genetika";		break;
	}
	return $title;
}

function content(){ 
	$mod = isset($_GET['page']) ? $_GET['page'] : "";
	switch($mod){
		case "" 					: include "modul/mod_home/home.php"; 							break;
		case "datanamapelabuhan"	: include "modul/mod_datanamapelabuhan/datanamapelabuhan.php"; 	break;
		case "datajarak"			: include "modul/mod_datajarak/datajarak.php";					break;
		case "algen"				: include "modul/mod_algen/algen.php";							break;
		default						: include "modul/mod_warning/error.php";						break;
	}
}

function menu(){
	echo "
	<nav class='navbar navbar-default navbar-fixed-top'>
		<div class='container-fluid'>
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class='navbar-header'>
				<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1' aria-expanded='false'>
					<span class='sr-only'>Toggle navigation</span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</button>
				<a class='navbar-brand' href='#'>Algoritma Genetika</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
				<ul class='nav navbar-nav'>
					<li><a href='".base_url()."'><span class='glyphicon glyphicon-home'></span> Home</a></li>
					<li class='dropdown'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><span class='glyphicon glyphicon-th-large'></span> Data Jarak Antar Pelabuhan <span class='caret'></span></a>
						<ul class='dropdown-menu'>
							<li><a href='".base_url('index.php?page=datanamapelabuhan')."'><span class='glyphicon glyphicon-tree-conifer'></span> Data Nama Pelabuhan</a></li>
							<li><a href='".base_url('index.php?page=datajarak')."'><span class='glyphicon glyphicon-tree-conifer'></span> Data Jarak Antar Pelabuhan</a></li>
						</ul>
					</li>
					<li><a href='".base_url('index.php?page=algen')."'><span class='glyphicon glyphicon-th-large'></span> Proses Algoritma Genetika</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	";
}