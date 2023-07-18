# progetto-basi-dati

diagramma:  https://app.diagrams.net/#G1V2P0DXLew3GbGWP85PZ0ZutnbpHtl_Qt    

## 1. Progettare, realizzare e preparare la base dati

- **Ricavare il diagramma ER**.  
- **Ricavare lo schema relazionale in terza forma normale (3NF).**   
- **Costruire gli script SQL necessari per**:  

> - Creare il database con le relative tabelle facendo attenzione ai tipi di dato.  
> - Ricavare il contenuto di alcune tabelle dalle informazioni date (link, file CSV, ecc …).  
> - Inserire i dati ricavati al punto b all’interno delle tabelle del database.  

**Inserire anche alcuni prestiti**.  

## 2. pagine HTML/PHP

**1**  
Ricerca di un libro inserendo il titolo (anche parziale) - nel caso in cui nessun parametro venga specificato deve essere presentata la lista completa dei libri comprese le informazioni sintetiche del libro: titolo, isbn, in che succursale sono, ecc…  (sintetiche - nome, cognome) sull’autore. 

**2**  
Visualizzazione di tutti i libri di un determinato autore, eventualmente suddivisi per  anno di pubblicazione.

**3**  
Ricerca degli autori inserendo uno o più parametri (anche parziali), in forma libera o eventualmente guidata (per esempio menù a tendina con i soli valori possibili). 

**4**  
Consultare l’elenco degli utenti della biblioteca (con le informazioni principali).

**5**  
Ricerca di un utente della biblioteca e il suo storico dei prestiti (compresi quelli in corso). 

**6**  
Consultare lo storico dei prestiti comprese le informazioni (sintetiche - nome, cognome) sull’utente.

**7**  
Ricerca dei prestiti effettuati in un range di date – nel caso in cui non vengano inserite date deve mostrare i prossimi in scadenza (quelli che scadranno in futuro) comprese le informazioni sintetiche sull’autore.

**8**  
Calcolo di statistiche relative a libri e autori: 

- Numero di libri pubblicati in un determinato anno.  
- Numero di prestiti effettuati in una determinata succursale.   
- Numero di libri pubblicati per autore.  

**avviare il server php**
php -S localhost:8000