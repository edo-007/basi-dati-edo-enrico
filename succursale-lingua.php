
<?php 

    include_once('connessione.php'); 

// succursali ordinate per numero di libri in una determinata lingua
    $lingua =$_POST["lingua"];
    echo "<h1>$lingua</h1>";
    $sql = "select S.NOME, S.VIA, S.CIVICO, COUNT(L.ID_LIBRO)
	    FROM Succursale as S, Libro as L, ISBN_Info I
		    WHERE L.ID_S = S.ID_SUCC AND I.ISBN = L.ISBN AND I.LINGUA = \"$lingua\"
			    GROUP BY S.ID_SUCC";

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
		        
		<title></title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}
		</style>
    </head>
    
    <body>
		<h2> Nr di Libri in <?php echo $lingua;?></h2> 
        
        <table>
            <thead>
                <tr> <th>ID Succursale</th> <th>Via</th> <th>Civico</th><th>Nr. Libri in</th> </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($result) and $i<=5) 
                {$i++; ?> 
                    <tr><td> <?php echo $row[0] ?></td>
                        <td> <?php echo $row[1] ?></td> 
                        <td> <?php echo $row[2] ?></td> 
                        <td> <?php echo $row[3] ?></td> 
                    </tr>
                <?php 
                } 
                if($i < 5){
                    echo "<br>abbiamo solo la top $i delle facoltà con libri in $lingua, visto che essi sono presenti solo il $i facoltà";
                }
                ?>

                <form  action="index.php" method="post">
				    <input type="submit" value= "◄ Home">
		        </form>
                
            </tbody>
        </table>        

    </body>

</html>


