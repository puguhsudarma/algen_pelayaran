<?php
function hasil_algen(){
	$table = '';
	if(isset($_SESSION['kromosom'])){
		if(!session_id()){
			session_start();
		}
		$count = 0;
		$kromosom = $_SESSION['kromosom'];
		$antar_jarak = $_SESSION['antar_jarak'];
		$gen = count($kromosom)-1;
		while($count < $gen){
			$table .= '<tr>';
			$table .= '<td>'.($count+1).'</td>';
			$table .= '<td>'.($kromosom[$count]).'</td>';
			$table .= '<td>'.($kromosom[$count+1]).'</td>';
			$table .= '<td>'.($antar_jarak[$count]).'</td>';
			$table .= '</tr>';

			$count++;
		}
		$table .= '<tr>';
		$table .= '<td colspan="3" align="right"><strong>TOTAL JARAK<strong></td>';
		$table .= '<td><strong>'.($_SESSION['total_jarak']).'</strong></td>';
		$table .= '</tr>';
	} else {
		$table = '<tr><td colspan="4" align="center">Tidak ada data saat ini.</td></tr>';
	}

	echo '
		<div class="panel panel-default">
			<div class="panel-heading">Hasil Optimasi</div>
			<div class="panel-body">
				<table class="table table-condensed table-bordered">
					<tr>
						<th>No</th>
						<th>Node Awal</th>
						<th>Node Tujuan</th>
						<th>Jarak (km)</th>
					</tr>
					'.$table.'
				</table>
			</div>
		</div>';

	unset($_SESSION);
	session_destroy();
}

function form_input(){
	$action = base_url("modul/mod_algen/aksi_algen.php");
	$list_pelabuhan = fetch_data('nama_pelabuhan');
	$list = '';
	$pc = 0.5;
	$pm = 0.1;
	$epsilon = 0.5;
	$ukuran_populasi = 6;
	$a = 17;
	$c = 31;
	$m = 128;
	$z = 29;
	foreach($list_pelabuhan as $data){
		$list .= '<option value="'.$data['id_pelabuhan'].'">('.$data['id_pelabuhan'].')  '.$data['nama_pelabuhan'].'</option>';
	}
	echo '
		<div class="panel panel-default">
			<div class="panel-heading">Input Parameter</div>
			<div class="panel-body">
				<form action="'.$action.'" method="POST">
					<h2>Pelabuhan</h2>
					<div class="form-group">
						<label for="node_awal">Node Awal Pelabuhan</label>
						<select class="form-control" id="node_awal" name="node_awal">
							'.$list.'
						</select>
					</div>
					<div class="form-group">
						<label for="node_1">Node 1 Pelabuhan</label>
						<select class="form-control" id="node_1" name="node_1">
							'.$list.'
						</select>
					</div>
					<div class="form-group">
						<label for="node_2">Node 2 Pelabuhan</label>
						<select class="form-control" id="node_2" name="node_2">
							'.$list.'
						</select>
					</div>
					<div class="form-group">
						<label for="node_3">Node 3 Pelabuhan</label>
						<select class="form-control" id="node_3" name="node_3">
							'.$list.'
						</select>
					</div>
					<div class="form-group">
						<label for="node_4">Node 4 Pelabuhan</label>
						<select class="form-control" id="node_4" name="node_4">
							'.$list.'
						</select>
					</div>
					<div class="form-group">
						<label for="node_5">Node 5 Pelabuhan</label>
						<select class="form-control" id="node_5" name="node_5">
							'.$list.'
						</select>
					</div>
					<div class="form-group">
						<label for="node_akhir">Node Akhir Pelabuhan</label>
						<select class="form-control" id="node_akhir" name="node_akhir">
							'.$list.'
						</select>
					</div>
					
					<div class="checkbox">
						<label>
							<input type="checkbox" id="check_advanced" name="advanced"> Show Advanced Settings
						</label>
					</div>
					<div id="advanced_settings">
						<h2>Advanced Settings</h2>
						<div class="form-group">
							<label for="pc">Probabilitas Crossover</label>
							<input type="text" class="form-control" id="pc" name="pc" value="'.$pc.'" />
						</div>

						<div class="form-group">
							<label for="pm">Probabilitas Mutasi</label>
							<input type="text" class="form-control" id="pm" name="pm" value="'.$pm.'" />
						</div>

						<div class="form-group">
							<label for="epsilon">Epsilon</label>
							<input type="text" class="form-control" id="epsilon" name="epsilon" value="'.$epsilon.'" />
						</div>

						<div class="form-group">
							<label for="ukuran">Ukuran Populasi</label>
							<input type="text" class="form-control" id="ukuran" name="ukuran" value="'.$ukuran_populasi.'" />
						</div>

						<h2>Random Number Settings</h2>
						<div class="form-group">
							<label for="a">A</label>
							<input type="text" class="form-control" id="a" name="a" value="'.$a.'" />
						</div>

						<div class="form-group">
							<label for="c">C</label>
							<input type="text" class="form-control" id="c" name="c" value="'.$c.'" />
						</div>

						<div class="form-group">
							<label for="m">M</label>
							<input type="text" class="form-control" id="m" name="m" value="'.$m.'" />
						</div>

						<div class="form-group">
							<label for="z">Z</label>
							<input type="text" class="form-control" id="z" name="z" value="'.$z.'" />
						</div>											
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="Submit" value="Submit Data" />
						&nbsp;
						<input type="reset" class="btn btn-default" name="Reset" value="Reset" />
					</div>
				</form>
			</div>
		</div>
	';
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
	<div class='col-sm-5 col-md-5'><?php form_input(); ?></div>
	<div class='col-sm-7 col-md-7'><?php hasil_algen(); ?></div>
</div>