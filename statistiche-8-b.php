
<?php 

    include_once('connessione.php'); 

// b.Prestiti per succursale
    $sql = "SELECT s.NOME AS nome_succ, COUNT(p.ID_PRESTITO) AS numero_prestiti
                        FROM Succursale s
                            LEFT JOIN Libro l ON s.ID_SUCC = l.ID_S
                                LEFT JOIN Prestito p ON l.ID_LIBRO = p.ID_L
                                    GROUP BY s.NOME, s.ID_SUCC";

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
                <tr> <th>Anno</th> <th>N.libri</th> </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) 
                { ?> 
                    <tr><td> <?php echo $row['nome_succ'] ?> </td>
                        <td> <?php echo $row['numero_prestiti'] ?></td> 
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


