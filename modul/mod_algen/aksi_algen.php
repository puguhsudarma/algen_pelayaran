<?php
require_once('../../config/library_config.php');
require_once('../../config/fungsi_model_data.php');
require_once('fungsi_algen.php');

if(isset($_POST['Submit'])){
	$init = array(
		$_POST['node_awal'],
		$_POST['node_1'],
		$_POST['node_2'],
		$_POST['node_3'],
		$_POST['node_4'],
		$_POST['node_5'],
		$_POST['node_akhir']
	);
	$advance = array(
		'pc'		=> $_POST['pc'],
		'pm'		=> $_POST['pm'],
		'epsilon'	=> $_POST['epsilon'],
		'ukuran'	=> $_POST['ukuran']
	);
	$lcg = array(
		'a' => $_POST['a'],
		'c' => $_POST['c'],
		'm' => $_POST['m'],
		'z' => $_POST['z']
	);
	$data_jarak = fetch_data('jarak_antar_pelabuhan');
	
	//debug
	/*
	echo '<pre>';
	print_r($init);
	print_r($advance);
	print_r($lcg);
	echo '</pre>';
	exit();
	*/
	
	//proses genetika
	$genetika = array();
	$count = 0;
	do{
		if($count == 0){
			$genetika[$count]['kromosom'] = populasi_awal($init, $advance['ukuran']);
		} else {
			$genetika[$count]['kromosom'] = $genetika[$count-1]['mutasi'];
		}
		$genetika[$count]['fitness'] = hitung_fitness($genetika[$count]['kromosom'], $data_jarak);
		$genetika[$count]['seleksi'] = seleksi($genetika[$count]['fitness'], $lcg['a'], $lcg['c'], $lcg['m'], $lcg['z']);
		$genetika[$count]['crossover'] = crossover($genetika[$count]['kromosom'], $genetika[$count]['seleksi'], $advance['pc'], $lcg['a'], $lcg['c'], $lcg['m'], $lcg['z']);
		$genetika[$count]['mutasi'] = mutasi($genetika[$count]['crossover'], $advance['pm'], $lcg['a'], $lcg['c'], $lcg['m'], $lcg['z']);
		$genetika[$count]['fitness_setelah_mutasi'] = hitung_fitness($genetika[$count]['mutasi'], $data_jarak);
		//perbandingan fitness
		if($count > 0){
			$fitness_k = array_sum($genetika[$count]['fitness_setelah_mutasi']);
			$fitness_n = array_sum($genetika[$count-1]['fitness_setelah_mutasi']);
		} else {
			$fitness_k = 1;
			$fitness_n = 0;
		}

		$count++;
	}while(!stop_iterasi($fitness_k, $fitness_n, $advance['epsilon']));
	
	//post process
	$count -= 1;
	$finest_fitness = min($genetika[$count]['fitness_setelah_mutasi']);
	$finest_key = array_search($finest_fitnesss, $genetika[$count]['fitness_setelah_mutasi']);
	$finest_kromosom = $genetika[$count]['mutasi'][$finest_key];
	$returnJarak = ReturnJarak($finest_kromosom, $data_jarak);

	//full information nama pelabuhan
	$data_pelabuhan = fetch_data('nama_pelabuhan');
	foreach ($finest_kromosom as $kromosom) {
		foreach ($data_pelabuhan as $pelabuhan) {
			if($kromosom == $pelabuhan['id_pelabuhan']){
				$kromosom_decoding[] = '('.$kromosom.') '.$pelabuhan['nama_pelabuhan'];
				break;
			}
		}
	}
	session_start();
	$_SESSION = array(
		'kromosom' => $kromosom_decoding,
		'antar_jarak' => $returnJarak,
		'total_jarak' => $finest_fitness,
		'sukses' => 'Proses Algoritma Genetika berhasil dilakukan.' 
	);
	
	//debug
	/*
	echo "<pre>";
	print_r($genetika);
	echo "</pre>";
	exit();
	*/
}
redirect(base_url('index.php?page=algen'));