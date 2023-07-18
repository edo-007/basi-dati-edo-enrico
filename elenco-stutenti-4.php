<?php 

// Consultare l’elenco degli utenti della biblioteca (con le informazioni principali).

	include_once('connessione.php'); 
	
	$sql = "SELECT NOME, COGNOME, MATRICOLA, NUMERO_TELEFONO
                    FROM Studente";

	$result = mysqli_query($link, $sql);
	if (!$result) {
		echo "Si è verificato un errore: " . mysqli_error($link);
		exit;
	}
    

	mysqli_close($link);

?>


<!DOCTYPE html>

<html lang="it">
    <head>
        <meta charset="utf-8">
		        
		<title>Cerca Libro</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}
		</style>
    </head>
    
    <body>

		<h2> Elenco Utenti </h2> 
        
        <table>
            <thead>
                <tr> <th>Matricola</th> <th>Nome</th> <th>Cognome</th> <th>Numero telefono</th> </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) 
                { ?> 
                    <tr><td> <?php echo $row['MATRICOLA'] ?> </td>
                        <td> <?php echo $row['NOME'] ?></td> 
                        <td> <?php echo $row['COGNOME'] ?></td>
                        <td> <?php echo $row['NUMERO_TELEFONO'] ?></td>
                    </tr>
                <?php 
                } ?>

                <form  action="index.php" method="post">
				    <input type="submit" value= "◄ Home">
		        </form>
                
            </tbody>
        </table>        

    </body>

</html>


