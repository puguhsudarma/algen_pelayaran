<?php
//function untuk membuka koneksi ke database mysql
function MysqlConnectionOpen(){
	$setting_mysql = array(
					"host"		=> "localhost",
					"username"	=> "root",
					"password"	=> "",
					"database"	=> "algen_pelayaran"
				);

	$Connection = @mysqli_connect($setting_mysql['host'],$setting_mysql['username'],$setting_mysql['password'], $setting_mysql['database']);
	
	if(!$Connection){
		printf("<pre>	Error 				: Unable to connect to MySQL.<br />");
		printf("	Debugging error number 		: %d<br />", mysqli_connect_errno());
		printf("	Debugging error 		: %s<br /></pre>", mysqli_connect_error());
		exit;
	}

	return $Connection;
}

//function untuk menutup koneksi ke database mysql
function MysqlConnectionClose($Connection){
	if(!$Connection){
		return 0;
	} else {
		mysqli_close($Connection);
	}
}

//function untuk menentukan url root dari website
function base_url($string = ""){
	if($string == ""){
		$url = $_SERVER['SERVER_NAME'] == 'localhost' ? 'http://localhost/algen_pelayaran/' : 'http://'.$_SERVER['SERVER_NAME']."/algen_pelayaran/";	
	} else {
		$url = $_SERVER['SERVER_NAME'] == 'localhost' ? 'http://localhost/algen_pelayaran/'.$string : 'http://'.$_SERVER['SERVER_NAME']."/algen_pelayaran/".$string;
	}
	
	return $url;
}

//fungsi untuk berpindah halaman
function redirect($uri, $http_response_code = 302){
	header("Location: ".$uri, TRUE, $http_response_code);
	exit();
}

//set flash data
function set_flashdata($title, $value){
	if(!session_id()){
		session_start();
	}
	$_SESSION[$title] = $value;
}
//get flash data
function flashdata($title){
	if(!session_id()){
		session_start();
	}
	$val = $_SESSION[$title];
	unset($_SESSION[$title]);
	//session_destroy();
	return $val;
}
//check flashdata
function check_flashdata($title){
	if(!session_id()){
		session_start();
	}
	return isset($_SESSION[$title]);
}