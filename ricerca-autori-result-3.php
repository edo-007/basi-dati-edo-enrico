<?php 
	include_once('connessione.php'); 	

    $nome_a = $_POST['nome_autore'];		
    $cognome_a = $_POST['cognome_autore'];
    $paese_a = $_POST['paese_autore'];

    // AND PAESE_NASCITA = '$paese_a'
    // echo $nome_a." (nome) <br>";
    // echo $cognome_a." (cognome) <br>";
    // echo $paese_a." (paese) <br>";
    
    $empty_input = 0;
    if ( empty($nome_a) && empty($cognome_a) && ( $paese_a == '__all__') )  {

        $empty_input = 1;   // Se tutti i parametri inseriti sono nulli 
        echo  '<font size="4", color="red", style="float:right"> Attenzione, si rihiede di inserire <b>almeno</b> un parametro tra <b>Nome</b>, <b>Cognome</b> e <b>Paese</b> </font><br>';
    }

    $sql= "SELECT NOME, COGNOME, ID_AUTORE, DATA_NASCITA, PAESE_NASCITA
                FROM Autore
                    WHERE NOME LIKE '%$nome_a%' AND COGNOME LIKE '%$cognome_a%' ";

    // Nel caso venga specificato anche il paese di nascita si aggiunge una clausola alla query 
    if ( $paese_a != '__all__')                            
        $sql = $sql."AND PAESE_NASCITA = '$paese_a'";
    


	$result = mysqli_query($link, $sql);
	if (!$result) {
		echo "Si è verificato un errore: " . mysqli_error($link);
		exit;
	}
    $empty_output = 0;
    if (  mysqli_num_rows($result) == 0 ){
        $empty_output = 1;
        echo  '<font size="4", color="red", style="float:right"> Nessun autore corrispondente trovato </font><br><hr>';
    }


    

?>


<!DOCTYPE html>

<html lang="it">
    <head>
        <meta charset="utf-8">
		        
		<title>Ricerca Autori</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}
		</style>
    </head>
    
    <body>

        <h2> Ricerca Autore </h2>

        <form  action="ricerca-autori-3.php" method="post">
                <input type="submit" value= "Continua la ricerca">
        </form>
        <form  action="index.php" method="post">
            <input type="submit" value= "◄ Home">
        </form>
        
        <?php if (!$empty_input && !$empty_output){ 

                if ( empty($nome_a)) $nome_a = '<i>Non specificato</i>';
                if ( empty($cognome_a)) $cognome_a = '<i>Non specificato</i>';
                if ( $paese_a == '__all__' ) $paese_a = '<i>Non specificato</i>';
            ?>

            <table>

                <thead>
                    <tr> <th>Nome</th> <th>Cognome</th>  <th><th>Data Nascita</th> <th>Paese Nascita</th> </th></tr>
                </thead>

                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result)) 
                    { ?> 
                        <tr>
                            <td> <?php echo $row['NOME'] ?> </td> 
                            <td> <?php echo $row['COGNOME'] ?> </td>
                            <td> <td> <?php echo $row['DATA_NASCITA'] ?> </td>  <td> <?php echo $row['PAESE_NASCITA'] ?> </td></td>
                            
                            
                        </tr>
                        <?php 
                    } ?>
                </tbody>
                <br>
                </table>

                <br>
                <p style="font-size:18px; float:center;">Risultati per la ricerca: </p>

                <div style="height:20px; width: 300px;">
                    <table>
                        <tr> <td>Nome </td> <td> <?php echo $nome_a ?> </td> <tr>
                        <tr> <td>Cognome </td> <td> <?php echo $cognome_a ?> </td> <tr>
                        <tr> <td>Paese </td> <td> <?php echo $paese_a ?> </td> <tr>
                    </table>
                </div>
            <?php } ?>


    </body>
</html>
