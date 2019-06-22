<?php 
	session_start();

	if(!isset($_SESSION['baris'])){
		echo '
			<script>
				alert("Jumlah Baris atau Data Belum di SET");
				document.location.href = "index.php";
			</script>
		';		
		exit;
	}
	
	$baris = $_SESSION['baris'];
	$kolom = 3;
	$w = $_POST['w'];
	$cel = $_POST['cel'];
	$normal = $cel;
	$options = $_POST['options'];

	$hasil = 0;
	$jumCon = 0;
	$jumDis = [];
	$totCon = 0;
	$totDes = 0;
	$rata2 = 0;
	$ranking = [];	

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Hitung</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>	
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
	<?php include 'header.html'; ?>
	<section class="main-content">
	<div class="container">		
		<button class="btn btn-dark btn-block" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    		Step by Step
  		</button>
		<div class="collapse" id="collapseExample">
  			<div class="card card-body">    				
			  <table class="table">	
					<tr>
						<td></td>
						<td>EKONOMI</td>
						<td>TANGGUNGAN</td>
						<td>USIA</td>
					</tr>
					<?php for($i=1;$i<=$baris+1;$i++): ?>
						<tr>					
							<?php for($k=0;$k<=3;$k++): ?>							
								<?php if($i==$baris+1 && $k==0): ?>
									<td>
										BOBOT
									</td>								
								<?php elseif($k==0): ?>							
									<td>
										<?= $_SESSION['n'][$i-1]; ?>
									</td>						
								<?php elseif($i==$baris+1): ?>
									<td>							
										<?= $w["1$k"] ?>	
									</td>
								<?php else: ?>
									<td>							
										<?= $cel["$i$k"] ?>
										</div>
									</td>
								<?php endif; ?>
							<?php endfor; ?>
						</tr>	
					<?php endfor; ?>				
				</table>
	 <h2 class="text-center">NORMALISASI</h2>	
		<table class="table table-bordered">
				<?php for($i=1;$i<=$baris;$i++): ?>
					<tr>												
						<?php for($k=1;$k<=$kolom;$k++): ?>														
							<?php 
								for($x=1;$x<=$baris;$x++){
									$hasil = $hasil + pow($normal["$x$k"],2);
								}	

								$normalisasi["$i$k"] = $normal["$i$k"]/sqrt($hasil);
								$hasil = 0;
							?>
								<td>
									<?= number_format($normalisasi["$i$k"],2) ?>
								</td>							
						<?php endfor; ?>
					</tr>	
				<?php endfor; ?>					
			</table>
	<h2 class="text-center">PEMBOBOTAN</h2>	
		<table class="table table-bordered">
				<?php for($i=1;$i<=$baris;$i++): ?>
					<tr>												
						<?php for($k=1;$k<=$kolom;$k++): ?>	
							<?php 
								$bobot["$i$k"] = $normalisasi["$i$k"] * $w["1$k"];
							?>						
								<td>
									<?= number_format($bobot["$i$k"],2) ?>
								</td>				
						<?php endfor; ?>
					</tr>	
				<?php endfor; ?>					
		</table>
	<h2 class="text-center">Himp. Con dan Dis</h2>
		<h3>Concordance</h3>
		<table class="table table-bordered">
			<?php for($i=1;$i<=$baris;$i++): ?>
				<tr>
					<?php for($k=1;$k<=$baris;$k++): ?>
						<?php 
							for($cek=1;$cek<=$kolom;$cek++){
								if($bobot["$i$cek"] >= $bobot["$k$cek"]){
									$jumCon = $jumCon + $w["1$cek"];
								}											
							}
							$concordance["$i$k"] = $jumCon;
							$jumCon = 0;
						?>
						<?php if($k==$i):?>
							<td>
								
							</td>
						<?php else: ?>				
							<td>
								<?= number_format($concordance["$i$k"],2) ?>	
							</td>
						<?php endif; ?>
					<?php endfor; ?>
				</tr>
			<?php endfor; ?>
		</table>
		<h3>Discordance</h3>
		<table class="table table-bordered">
			<?php for($i=1;$i<=$baris;$i++): ?>
				<tr>
					<?php for($k=1;$k<=$baris;$k++): ?>
						<?php 
							for($cek=1;$cek<=$kolom;$cek++){
								if($bobot["$i$cek"] < $bobot["$k$cek"]){
									$jumDis["$i$cek"] = abs($bobot["$i$cek"] - $bobot["$k$cek"]);
								}									
								else{
									$jumDis["$i$cek"] = 0;
								}	
								//Pembagi Discordance
								$totDis["$i$cek"] = abs($bobot["$i$cek"] - $bobot["$k$cek"]);
							}
							$atasDes = max($jumDis);
							$bawahDes = max($totDis);
							$jumDis = [];
							$totDis = [];
							
							if($bawahDes != 0){
								$descordance["$i$k"] = $atasDes/$bawahDes;
							}
							else{
								$descordance["$i$k"] = 0;
							}								
						?>
						<?php if($k==$i):?>
							<td>
								
							</td>
						<?php else: ?>				
							<td>
								<?= number_format($descordance["$i$k"],2) ?>		
							</td>
						<?php endif; ?>											
					<?php endfor; ?>					
				</tr>
			<?php endfor; ?>						
		</table>		
		<h2 class="text-center">NILAI DOMINAN</h2>
			<h3>Concordance</h3>
		<?php  			

			for($i=1;$i<=$baris;$i++){
				for($k=1;$k<=$baris;$k++){
					if($i != $k){
						$totCon = $totCon + $concordance["$i$k"];						
					}
				}							
			}			

			$c = $totCon/($baris*($baris-1));

			echo "Nilai Threshold (C) = " . number_format($c,2);
		?>		
			<table class="table table-bordered">
				<?php for($i=1;$i<=$baris;$i++): ?>
					<tr>
						<?php for($k=1;$k<=$baris;$k++): ?>
							<?php 
								for($cek=1;$cek<=$baris;$cek++){
									if($concordance["$i$cek"] >= $c){
										$f["$i$cek"] = 1;
									}			
									else{
										$f["$i$cek"] = 0;
									}								
								}							
							?>
							<?php if($k==$i):?>
								<td>
									
								</td>
							<?php else: ?>				
								<td>
									<?= $f["$i$k"]; ?>		
								</td>
							<?php endif; ?>
						<?php endfor; ?>
					</tr>
				<?php endfor; ?>
			</table>
			<h3>Discordance</h3>
		<?php  			

			for($i=1;$i<=$baris;$i++){
				for($k=1;$k<=$baris;$k++){
					if($i != $k){
						$totDes = $totDes + $descordance["$i$k"];						
					}
				}							
			}			

			$d = $totDes/($baris*($baris-1));

			echo "Nilai Threshold (D) = " . number_format($d,2);
		?>		
			<table class="table table-bordered">
				<?php for($i=1;$i<=$baris;$i++): ?>
					<tr>
						<?php for($k=1;$k<=$baris;$k++): ?>
							<?php 
								for($cek=1;$cek<=$baris;$cek++){
									if($descordance["$i$cek"] >= $d){
										$g["$i$cek"] = 1;
									}			
									else{
										$g["$i$cek"] = 0;
									}								
								}							
							?>
							<?php if($k==$i):?>
								<td>
									
								</td>
							<?php else: ?>				
								<td>
									<?= $g["$i$k"]; ?>		
								</td>
							<?php endif; ?>
						<?php endfor; ?>
					</tr>
				<?php endfor; ?>
			</table>
		<h2 class="text-center">Aggregate Dominance Matrix</h2>
		<h3>Threshold</h3>
		<table class="table table-bordered">			
			<?php for($i=1;$i<=$baris;$i++): ?>
				<tr>
					<?php for($k=1;$k<=$baris;$k++): ?>
						<?php 
							$e["$i$k"] = $f["$i$k"] * $g["$k$i"];
						?>						
						<?php if($i == $k): ?>
							<td></td>
						<?php else: ?>
							<td><?= $e["$i$k"]; ?></td>
						<?php endif; ?>
					<?php endfor; ?>
				</tr>
			<?php endfor; ?>
		</table>
		<h3>Tanpa Threshold</h3>
		<table class="table table-bordered">	
			<tr>
				<td colspan="<?= $baris; ?>"></td>
				<td>Rata2</td>
			</tr>
			<?php for($i=1;$i<=$baris;$i++): ?>
				<tr>
					<?php for($k=1;$k<=$baris+1;$k++): ?>
						<?php 
							if($k <= $baris)
								$e1["$i$k"] = $concordance["$i$k"] * $descordance["$k$i"];
						?>						
						<?php if($i == $k): ?>
							<td></td>
						<?php elseif($k == $baris+1): ?>		
							<?php for($r=1;$r<=$baris;$r++): ?>
								<?php $rata2 = $rata2 + $e1["$i$r"] ?>
							<?php endfor; ?>
							<?php $rata[$i-1] = $rata2/$baris ?>
							<?php $rata2 = 0 ?>
							<td>								
								<?= number_format($rata[$i-1],2) ?>
							</td>						
						<?php else: ?>
							<td><?= number_format($e1["$i$k"],2) ?></td>
						<?php endif; ?>
					<?php endfor; ?>
				</tr>
			<?php endfor; ?>
		</table>
			</div>
		</div>		
		<!-- INI UNTUK RANKING -->		
		<?php $ranking = $rata ?>
		<?php if($options == 1): ?>
			<?php rsort($ranking) ?>
		<?php else: ?>
			<?php sort($ranking) ?>
		<?php endif ?>
		<table class="table table-bordered">
			<tr>
				<th>RANKING</th>
				<th>NAMA</th>
				<th>NILAI</th>
			</tr>
			<?php for($i=0;$i<$baris;$i++): ?>
				<tr>
					<td><?= $i+1 ?></td>
					<td>
						<?php for($k=0;$k<$baris;$k++): ?>
							<?php if($rata[$i] == $ranking[$k]): ?>
								<?= $_SESSION['n'][$k] ?>
							<?php endif ?>
						<?php endfor; ?>
					</td>
					<td><?= number_format($ranking[$i]/array_sum($ranking),2) ?></td>
				</tr>
			<?php endfor ?>
		</table>
		<a href="hapus.php" class="btn btn-dark btn-block btn-lg active" role="button" aria-pressed="true">ULANGI</a>
		</div>		
	</div>	
    </section>
    <?php include 'footer.html'; ?>
</body>
</html>