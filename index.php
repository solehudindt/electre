<?php 
	session_start();	

	if(isset($_POST['submit'])){
		$_SESSION['baris'] = $_POST['baris'];
		$baris = $_SESSION['baris'];
	}	

	if(isset($_POST['kirim'])){
		for($i=0;$i<$_SESSION['baris'];$i++){
			$_SESSION['n'] = $_POST['n'];
		}
		header("Location: input_table.php");
		exit;
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Electre Method</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>	
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
	<?php include 'header.html'; ?>
	<section class="main-content">
		<div class="container">
			<?php if(isset($_POST['submit'])): ?>
			<form class="text-center" method="POST" action="">				
				<table class="table">
					<tr>
						<th>ALTERNATIF</th>
						<th>NAMA</th>
					</tr>
					<?php for($i=0;$i<$baris;$i++): ?>
					<tr>
						<td><?= $i+1 ?></td>
						<td>
							<input type="text" class="form-control" name="n[<?= $i ?>]" required>
						</td>
					</tr>
					<?php endfor ?>					
				</table>
				<button type="submit" class="btn btn-dark" name="kirim">KIRIM</button>
			</form>
			<?php else: ?>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-dark btn-block" data-toggle="collapse" data-target="#exampleModal">MULAI</button>
			<br>
			<!-- Modal -->
			<div class="collapse" id="exampleModal">
        		<h5 id="exampleModalLabel">Jumlah Alternatif</h5>
				    <form class="text-center" method="POST" action="">			
						<input type="text" class="form-control" name="baris" placeholder="jumlah baris" required>
							<br>
							<button type="submit" class="btn btn-dark" name="submit">Submit</button>	
					</form>	    
			</div>		
			<?php endif; ?>
		</div>
	</section>
	<?php include 'footer.html'; ?>
</body>
</html>