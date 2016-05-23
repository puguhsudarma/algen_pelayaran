<?php
include "../../config/library_config.php";
include "../../config/fungsi_model_data.php";
switch($_GET['act']){
	case 'tambah':
		$input = array(
			'id_node_awal'	=> $_POST['node_awal'],
			'id_node_akhir'	=> $_POST['node_akhir'],
			'jarak'			=> $_POST['jarak']
		);
		$table = 'jarak_antar_pelabuhan';
		$insert = insert($table, $input);
		if($insert){
			set_flashdata('sukses', 'Data berhasil ditambah');
		} else {
			set_flashdata('error', 'Data gagal ditambah');
		}
		break;
	case 'update':
		$clause = array('id_jarak' => $_POST['id']);
		$input = array(
			'id_node_awal'	=> $_POST['node_awal'],
			'id_node_akhir'	=> $_POST['node_akhir'],
			'jarak'			=> $_POST['jarak']
		);
		$table = 'jarak_antar_pelabuhan';
		$update = update($table, $input, $clause);
		if($update){
			set_flashdata('sukses', 'Update data id : '.$clause['id_jarak'].' berhasil.');
		} else {
			set_flashdata('error', 'Update data id : '.$clause['id_jarak'].' gagal.');
		}
		break;
	case 'delete':
		$table  = 'jarak_antar_pelabuhan';
		$clause = array('id_jarak' => $_GET['id']);
		$delete = delete($table, $clause);
		if($delete){
			set_flashdata('sukses', 'Delete data id : '.$clause['id_jarak'].' berhasil.');
		} else {
			set_flashdata('error', 'Delete data id : '.$clause['id_jarak'].' gagal.');
		}
		break;
}
redirect(base_url("index.php?page=datajarak"));