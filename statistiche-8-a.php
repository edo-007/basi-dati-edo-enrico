
<?php 

    include_once('connessione.php'); 

// a. Numero di libri pubblicati in un determinato anno.
    $sql = "SELECT i.ANNO_PUBBLICAZIONE AS anno, COUNT(i.ISBN) AS numero_libri 
                FROM ISBN_Info AS i
                    GROUP BY i.ANNO_PUBBLICAZIONE
                    ORDER BY i.ANNO_PUBBLICAZIONE";

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
                <tr> <th>Anno</th> <th>N. libri</th> </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) 
                { ?> 
                    <tr><td> <?php echo $row['anno'] ?> </td>
                        <td> <?php echo $row['numero_libri'] ?></td> 
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


