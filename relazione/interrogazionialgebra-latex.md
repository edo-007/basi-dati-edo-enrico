

# Relazione Progetto Basi dati

Edoardo Ponsanesi 166205  
Enrico Albertini y636728


<!-- /code_chunk_output -->


&nbsp;   

&nbsp;   

&nbsp;   






## 1. Definizione del problema

Immagine Modello ER



Immagine schema Pre-Normalizzazione



I







## 2. Modello ER
     
![Modello ER](/relazione/immagini/image1.tmp)


## 3. Modello relazionale in terza forma normale 

![Modello ER](/relazione/immagini/image2.tmp)
![Modello ER](/relazione/immagini/image3.tmp)

    

## 4. Interrogazioni delle tracce in SQL con l' equivalente espressione scritta ia Algebra Relazionale 
 

__[1]__ 
Ricerca di un libro inserendo il titolo (anche parziale) - nel caso in cui nessun parametro venga specificato deve essere presentata la lista completa dei libri comprese le informazioni sintetiche del libro: titolo, isbn, in che succursale sono, ecc... (sintetiche - nome, cognome) sull’autore.

> `SELECT i.ISBN, i.TITOLO, i.LINGUA, s.NOME`  
`FROM ISBN_Info AS i, Libro as l, Succursale as s`  
`WHERE i.ISBN = l.ISBN AND i.TITOLO LIKE '%$nome_libro%'`  
`AND l.ID_S = s.ID_SUCC`  


$$ 
\rho_i (ISBN\_Info),~~ \rho_l (Libro),~~ \rho_s (Succursale) \\
\pi_{(ISBN,TITOLO,LINGUA,NOME)} (
    ISBN\_Info \Join_{~<i.ISBN = l.ISBN~\wedge~i.TITOLO = nome\_libro>} Libro \Join_{~<l.ID\_S = s.ID\_SUCC>} Succursale
)
$$ 

__[2]__ Visualizzazione di tutti i libri di un determinato autore, eventualmente suddivisi per anno di pubblicazione.


> ` SELECT i.TITOLO, i.ANNO_PUBBLICAZIONE, i.LINGUA, l.ISBN `  
` FROM Libro AS l, ISBN_Info AS i`  
` WHERE l.ISBN = i.ISBN `  
` AND l.ID_LIBRO IN ( SELECT ID_L FROM Scritto_Da WHERE ID_A = $id_autore)`  
` ORDER BY ANNO_PUBBLICAZIONE";`

$$
\rho_l(Libro),~~ \rho_l(Libro) \\
LIBRI\_AUTORE \leftarrow \pi_{<~ID\_L~>} (\sigma_{<~ID\_A~=~id\_autore~>} (Scritto\_Da)) \\  
INFO\_LIBRI \leftarrow Libro \Join_{~<~l.ISBN=i.ISBN~>} ISBN\_Info \Join_{<~ID\_L~=~ID\_LIBRO~>} LIBRI\_AUTORE \\
OUT \leftarrow \pi_{<~TITOLO,~ANNO\_PUBBLICAZIONE,~LINGUA,~ISBN~>} (INFO\_LIBRI) \\
$$
<br>

__[3]__   
Ricerca degli autori inserendo uno o più parametri (anche parziali), in forma libera o eventualmente guidata (per esempio menù a tendina con i soli valori possibili).

> `SELECT NOME, COGNOME, ID_AUTORE, DATA_NASCITA, PAESE_NASCITA`  
`FROM Autore`  
`WHERE NOME LIKE '$nome_a%' AND COGNOME LIKE '$cognome_a%'` 
`AND PAESE_NASCITA = $paese`  

$$
AUTORI\_RICHIESTI \leftarrow \sigma_{<~NOME=nome\_a~\wedge~COGNOME= cognome\_a~\wedge~PAESE\_NASCITA = paese~>}(~Autore~)\\ 
OUT \leftarrow \pi_{<NOME,~COGNOME,~ID\_AUTORE,~DATA\_NASCITA,~PAESE\_NASCITA>}( AUTORI\_RICHIESTI) \\
$$


<br>

__[4]__  
Consultare l’elenco degli utenti della biblioteca (con le informazioni principali).

> `SELECT NOME, COGNOME, MATRICOLA, NUMERO_TELEFONO`
`                FROM Studente`

$$
\pi_{<~NOME, COGNOME, MATRICOLA, NUMERO\_TELEFONO~> }(Studente)
$$

<br>


__[5]__  
Ricerca di un utente della biblioteca e il suo storico dei prestiti (compresi quelli in corso).

> `SELECT p.ID_PRESTITO, p.DATA_USCITA, s.COGNOME, l.ISBN, l.ID_LIBRO`  
`                    FROM Prestito AS p, Studente AS s, Libro AS l`  
`                            WHERE MATRICOLA = '$matricola' AND p.MATRICOLA_S = s.MATRICOLA`  
`                                                       AND p.ID_L = l.ID_LIBRO`  

$$
\rho_p(Prestito),~~ \rho_s(Studente), ~~ \rho_l(Libro) \\
JOIN\_PSL \leftarrow ~( Prestito )\Join_{~p.MATRICOLA = s.MATRICOLA~~\wedge~~ s.MATRICOLA=matricola}( Studente ) \Join_{~p.ID\_L = l.ID\_LIBRO} (Libro) \\
OUT \leftarrow \pi_{<~p.ID\_PRESTITO,~p.DATA\_USCITA,~s.COGNOME,~l.ISBN,~l.ID\_LIBRO~>} (JOIN\_PSL)
$$

<br>

__[6]__  
Consultare lo storico dei prestiti comprese le informazioni (sintetiche - nome, cognome) sull’utente.  

> `SELECT p.ID_PRESTITO,p.MATRICOLA_S, p.DATA_USCITA, s.NOME, s.COGNOME`  
`FROM Prestito AS p, Studente AS s`  
`WHERE p.MATRICOLA_S = s.MATRICOLA`  

$$
\rho_p(Prestito),~~ \rho_s(Studente) \\
PRESTITI\_UTENTE \leftarrow  (Prestito)~\Join_{~<~p.MATRICOLA = s.MATRICOLA~>} (Studente) \\ 
OUT \leftarrow ~\pi_{<~p.ID\_PRESTITO,p.MATRICOLA\_S,~p.DATA\_USCITA,~s.NOME,~s.COGNOME >} (PRESTITI\_UTENTE)
$$

<br>

__[7]__  
Ricerca dei prestiti effettuati in un range di date – nel caso in cui non vengano inserite date deve mostrare i prossimi in scadenza (quelli che scadranno in futuro) comprese le informazioni sintetiche sull’autore.

> `SELECT ID_PRESTITO, MATRICOLA_S, DATA_USCITA FROM Prestito`  
`WHERE DATA_USCITA >=  '$data_inizio' `  
`AND DATA_USCITA <= '$data_fine'`  

$$
IN\_RANGE \leftarrow \sigma_{~<~ DATA\_USCITA~\ge ~data\_inizio ~~\wedge~~DATA\_USCITA~\le~data\_fine~>}(Prestito) \\
OUT \leftarrow \pi_{<~ID\_PRESTITO, MATRICOLA\_S, DATA\_USCITA~>} (IN\_RANGE)
$$

<br>

__[8]__   
Statistiche  _(qui abbiamo deciso di utilizzare le join ( per completezza ))_

__[8.a]__ Numero di libri pubblicati in un determinato anno.

> `SELECT i.ANNO_PUBBLICAZIONE AS anno, COUNT(i.ISBN) AS numero_libri `  
`FROM ISBN_Info AS i`  
`GROUP BY i.ANNO_PUBBLICAZIONE`  
`ORDER BY i.ANNO_PUBBLICAZIONE`  

$$
OUT \leftarrow ANNO\_PUBBLICAZIONE~~\mathcal{F}~ANNO\_PUBBLICAZIONE,~COUNT_{ISBN} (\pi_{<ANNO\_PUBBLICAZIONE,~ISBN>}(ISBN\_Info)) 
\\ oppure~~(~penso  ~sia~la~stessa~cosa) \\
OUT \leftarrow ANNO\_PUBBLICAZIONE~~\mathcal{F}~ANNO\_PUBBLICAZIONE,~COUNT_{ISBN} (ISBN\_INFO)
$$


<br>

__[8.b]__ Numero di prestiti effettuati in una determinata succursale.  

> `SELECT s.NOME AS nome_succ, COUNT(p.ID_PRESTITO) AS numero_prestiti`  
`FROM Succursale s`  
`LEFT JOIN Libro l ON s.ID_SUCC = l.ID_S`  
`LEFT JOIN Prestito p ON l.ID_LIBRO = p.ID_L`  
`GROUP BY s.ID_SUCC` 

$$
JOIN\_LSP \leftarrow (Succursale)\Join_{LEFT<~s.ID\_SUCC=l.ID\_S~>}(Libro)\Join_{LEFT<~l.ID\_LIBRO=p.ID\_L~>}(Prestito) \\
%\pi_{<s.NOME, >}(JOIN\_LSP)
OUT \leftarrow s.ID\_SUCC~~\mathcal{F}~s.NOME,~COUNT_{p.ID\_PRESTITO}~(JOIN\_LSP)
$$

La __prima LEFT JOIN__ Questa parte esegue una LEFT JOIN tra Succursale e Libro (_sulle colonne ID_S e ID_SUCC rispettivamente_ ). Questa unione combina i dati delle succursali con i libri corrispondenti nella tabella "Libro". 
- Se non ci sono libri corrispondenti, la succursale sarà comunque inclusa nel risultato.

La __seconda LEFT JOIN__  Combina i dati di Libro con le istanze di Prestito corrispondente. 

- Se non ci sono prestiti corrispondenti per un libro, il libro sarà comunque incluso nel risultato.

Infinie la __GROUP_BY__ raggruppa il risultato per NOME (della succursale) e ID_SUCC.  
Possiamo quidni usare __COUNT__ per calcolare il numero di prestiti per ogni succursale.


<br>


__[8.c]__ Numero di libri pubblicati per autore.  

> `SELECT a.ID_AUTORE, a.NOME AS nome, a.COGNOME AS cognome, COUNT(L.ID_LIBRO) AS numero_libri `  
`FROM Autore a`  
`JOIN Scritto_Da sd ON a.ID_AUTORE = sd.ID_A`  
`JOIN Libro l ON SD.ID_L = l.ID_LIBRO`  
`GROUP BY a.ID_AUTORE`  

$$
JOIN\_ASL \leftarrow (Autore)\Join_{LEFT<~A.ID\_AUTORE = SD.ID\_A~>}(Scritto\_Da)\Join_{LEFT<~l.ID\_L=p.ID\_LIBRO~>}(Libro) \\
OUT \leftarrow ID\_AUTORE~~\mathcal{F}~ID\_AUORE,~NOME,~COGNOME,~COUNT_{ID\_LIBRO} (JOIN\_ASL)
$$

La __prima LEFT JOIN__ collega la tabella "Autore" con la tabella "Scritto_Da" utilizzando la condizione __A.ID_AUTORE = SD.ID_A__ . Questo collegamento ci consente di associare gli autori ai loro scritti.   
La __seconda "LEFT JOIN"__ (_tra ScrittoDa e Libro_) ci consente di associare ogni libro con i corrispettivi scrittori.

La clausola __GROUP BY__ raggruppa i risultati in base all'ID dell'autore, al nome e al cognome dell'autore. 
Posso ora calcolare il conteggio dei libri scritti da ciascun autore tramite la funzione di aggregazione __COUNT__.

- Utilizziamo la __left join__ invece che la __join naturale__ in modo tale che __tutti__ gli autori vengano inclusi nella query( _anche se non hanno scritto alcun libro_ ).  

- Gli autori che non hanno scritto alcun libro compariranno ugualmente nel risultato _( con numero libri = 0 )_.  

