<?php
$act = isset($_GET['act']) ? $_GET['act'] : "";

function data_pelabuhan(){
	//fetch data
	$jarak = fetch_data('jarak');
	echo '
		<table class="table table-condensed table-bordered">
			<tr>
				<th>ID</th>
				<th>Node Awal</th>
				<th>Node Akhir</th>
				<th>Jarak (km)</th>
				<th colspan="2">Aksi</th>
			</tr>
	';
	foreach($jarak as $data){
		$update = base_url('index.php?page=datajarak&act=update&id='.$data['id']);
		$delete = base_url('modul/mod_datajarak/aksi_datajarak.php?act=delete&id='.$data['id']);
		echo '
			<tr>
				<td>'.$data['id'].'</td>
				<td>'.$data['node_awal'].'</td>
				<td>'.$data['node_akhir'].'</td>
				<td>'.$data['jarak'].'</td>
				<td align="center">
					<a href="'.$update.'">
						<span class="glyphicon glyphicon-edit"></span>
						<span class="sr-only">Update</span>
					</a>
				</td>
				<td align="center">
					<a href="'.$delete.'" data-confirm="Anda yakin ingin menghapus data jarak antar pelabuhan id : '.$data['id'].' ?">
						<span class="glyphicon glyphicon-trash"></span>
						<span class="sr-only">Delete</span>
					</a>
				</td>
			</tr>
		';
	}
	echo '</table>';
}

function form_tambah(){
	$action = base_url("modul/mod_datajarak/aksi_datajarak.php?act=tambah");
	$list_pelabuhan = fetch_data('nama_pelabuhan');
	$list = '';
	foreach($list_pelabuhan as $data){
		$list .= '<option value="'.$data['id_pelabuhan'].'">('.$data['id_pelabuhan'].')  '.$data['nama_pelabuhan'].'</option>';
	}
	echo '
		<div class="panel panel-default">
			<div class="panel-heading">Tambah Data</div>
			<div class="panel-body">
				<form action="'.$action.'" method="POST">
					<div class="form-group">
						<label for="node_awal">Node Awal Pelabuhan</label>
						<select class="form-control" id="node_awal" name="node_awal">
							'.$list.'
						</select>
					</div>

					<div class="form-group">
						<label for="node_akhir">Node Akhir Pelabuhan</label>
						<select class="form-control" id="node_akhir" name="node_akhir">
							'.$list.'
						</select>
					</div>
					
					<div class="form-group">
						<label for="jarak">Jarak</label>
						<input type="text" class="form-control" id="jarak" name="jarak" />
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="Submit" value="Create Data" />
						&nbsp;
						<input type="reset" class="btn btn-default" name="Reset" value="Reset" />
					</div>
				</form>
			</div>
		</div>
	';
}

function form_update(){
	$clause = array(
		array(
			'id_jarak',
			' = ',
			$_GET['id']
		)
	);
	$limit  = 1;
	$data   = fetch_data('jarak_antar_pelabuhan', $clause, $limit);
	if(!$data){
		set_flashdata('error', 'Data id : '.$_GET['id'].' tidak ditemukan.');
		redirect(base_url('index.php?page=datajarak'));
	}
	$list_pelabuhan = fetch_data('nama_pelabuhan');
	$list_awal = '';
	$list_akhir = '';
	foreach($list_pelabuhan as $pelabuhan){
		$selected_awal  = ($pelabuhan['id_pelabuhan']==$data[0]['id_node_awal']) ? 'selected="selected"' : '';
		$selected_akhir = ($pelabuhan['id_pelabuhan']==$data[0]['id_node_akhir']) ? 'selected="selected"' : '';
		$list_awal .= '<option value="'.$pelabuhan['id_pelabuhan'].'" '.$selected_awal.'>('.$pelabuhan['id_pelabuhan'].')  '.$pelabuhan['nama_pelabuhan'].'</option>';
		$list_akhir .= '<option value="'.$pelabuhan['id_pelabuhan'].'" '.$selected_akhir.'>('.$pelabuhan['id_pelabuhan'].')  '.$pelabuhan['nama_pelabuhan'].'</option>';
	}
	$action = base_url('modul/mod_datajarak/aksi_datajarak.php?act=update');
	echo '
		<div class="panel panel-default">
			<div class="panel-heading">Update Data</div>
			<div class="panel-body">
				<form action="'.$action.'" method="POST">
					<div class="form-group">
						<label for="id">ID</label>
						<input type="text" class="form-control" id="id" name="id" value="'.$data[0]['id_jarak'].'" readonly="readonly" />
					</div>
					<div class="form-group">
						<label for="node_awal">Node Awal Pelabuhan</label>
						<select class="form-control" id="node_awal" name="node_awal">
							'.$list_awal.'
						</select>
					</div>

					<div class="form-group">
						<label for="node_akhir">Node Akhir Pelabuhan</label>
						<select class="form-control" id="node_akhir" name="node_akhir">
							'.$list_akhir.'
						</select>
					</div>
					<div class="form-group">
						<label for="jarak">Jarak</label>
						<input type="text" class="form-control" id="jarak" name="jarak"  value="'.$data[0]['jarak'].'" />
					</div>
				
					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="Submit" value="Update" />
						&nbsp;
						<input type="reset" class="btn btn-default" name="Reset" value="Reset" />
						&nbsp;
						<a href="'.base_url("index.php?page=datajarak").'" class="btn btn-default">Kembali</a>
					</div>
				</form>
			</div>
		</div>
	';
}

function form($act){
	if($act == 'update'){
		form_update();
	} else {
		form_tambah();
	}
}

function messages(){
	if(check_flashdata('sukses')){
		echo '
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success alert-dismissible" role="alert">
						<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						'.flashdata('sukses').'
					</div>
				</div>
			</div>
		';
	} else if(check_flashdata('error')){
		echo '
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-danger alert-dismissible" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						'.flashdata('error').'
					</div>
				</div>
			</div>
		';
	}
}
?>

<?php messages(); ?>
<div class='row'>
	<div class='col-sm-4 col-md-4'><?php form($act); ?></div>
	<div class='col-sm-8 col-md-8'><?php data_pelabuhan(); ?></div>
</div>