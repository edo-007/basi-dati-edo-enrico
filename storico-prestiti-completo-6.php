<?php 

//  Consultare lo storico dei prestiti comprese le informazioni (sintetiche - nome,
//  cognome) sull’utente
	

// ID_PRESTITO         INT AUTO_INCREMENT,
    
// MATRICOLA_S         CHAR(6)  NOT NULL,						-- MATRICOLA STUDENTE
// ID_L                INT,      	  							-- ID LIBRO
// DATA_USCITA         DATE,


    include_once('connessione.php');     


        $sql = "SELECT p.ID_PRESTITO,p.MATRICOLA_S, p.DATA_USCITA, s.NOME, s.COGNOME
                    FROM Prestito AS p, Studente AS s
                        WHERE p.MATRICOLA_S = s.MATRICOLA";

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
		        
		<title>Storico Prestiti</title>
        

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}
            
		</style>

    </head>
    
    <body>

        <h2> Storico prestiti completo </h2>
        <form  action="index.php" method="post">
            <input type="submit" value= "◄ Home">
        </form>
        <hr>
        <br>

        <table >
            <thead>
            <tr> 
                <th>ID Prestito</th> 
                <th>Data</th> 
                <th> <th> Matricola </th> <th> Nome </th> <th> Cognome </th> </th> 
            </tr>

            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) 
                { ?> 
                    <tr>
                        <td> <?php echo $row['ID_PRESTITO'] ?> </td>
                        <td> <?php echo $row['DATA_USCITA'] ?></td>
                        <td> <td> <?php echo $row['MATRICOLA_S'] ?> </td> <td> <?php echo $row['NOME'] ?> </td> <td> <?php echo $row['COGNOME'] ?> </td>  </td>
                    </tr>
                <?php 
                } ?>
            </tbody>
        </table>



            
    </body>

</html>


