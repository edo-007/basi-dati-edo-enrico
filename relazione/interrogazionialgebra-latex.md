

# Relazione Progetto Basi dati

__Edoardo Ponsanesi__ [166205]  
__Enrico Albertini__ [165672]



## 1. Definizione del problema

Ci è stata commissionata la costruzione di un sistema di gestione di una biblioteca, formata da una serie di succursali dell' università di ferrara.
Ciò è stato implementato in html/php per l'interfaccia web dinamica che dialoga con un database MySQL contenente i dati. 





## 2. Modello ER
     
![Modello ER](/relazione/immagini/image.png)


## 3. Modello relazionale in terza forma normale 

![Modello ER](/relazione/immagini/image2.tmp)

Abbiamo ritenuto opportuno riportare lo schema che sarebbe emerso naturalmente da un’osservazione non articolata dal punto di vista dei database, quindi non al corrente dei rischi di design legati alle dipendenze funzionali. LE DIPENDENZE FUNZIONALI SONO MOSTRATE SECONDO I COLORI DEL DIAGRAMMA, EVITIAMO DI RIPETERLE IN FORMA TESTUALE QUA PER EVITARE INUTILI RIDONDANZE.
Bisogna notare che:
- In PRESTITO:
DataScadenza è T.F.D.(Transitivamente Funzionalmente Dipendente) da ID_Prestito, viene inclusa nello schema perché è concettualmente un campo di prestito, ma nella
realtà non viola la terza forma normale perché non è un campo effettivo, ma viene calcolato al bisogno da DataUscita(unico dei due mantenuto effettivamente nel DB)

![Modello ER](/relazione/immagini/image3.tmp)

Abbiamo dunque rimosso tutte le __D.F.T.__ (_Dipendenze Funzionali Transitive_), ottenendo lo schema in __3NF__. 
A eccezione del CAP(funzionalmente dipendente da Via,Civico,Città ), in un contesto implementativo generale), QUESTO E’ VOLUTO COME SCELTA DI DESIGN, IN FUNZIONE DEL DOMINIO DI APPLICAZIONE DEL PRODOTTO RICHIESTO. Infatti realizzare schema, compliant alla non-DFT del CAP, avrebbe implicato di avere un database con tutte le vie della città di Ferrara, cosa che non è stata fornita. Quindi tecnicamente il CAP è solo un’altro attributo che va a costituire l’attributo composto dell’indirizzo con CAP.

    

## 4. Interrogazioni delle tracce in SQL con l' equivalente espressione scritta ia Algebra Relazionale 
 

__[1]__ 
Ricerca di un libro inserendo il titolo (anche parziale) - nel caso in cui nessun parametro venga specificato deve essere presentata la lista completa dei libri comprese le informazioni sintetiche del libro: titolo, isbn, in che succursale sono, ecc... (sintetiche - nome, cognome) sull’autore.

> `SELECT i.ISBN, i.TITOLO, i.LINGUA, s.NOME`  
`FROM ISBN_Info AS i, Libro as l, Succursale as s`  
`WHERE i.ISBN = l.ISBN AND i.TITOLO LIKE '%$nome_libro%'`  
`AND l.ID_S = s.ID_SUCC`  


$$ 
\rho_i (ISBN\_Info),~~ \rho_l (Libro),~~ \rho_s (Succursale) \\
OUT \leftarrow \pi_{(ISBN,TITOLO,LINGUA,NOME)} (
    ISBN\_Info \Join_{~<i.ISBN = l.ISBN~\wedge~i.TITOLO = \%nome\_libro\%>} Libro \Join_{~<l.ID\_S = s.ID\_SUCC>} Succursale
)
$$ 

__[2]__ Visualizzazione di tutti i libri di un determinato autore, eventualmente suddivisi per anno di pubblicazione.


> ` SELECT i.TITOLO, i.ANNO_PUBBLICAZIONE, i.LINGUA, l.ISBN `  
` FROM Libro AS l, ISBN_Info AS i`  
` WHERE l.ISBN = i.ISBN `  
` AND l.ID_LIBRO IN ( SELECT sd.ID_L FROM Scritto_Da AS sd WHERE sd.ID_A = $id_autore)`  
` ORDER BY i.ANNO_PUBBLICAZIONE";`

$$
\rho_l(Libro),~~ \rho_i(ISBN\_Info), ~~ \rho_{sd}(Scritto\_Da) \\
\rho_{da\_cercare}(~\pi_{<~sd.ID\_L~>} (\sigma_{<~sd.ID\_A~=~id\_autore~>} (Scritto\_Da))~)\\  
-\\
INFO\_LIBRI \leftarrow ISBN\_Info \Join_{~<~l.ISBN=i.ISBN~>} Libro \Join_{<~l.ID\_LIBRO~=~da\_cercare.ID\_L~>} LIBRI\_AUTORE \\
OUT \leftarrow \pi_{<~i.TITOLO,~i.ANNO\_PUBBLICAZIONE,~i.LINGUA,~i.ISBN~>} (INFO\_LIBRI) \\
$$
<br>

__[3]__   
Ricerca degli autori inserendo uno o più parametri (anche parziali), in forma libera o eventualmente guidata (per esempio menù a tendina con i soli valori possibili).

> `SELECT NOME, COGNOME, ID_AUTORE, DATA_NASCITA, PAESE_NASCITA`  
`FROM Autore`  
`WHERE NOME LIKE '%$nome_a%' AND COGNOME LIKE '%$cognome_a%'` 
`AND PAESE_NASCITA = $paese`  

$$
AUTORI\_RICHIESTI \leftarrow \sigma_{<~NOME=\%nome\_a\%~\wedge~COGNOME= \%cognome\_a\%~\wedge~PAESE\_NASCITA = paese~>}(~Autore~)\\ 
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

Vista la necessità di istruzioni condizionali per la costruzione della query che soddisfi la richiesta, mostriamo solo il caso base.
<br>

__[8]__   
Statistiche  _(qui abbiamo deciso di utilizzare le join ( per completezza ))_

__[8.a]__ Numero di libri pubblicati in un determinato anno.

> `SELECT i.ANNO_PUBBLICAZIONE AS anno, COUNT(i.ISBN) AS numero_libri `  
`FROM ISBN_Info AS i`  
`GROUP BY i.ANNO_PUBBLICAZIONE`  
`ORDER BY i.ANNO_PUBBLICAZIONE`  

$$
OUT \leftarrow ANNO\_PUBBLICAZIONE~~\mathcal{F}~COUNT_{ISBN} (\pi_{<ANNO\_PUBBLICAZIONE,~ISBN>}(ISBN\_Info)) \\-\\
% OUT \leftarrow ANNO\_PUBBLICAZIONE~~\mathcal{F}~ANNO\_PUBBLICAZIONE,~COUNT_{ISBN} (ISBN\_INFO)
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
OUT \leftarrow s.ID\_SUCC~~\mathcal{F}~COUNT_{p.ID\_PRESTITO}~(JOIN\_LSP)
$$


<br>


__[8.c]__ Numero di libri pubblicati per autore.  

> `SELECT a.ID_AUTORE, a.NOME AS nome, a.COGNOME AS cognome, COUNT(L.ID_LIBRO) AS numero_libri `  
`FROM Autore a`  
`JOIN Scritto_Da sd ON a.ID_AUTORE = sd.ID_A`  
`JOIN Libro l ON SD.ID_L = l.ID_LIBRO`  
`GROUP BY a.ID_AUTORE`  

$$
\rho_a(Autore),~~ \rho_{sd}(Scritto\_Da),~~ \rho_l(Libro) \\
JOIN\_ASL \leftarrow (Autore)\Join_{<~a.ID\_AUTORE = sd.ID\_A~>}(Scritto\_Da)\Join_{<~l.ID\_L=p.ID\_LIBRO~>}(Libro) \\
OUT \leftarrow ID\_AUTORE~~\mathcal{F}~COUNT_{l.ID\_L} (JOIN\_ASL)
$$


