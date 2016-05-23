<?php
function populasi_awal($pelabuhan, $ukuran = 0){
	//validasi
	if(empty($pelabuhan) || count($pelabuhan) <= 2){
		return FALSE;
	}

	//copy awal - akhir dan tengah gen
	$akhir = end($pelabuhan);
	$awal  = reset($pelabuhan);
	$n = array_search($akhir, $pelabuhan);
	for($i=1;$i<$n;$i++){
		$node_tengah[] = $pelabuhan[$i];
	}

	//hitung kemungkinan permutasi yang ada
	//Jika lebih besar dari ukuran populasi, maka gunakan ukuran
	$kemungkinan = faktorial($i-1);
	if($kemungkinan <= $ukuran){
		$batasan = $kemungkinan;
	} else {
		$batasan = $ukuran;
	}

	//count looping untuk merge semua gen
	$count = 0;

	//dapatkan semua kemungkinan permutasi
	$permutasi = AllPermutations($node_tengah);
	
	//proses merging gen
	$kromosom = array();
	while($count < $batasan){
		$kromosom[$count] = array_merge(
			(array)$awal,
			$permutasi[$count],
			(array)$akhir
		);
		$count++;
	}

	return $kromosom;
}

function hitung_fitness($kromosom, $data){
	//validasi
	if(empty($kromosom) || empty($data)){
		return FALSE;
	}

	$hasil = array();	
	foreach($kromosom as $populasi){
		//extract kromosom menjadi gen	
		do{
			//copy gen a dan b
			$akhir = next($populasi);
			$awal  = prev($populasi);

			//cocokkan gen a dan b dengan data jarak
			foreach($data as $row){
				next($row);
				if(current($row)==$awal && next($row)==$akhir){
					$jarak[] = next($row);
				}
			}
		}while(next($populasi));
		//total jarak adalah fitness kromosom ke-k
		$hasil[] = array_sum($jarak);
		unset($jarak);
	}
	return $hasil;
}

function seleksi($fitness, $a = 17, $c = 31, $m = 128, $z = 29, $offset = 2){
	if(empty($fitness)){
		return FALSE;
	}

	//mencari probabilitas tiap kromosom
	//mencari probabilitas kumulatif tiap kromosom
	//bangkitkan bilangan acak untuk tiap kromosom
	$total_fitness = array_sum($fitness);
	$prob = array();
	$prob_k = array();
	$acak = array();
	foreach($fitness as $jarak){
		$prob[] = number_format($jarak/$total_fitness, $offset);
	}
	$count = 0;
	foreach($prob as $probabilitas){
		if($count == 0){
			$prob_k[$count] = $probabilitas;
			$acak[$count] = LCG($a, $c, $m, $z, $offset);	
		} else {
			$prob_k[$count] = $prob_k[$count-1] + $probabilitas;
			$acak[$count] = LCG($a, $c, $m, $acak[$count-1]*$m, $offset);
		}
		$count++;
	}
	//seleksi berdasarkan bilangan random
	$terseleksi = array();
	foreach($acak as $lcg){
		$count = 0;
		foreach($prob_k as $p_k){
			if($lcg <= $p_k){
				$terseleksi[] = $count;
				break;
			}
			$count++;
		}
	}

	return $terseleksi;
}

function crossover($kromosom, $seleksi, $pc = 0.7, $a = 17, $c = 31, $m = 128, $z = 29, $offset = 2){
	//bangkitkan bilangan acak untuk indukkan
	//bandingkan bilangan acak dengan pc
	$count = 0;
	$acak = array();
	$crossover = array();
	foreach($seleksi as $banyak){
		//bilangan acak
		if($count == 0){
			$acak[$count] = LCG($a, $c, $m, $z, $offset);
		} else {
			$acak[$count] = LCG($a, $c, $m, $acak[$count-1]*$m, $offset);
		}

		//pemilihan induk crossover
		if($acak[$count] <= $pc){
			$crossover[] = $count;
		}
		$count++;
	}

	//bangkitkan bilangan acak untuk crossover gen
	$banyak_gen = count($kromosom[0]);
	$count = 0;
	foreach($crossover as $banyak){
		if($count == 0){
			$acak_crossover[$count] = LCG($a, $c, $banyak_gen, $z)*$banyak_gen;
		} else {
			$acak_crossover[$count] = LCG($a, $c, $banyak_gen, $acak_crossover[$count-1])*$banyak_gen;
		}
		$count++;
	}

	//proses crossover
	$kombinasi_crossover = getCombinations($crossover, 2);
	foreach($kombinasi_crossover as $cross){
		//inisialisasi
		$k1 = $kromosom[$cross[0]];
		$k2 = $kromosom[$cross[1]];
		$offspring = array();

		//crossover
		$count = 0;
		$curr_acak = round(current($acak_crossover));
		while($count < $banyak_gen){
			if($count < $curr_acak){
				//k1
				$offspring[]= $k1[$count];
			} else {
				//k2
				$offspring[]= $k2[$count];
			}
			$count++;
		}
		$new_kromosom[$cross[0]] = $offspring;
		unset($offspring);
		next($acak_crossover);
	}
	$hasil = array_replace_recursive($kromosom, $new_kromosom);
	return $hasil;
}

function mutasi($kromosom, $pm = 0.2, $a = 17, $c = 31, $z = 29){
	//mencari jumlah gen mutasi
	$jumlah_gen = 0;
	foreach ($kromosom as $populasi) {
		$jumlah_gen += count($populasi)-2;
	}
	$jumlah_gen_mutasi = round($jumlah_gen * $pm);
	
	//bangkitkan bilangan acak discrete
	$acak = array();
	$m = $jumlah_gen;
	for($i=0;$i<$jumlah_gen_mutasi;$i++){
		if($i == 0){
			$acak[$i] = round(LCG($a, $c, $m, $z)*$m);
		} else {
			$acak[$i] = round(LCG($a, $c, $m, $acak[$i-1])*$m);
		}
	}

	//proses mutasi
	$populasi = count($kromosom);
	$gen = count($kromosom[0]);
	foreach($acak as $mutasi){
		$count = 1;
		for($i=0;$i<$populasi;$i++){
			for($k=0;$k<$gen;$k++){
				if($k==0 || $k==($gen-1)){
					continue;
				}

				if($mutasi == $count){
					if($k == ($gen-2)){
						$a = $kromosom[$i][$k];
						$kromosom[$i][$k] = $kromosom[$i][1];
						$kromosom[$i][1] = $a;
					} else {
						$a = $kromosom[$i][$k];
						$kromosom[$i][$k] = $kromosom[$i][$k+1];
						$kromosom[$i][$k+1] = $a;
					}
					break(2);
				}
				$count++;
			}
		}
	}

	return $kromosom;
}

function stop_iterasi($fitness_k, $fitness_m, $epsilon = 0.5){
	$selisih = $fitness_k - $fitness_m;
	//$selisih_kontinu = 1/$selisih;
	if($selisih <= $epsilon){
		return TRUE;
	}
	return FALSE;
}

/*
	-------------------------------------------------------
	Fungsi pembantu
	-------------------------
*/

// Author : Reroet
function faktorial($n){
	if($n == 1 || $n == 0){
		return 1;
	} else {
		return $n*faktorial($n-1);
	}
}

// Stack Overflow - users/1723545/kickstart
function AllPermutations($InArray, $InProcessedArray = array()){
	$ReturnArray = array();
	foreach($InArray as $Key=>$value){
		$CopyArray = $InProcessedArray;
		$CopyArray[$Key] = $value;
		$TempArray = array_diff_key($InArray, $CopyArray);
		if (count($TempArray) == 0){
			$ReturnArray[] = $CopyArray;
		} else {
			$ReturnArray = array_merge($ReturnArray, AllPermutations($TempArray, $CopyArray));
		}
	}
	return $ReturnArray;
}

// Fungsi untuk membuat angka acak continue
function LCG($a, $c, $m, $z, $offset = 2){
	$discrete = ((($a*$z)+$c)%$m);
	$continue = round($discrete/$m, $offset);
	return $continue;
}

// Stack Overflow - users/1010916/kemal-da%c4%9f
function getCombinations($base,$n){
	$baselen = count($base);
	if($baselen == 0){
		return;
	}
	if($n == 1){
		$return = array();
		foreach($base as $b){
			$return[] = array($b);
		}
		return $return;
	}else{
		//get one level lower combinations
		$oneLevelLower = getCombinations($base,$n-1);
		//for every one level lower combinations add one element to them that the last element of a combination is preceeded by the element which follows it in base array if there is none, does not add
		$newCombs = array();
		foreach($oneLevelLower as $oll){
			$lastEl = $oll[$n-2];
			$found = false;
			
			foreach($base as  $key => $b){
				if($b == $lastEl){
					$found = true;
					continue;
					//last element found
				}

				if($found == true){
					//add to combinations with last element
					if($key < $baselen){
						$tmp = $oll;
						$newCombination = array_slice($tmp,0);
						$newCombination[]=$b;
						$newCombs[] = array_slice($newCombination,0);
					}
				}
			}
		}
	}
	return $newCombs;
}

// Fungsi return jarak dan total jarak akhir generasi
function ReturnJarak($kromosom, $data){
	$hasil = array();	
	do{
		//copy gen a dan b
		$akhir = next($kromosom);
		$awal  = prev($kromosom);

		//cocokkan gen a dan b dengan data jarak
		foreach($data as $row){
			next($row);
			if(current($row)==$awal && next($row)==$akhir){
				$jarak[] = next($row);
			}
		}
	}while(next($kromosom));

	return $jarak;
}