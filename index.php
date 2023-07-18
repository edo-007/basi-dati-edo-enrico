<!-- dove capire a che succursale appartiene un determinato libro. -->
<?php 
	include_once('connessione.php'); 	



	$sql= "SELECT NOME, COGNOME, ID_AUTORE FROM Autore";

	$result = mysqli_query($link, $sql);
	if (!$result) {
		echo "Si è verificato un errore: " . mysqli_error($link);
		exit;
	}
    

?>


<!DOCTYPE html>

<html lang="it">
    <head>
        <meta charset="utf-8">
		        
		<title>HOME</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}
			
		</style>
    </head>
    
    <body>
        
		<h1>Home Libreria</h1>
		<p>Progetto di Edoardo Ponsanesi ed Enrico Albertini </p>

		<hr>
		<br>

		<h2> Ricerca Libro </h2> 

		
		<p> Ricerca per <b>titolo</b> </p>
 		
		<form  action="ricerca-libro-titolo-1.php" method="post">
				<input type="text" name="titolo_libro" placeholder="Titolo Libro"><br>
				<input type="submit" value= "Cerca">
		</form>

		<br>
		<br>

		<table>

			<p> Ricerca per <b>autore</b> </p>
			
			<form  action="ricerca-libro-autore-2.php" method="post">
					<select name="id_autore">
						<?php
						while ($row = mysqli_fetch_array($result)) 
						{ ?> 
							<option value="<?php echo $row['ID_AUTORE'] ?>"><?php echo "$row[NOME] $row[COGNOME]"  ?> </option> 
							
						<?php 
						} ?>

					<input type="submit" value= "Cerca">
			</form>

			<br>
			<hr>
			<h2> Ricerca Autori </h2> 

			<form  action="ricerca-autori-3.php" method="post">
					<input type="submit" value= "Vai alla ricerca">
			</form>

		</table>

		<br>
		<hr>
		<br>
		
		<!-- azioni su Studenti -->
		<h2> Elenco Studenti </h2> 
		<form  action="elenco-stutenti-4.php" method="post">
			<input type="submit" value= "Vai all'elenco">
		</form>

							<!-- azioni su Studenti -->

		<br>
		<hr>

			<h2> Storico prestiti</h2>
			
					<form style="display:inline-block; display: inline;" action="storico-prestiti-studente-5.php" method="post" >
							<input style="display: inline;"type="submit" value= "Cerca per Utente">
							<label > Visualizza lo storico per <b>singolo utente</b></label>
					</form>

					<br><br>
					<form  action="storico-prestiti-completo-6.php" method="post">
							<input style="display: inline;" type="submit" value= "Storico completo">
							<label > Visualizza lo storico prestiti <b>completo</b></label>
					</form>
					<br>
					<form action="storico-prestiti-range-7.php" method="post">
							<input style="display: inline;" type="submit" value= "Cerca per Data ">
							<label > Ricerca dei prestiti in un <b>range di date</b></label>
					</form>
		
			<hr>
			<br>
			<h2> Statistiche </h2>

				a. Numero di libri pubblicati in un determinato anno.
				b. Numero di prestiti effettuati in una determinata succursale.
				c. Numero di libri pubblicati per autore.

    </body>
</html>
