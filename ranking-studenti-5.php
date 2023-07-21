
<?php 

    include_once('connessione.php'); 

// a. Numero di libri pubblicati in un determinato anno.

    $sql = "select  s.nome, s.cognome,s.matricola, COUNT(p.ID_PRESTITO) as NR_PRESTITI
	    FROM Prestito as p, Studente as s
		    WHERE p.MATRICOLA_S = s.MATRICOLA
			    GROUP BY p.MATRICOLA_S
				    ORDER BY NR_PRESTITI DESC;";

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

		<h2> Libri per Anno </h2> 
        
        <table>
            <thead>
                <tr> <th>Nome</th> <th>Cognome</th> <th>Matricola</th><th> Nr.Prestiti Effettuati</th> </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) 
                { ?> 
                    <tr><td> <?php echo $row[0] ?> </td>
                        <td> <?php echo $row[1] ?></td> 
                        <td> <?php echo $row[2] ?></td> 
                        <td> <?php echo $row[3] ?></td> 
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


