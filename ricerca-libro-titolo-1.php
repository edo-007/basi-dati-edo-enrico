<?php 

	include_once('connessione.php'); 
	
	$nome_libro = $_POST['titolo_libro'];

	$sql = "SELECT i.ISBN, i.TITOLO, i.LINGUA, s.NOME
                        FROM ISBN_Info AS i, Libro as l, Succursale as s
                            WHERE i.ISBN = l.ISBN AND i.TITOLO LIKE '%$nome_libro%'
                                                  AND l.ID_S = s.ID_SUCC";

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

		<h2> Ricerca Libro </h2> 
        <p> Libri per titolo '<i> <?php echo $nome_libro ?> </i>' </p>
        <table>
            <thead>
                <tr> <th>ISBN</th> <th>Nome</th> <th>Lingua</th> </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) 
                { ?> 
                    <tr><td> <?php echo $row['ISBN'] ?> </td>
                        <td> <?php echo $row['TITOLO'] ?></td> 
                        <td> <?php echo $row['NOME'] ?></td>
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


