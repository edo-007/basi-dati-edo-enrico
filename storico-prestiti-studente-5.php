<?php 

//  Ricerca di un utente della biblioteca e il
//  suo storico dei prestiti (compresi quelli in corso).
	
    include_once('connessione.php'); 

    // DICHIARARE UNIQUE (nome, cognome )
        
    $validInput = false;
    
    if ( !empty($_POST['matricola'])) {
        $matricola = $_POST['matricola'];

        $validInput = true;

        $sql = "SELECT p.ID_PRESTITO, p.DATA_USCITA, s.COGNOME, l.ISBN, l.ID_LIBRO
                    FROM Prestito AS p, Studente AS s, Libro AS l
                            WHERE MATRICOLA = '$matricola' AND p.MATRICOLA_S = s.MATRICOLA
                                                       AND p.ID_L = l.ID_LIBRO;";

        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo "Si è verificato un errore: " . mysqli_error($link);
            exit;
        }
        
        $sql_stud = "SELECT NOME, COGNOME, NUMERO_TELEFONO FROM Studente WHERE MATRICOLA = '$matricola'";
        $result_stud = mysqli_query($link, $sql_stud);
        if (!$result_stud) {
            echo "Si è verificato un errore: " . mysqli_error($link);
            exit;
        }
        $dati_stud = mysqli_fetch_array($result_stud);
    
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

            div {
                height: 40px;
                width: 700px;
            }

            input { display: inline; }

            form {
               display: inline-block; 
            }
            
		</style>

    </head>
    
    <body>
        <h2> Storico prestiti </h2>
        <br>
        
        <form action="storico-prestiti-studente-5.php" method="post">
            <label>Matricola:</label>
            <input type="text" name="matricola" />
           
        
            <input type="submit" name="submit" value="Cerca" />
        </form>

        <form  action="index.php" method="post" style="float:right">
			<input type="submit" value= "◄ Home">
		</form>


        <br><br>
        <hr>

        <?php 

            if ( $validInput ){
            
                if (   mysqli_num_rows($result) == 0  ){
                    printf ( '<font size="4", color="red", style="float:right"> Nessun risultato per <br> n. matricola <i> %s </i> </font><br>', $matricola );
                }

                else { ?>
                <div style="height: 40px; width: 300px; float:right;">
                        <table>
                            <tbody>
                                <thead>
                                    <th> </th>
                                    <th style="float:right"> Utente </th>
                                </thead>
                                <tr>
                                    <th> Matricola</th>
                                    <td><?php echo $matricola ?></td>
                                </tr>
                                <tr>
                                    <th>Nome</th>
                                    <td><?php echo $dati_stud['NOME'] ?></td>
                                </tr>
                                <tr>
                                    <th>Cognome</th>
                                    <td><?php echo $dati_stud['COGNOME'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
               <?php }?>          
            <div style="float:left">
                        <table >
                            <thead>
                                <tr> <th>ID Prestito</th> <th>Data Uscita</th> <th><th>ISBN</th><th>ID Libro</th></th> </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($result)) 
                                { ?> 
                                    <tr><td> <?php echo $row['ID_PRESTITO'] ?> </td>
                                        <td> <?php echo $row['DATA_USCITA'] ?></td> 
                                        <td> <td> <?php echo $row['ISBN'] ?></td><td> <?php echo $row['ID_LIBRO'] ?></td></td>
                                    </tr>
                                <?php 
                                } ?>
                            </tbody>
                        </table>
                    </div>
        <?php
                }
            else if ( isset($matricola) ){
        
                echo '<font size="4" style="float:right", color="red"> Attenzione, campo di ricerca vuoto </font><br><br>';              
            
            }
        
        ?>

    </body>

</html>


