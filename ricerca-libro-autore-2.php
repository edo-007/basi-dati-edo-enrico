<?php 
    // Visualizzazione di tutti i libri di un determinato autore, 
    // eventualmente suddivisi per  anno di pubblicazione.

	include_once('connessione.php'); 
	
	$id_autore = $_POST['id_autore'];

    $sql =     "SELECT i.TITOLO, i.ANNO_PUBBLICAZIONE, i.LINGUA, l.ISBN 
                    FROM Libro AS l, ISBN_Info AS i
                        WHERE l.ISBN = i.ISBN 
                        AND l.ID_LIBRO IN 
                            ( SELECT ID_L FROM Scritto_Da WHERE ID_A = $id_autore)
                        ORDER BY ANNO_PUBBLICAZIONE";

    $sql_nome = "SELECT NOME, COGNOME 
                            FROM Autore
                                WHERE ID_AUTORE = $id_autore";

	$result = mysqli_query($link, $sql);
	$result_nome = mysqli_query($link, $sql_nome);
    
	if (!$result) {
		echo "Si è verificato un errore: " . mysqli_error($link);
		exit;
	}
    if (!$result_nome) {
		echo "Si è verificato un errore: " . mysqli_error($link);
		exit;
	}

    $autore = mysqli_fetch_array($result_nome);
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

		<h2> Ricerca Libro </h2> 
         
        <p> Libri per Autore <i> <?php echo "$autore[NOME] $autore[COGNOME]"; ?> </i> </p>
        

        <form  action="index.php" method="post">
            <input type="submit" value= "◄ Home">
        </form>

        <?php
        $row = mysqli_fetch_array($result);

        while ($row){ 
            $anno = $row['ANNO_PUBBLICAZIONE'];
        ?>
                <table>
                <!-- Head -->
                
                    <thead >
                        <tr>
                            <th> ISBN</th>
                            <th> Titolo</th>
                            <th  style="text-align:right"> <i> <?php echo $row['ANNO_PUBBLICAZIONE'] ?> </i></th>
                        </tr>      
                    </thead>

                    <!-- body -->
                    <tbody>
                        <?php while ( $anno == $row['ANNO_PUBBLICAZIONE'] ) { ?>

                            <tr>
                                <td><?php echo $row['ISBN'] ?></td>
                                <td><?php echo $row['TITOLO'] ?></td>
                                <td> </td>

                            </tr>
                        <?php
                            $row = mysqli_fetch_array($result);
                        }
                        ?>
                    </tbody>
                </table>

            <?php } ?>
     
        

    </body>

</html>


