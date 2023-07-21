<?php
    // Connessione 

    try {
        // Connessione 
        $link = mysqli_connect("127.0.0.1", "ITO1", "password", "Biblioteca");
    } catch (mysqli_sql_exception $e) {
        die("Non posso stabilire la connessione al db: " . $e->getMessage());
    }


    // Controllo se è avvenuta la connessione al database:
    if (!$link) {
        echo "Si è verificato un errore: Non riesco a collegarmi al database <br/>";
        echo "Codice errore: " . mysqli_connect_errno() . "<br/>";
        echo "Messaggio errore: " . mysqli_connect_error() . "<br/>";
        exit;
    }
    
?>