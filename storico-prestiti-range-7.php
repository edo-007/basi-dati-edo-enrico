<?php 

//    7. Ricerca dei prestiti effettuati in un range di date – nel caso in cui non vengano
//    inserite date deve mostrare i prossimi in scadenza (quelli che scadranno in futuro)
   
    $data_inizio = null;
    $data_fine = null;

    include_once('connessione.php');     

    
    $print_table = 0;

    // Osserva che dopo la prima chiamata ricorsiva della 
    // pagina i parametri si settano automaticamente

    if ( isset($_POST['data_inizio']) || isset($_POST['data_fine']) ){ 
        
        $data_inizio = $_POST['data_inizio'];
        $data_fine = $_POST['data_fine'];

        $print_table = 1;                       // Allora stampo la tabella




        // Entrambe vuote 
        $sql = "SELECT ID_PRESTITO, MATRICOLA_S, DATA_USCITA FROM Prestito";

        if ( !empty($data_inizio) && !empty($data_fine) ){

            $sql = $sql." WHERE DATA_USCITA >=  '$data_inizio' 
                                    AND DATA_USCITA <= '$data_fine' ;";
        }

        else if ( !empty($data_inizio) ){

            $data_fine = "Non specificato";
            $sql = $sql." WHERE DATA_USCITA >= '$data_inizio';";
        }
        
        else if ( !empty($data_fine)){
            $data_inizio = "Non specificato";
            $sql = $sql." WHERE DATA_USCITA <= '$data_fine';";
        }
        else {

            $data_fine = "Non specificato";
            $data_inizio = "Non specificato";
            $sql = $sql." WHERE DATE_ADD( DATA_USCITA , INTERVAL 1 month ) >= NOW();";
        }
      
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo "Si è verificato un errore: " . mysqli_error($link);
            exit;
            }
            mysqli_close($link);   
        }
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

        <h2> Ricerca Prestiti in range di date </h2>
        <p> 
            Se <b>entrambe le date sono inserite</b>, verrà restituita la lista dei prestiti in tale intervallo. <br> Se <b>nessuna delle date</b> viene inserita
            saranno restituiti i prestiti prossimi in scadenza ( <i>ovvero quelli non ancora scaduti</i> ). <br>
            Se <b>una sola delle due date</b> è inserita, allora si terrà conto unicamente di tale estremo.
        </p>

        <form  action="index.php" method="post">
            <input type="submit" value= "◄ Home">
        </form>
        <br>
        <hr>
        <br>
        
        <div style="float:left;">
            <form  action="storico-prestiti-range-7.php" method="post">
                
                <label> <b>Data Inizio </b> </label>
                <input type="date" name="data_inizio">
                <br>
                <label> <b>Data Fine</b> </label>	
                <input type="date" name="data_fine">
                
                <input type="submit" value= "Cerca">
            </form>
        </div>
        <?php if ($print_table) { ?>

            <div style="float:right; width:80%"  >

                <table>
                    <thead>
                        <tr> <th>ID Prestito</th> <th>Matricola</th> <th>Data Inizio</th> </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($result)){ ?>
                            <tr> 
                                <td><?php echo $row['ID_PRESTITO'] ?></td> 
                                <td><?php echo $row['MATRICOLA_S'] ?></td>
                                <td><?php echo $row['DATA_USCITA'] ?></td>
                            </tr>
                            
                            <?php } ?>
                    </tbody>
                </table>
                <br>
                <table style="width:30%; border: 1px solid black; float:right">
                    <tr> <td>Da:</td> <td> <i><?php echo $data_inizio ?></i> </td></tr> 
                    <tr> <td>a: </td><td> <i><?php echo $data_fine ?></i> </td></tr>    
                </table>
            
            </div>
            
        <?php } ?>

    </body>

</html>


