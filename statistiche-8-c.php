
<?php 


include_once('connessione.php'); 



// c. Numero di libri pubblicati per autore.
        $sql = "SELECT A.ID_AUTORE, A.NOME AS nome, A.COGNOME AS cognome, COUNT(L.ID_LIBRO) AS numero_libri 
                    FROM Autore A
                        LEFT JOIN Scritto_Da SD ON A.ID_AUTORE = SD.ID_A
                            LEFT JOIN Libro L ON SD.ID_L = L.ID_LIBRO
                                GROUP BY A.ID_AUTORE, A.NOME, A.COGNOME";

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

        <h2> Numero libri per autore </h2> 
        
        <table>
            <thead>
                <tr> <th>Nome</th> <th>Cognome</th> <th>Numero libri</th> </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) 
                { ?> 
                    <tr>
                        <td> <?php echo $row['nome'] ?> </td>
                        <td> <?php echo $row['cognome'] ?> </td>
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

    
    