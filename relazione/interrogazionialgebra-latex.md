

## Relazione Progetto Basi dati

Edoardo Ponsanesi 166205
Enrico Albertini y636728

Per quanto riguarda la relazione, il minimo che viene richiesto è quello di includere:  

> 1. Definizione del problema;  
> 2. Modello ER;  
> 3. Modello Relazionale in terza forma normale con tutti i vincoli per, e tra, le varie relazioni risultanti;  
> 4. Le interrogazioni delle tracce (al punto 2), in SQL con l’equivalente espressione scritta in Algebra Relazionale (senza usare l’operatore di divisione);


* * *

__1__ Ricerca di un libro inserendo il titolo (anche parziale) - nel caso in cui nessun
parametro venga specificato deve essere presentata la lista completa dei libri
comprese le informazioni sintetiche del libro: titolo, isbn, in che succursale sono,
ecc... (sintetiche - nome, cognome) sull’autore.

> `SELECT i.ISBN, i.TITOLO, i.LINGUA, s.NOME`  
`FROM ISBN_Info AS i, Libro as l, Succursale as s`  
`WHERE i.ISBN = l.ISBN AND i.TITOLO LIKE '%$nome_libro%'`  
`AND l.ID_S = s.ID_SUCC`  



__2__ Visualizzazione di tutti i libri di un determinato autore, eventualmente suddivisi per
anno di pubblicazione.


> ` SELECT i.TITOLO, i.ANNO_PUBBLICAZIONE, i.LINGUA, l.ISBN `  
` FROM Libro AS l, ISBN_Info AS i`  
` WHERE l.ISBN = i.ISBN `  
` AND l.ID_LIBRO IN ( SELECT ID_L FROM Scritto_Da WHERE ID_A = $id_autore)`  
` ORDER BY ANNO_PUBBLICAZIONE";`  


__3__ Ricerca degli autori inserendo uno o più parametri (anche parziali), in forma libera o
eventualmente guidata (per esempio menù a tendina con i soli valori possibili).

> `SELECT NOME, COGNOME, ID_AUTORE, DATA_NASCITA, PAESE_NASCITA`  
`FROM Autore`  
`WHERE NOME LIKE '$nome_a%' AND COGNOME LIKE '$cognome_a%'` 
`AND PAESE_NASCITA = $paese`  

__4__ Consultare l’elenco degli utenti della biblioteca (con le informazioni principali).

> `SELECT NOME, COGNOME, MATRICOLA, NUMERO_TELEFONO`
`                FROM Studente`

__5__ Ricerca di un utente della biblioteca e il suo storico dei prestiti (compresi quelli in
corso).

> `SELECT p.ID_PRESTITO, p.DATA_USCITA, s.COGNOME, l.ISBN, l.ID_LIBRO`  
`                    FROM Prestito AS p, Studente AS s, Libro AS l`  
`                            WHERE MATRICOLA = '$matricola' AND p.MATRICOLA_S = s.MATRICOLA`  
`                                                       AND p.ID_L = l.ID_LIBRO`  

__6__ Consultare lo storico dei prestiti comprese le informazioni (sintetiche - nome,
cognome) sull’utente.  

> `SELECT p.ID_PRESTITO,p.MATRICOLA_S, p.DATA_USCITA, s.NOME, s.COGNOME`  
`FROM Prestito AS p, Studente AS s`  
`WHERE p.MATRICOLA_S = s.MATRICOLA`  

__7__ Ricerca dei prestiti effettuati in un range di date – nel caso in cui non vengano
inserite date deve mostrare i prossimi in scadenza (quelli che scadranno in futuro)
comprese le informazioni sintetiche sull’autore.

> `SELECT ID_PRESTITO, MATRICOLA_S, DATA_USCITA FROM Prestito`  
`WHERE DATA_USCITA >=  '$data_inizio' `  
`AND DATA_USCITA <= '$data_fine'`  

8. Calcolo di statistiche relative a libri e autori:
a. Numero di libri pubblicati in un determinato anno.
b. Numero di prestiti effettuati in una determinata succursale.
c. Numero di libri pubblicati per autore.

(1)


$ $