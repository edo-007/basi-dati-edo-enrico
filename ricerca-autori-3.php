<?php 
	include_once('connessione.php'); 	

	$sql = "SELECT DISTINCT PAESE_NASCITA 
				FROM Autore 
					ORDER BY PAESE_NASCITA";

	$paesi = mysqli_query($link, $sql);
	if (!$paesi) {
		echo "Si è verificato un errore: " . mysqli_error($link);
		exit;
	}
    

?>


<!DOCTYPE html>

<html lang="it">
    <head>
        <meta charset="utf-8">
		        
		<title>Ricerca Autori</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}
		</style>
    </head>
    
    <body>
        

		<h2>Ricerca Autori </h2>

		<form  action="index.php" method="post">
			<input type="submit" value= "◄ Home">
		</form>
		<br>
		

		<form  action="ricerca-autori-result-3.php" method="post">
			<fieldset>
				
				<label> Nome </label>
				<input type="text" name="nome_autore"><br>
				
				<label> Cognome </label>
				<input type="text" name="cognome_autore"><br>
				
				<label>Paese Nascita </label>
				<select name="paese_autore">

						<option value="__all__">  <i>Tutti</i>  </option>
					<?php
					while ($row = mysqli_fetch_array($paesi)) 
                	{ ?> 
						<option value="<?php echo $row['PAESE_NASCITA'] ?>"> <?php echo $row['PAESE_NASCITA']?> </option> 
						
					<?php 
                	} ?>
				</select>
				<br>
				
				<input type="submit" value= "Vai alla ricerca">
			</fieldset>
		</form>

    </body>
</html>
