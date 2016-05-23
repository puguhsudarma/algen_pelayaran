<?php
include "../../config/library_config.php";
include "../../config/fungsi_model_data.php";
switch($_GET['act']){
	case 'tambah':
		$input = array(
			'nama_pelabuhan' => '"'.$_POST['nama'].'"'
		);
		$table = 'nama_pelabuhan';
		$insert = insert($table, $input);
		if($insert){
			set_flashdata('sukses', 'Data nama : '.$input['nama_pelabuhan'].' berhasil ditambah');
		} else {
			set_flashdata('error', 'Data nama : '.$input['nama_pelabuhan'].' gagal ditambah');
		}
		break;
	case 'update':
		$clause = array('id_pelabuhan' => $_POST['id']);
		$input = array(
			'nama_pelabuhan' => '"'.$_POST['nama'].'"'
		);
		$table = 'nama_pelabuhan';
		$update = update($table, $input, $clause);
		if($update){
			set_flashdata('sukses', 'Update data id : '.$clause['id_pelabuhan'].' berhasil.');
		} else {
			set_flashdata('error', 'Update data id : '.$clause['id_pelabuhan'].' gagal.');
		}
		break;
	case 'delete':
		$table  = 'nama_pelabuhan';
		$clause = array('id_pelabuhan' => $_GET['id']);
		$delete = delete($table, $clause);
		if($delete){
			set_flashdata('sukses', 'Delete data id : '.$clause['id_pelabuhan'].' berhasil.');
		} else {
			set_flashdata('error', 'Delete data id : '.$clause['id_pelabuhan'].' gagal.');
		}
		break;
}
redirect(base_url("index.php?page=datanamapelabuhan"));