DROP SCHEMA Biblioteca;
CREATE SCHEMA Biblioteca;
use Biblioteca;

CREATE TABLE Succursale (

    ID_SUCC             INT,
    NOME                VARCHAR(55),
-- Indirizzo
    VIA                 VARCHAR(155),
    CIVICO              VARCHAR(6),
    CAP                 INT,
    CITTA               VARCHAR(55),
    
    PRIMARY KEY (ID_SUCC)
);


CREATE TABLE ISBN_Info (

    ISBN                CHAR(11),
    TITOLO              VARCHAR(255),
    LINGUA              VARCHAR(20),
    ANNO_PUBBLICAZIONE  INT,

    PRIMARY KEY (ISBN)

);

CREATE TABLE Libro (
    
    ID_LIBRO       		INT,

    ISBN                CHAR(11),
    ID_S 				INT,
    
    #visto che può essere rimossa una succursale, ma il libro continuerebbe a esistere
    FOREIGN KEY(ID_S) REFERENCES Succursale(ID_SUCC) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY(ISBN) REFERENCES ISBN_Info(ISBN) ON DELETE CASCADE ON UPDATE CASCADE,
    
    PRIMARY KEY (ID_LIBRO)

);




-- (8,'Raquel','Semered',1972-03-21,'Bloomington')
CREATE TABLE Autore (
    
    ID_AUTORE                 INT,
    NOME                VARCHAR(50),
    COGNOME             VARCHAR(50),
    DATA_NASCITA        DATE,
    PAESE_NASCITA       VARCHAR(50),

    PRIMARY KEY (ID_AUTORE)
);


CREATE TABLE Scritto_Da (
    
    ID_REL				INT,

    ID_L	            INT,			-- Chiave esterna su Libro
    ID_A	            INT,			-- Chiave esterna su autore

    FOREIGN KEY (ID_L) REFERENCES Libro(ID_LIBRO) ON DELETE CASCADE ON UPDATE CASCADE,
    # un libro non smette di esistere se per sbaglio qualcuno elimina un autore, il libro è il portagonista della biblioteca, 
    # l_autore una informazione su di esso
    FOREIGN KEY (ID_A) REFERENCES Autore(ID_AUTORE) ON DELETE SET NULL ON UPDATE CASCADE,
    
    PRIMARY KEY (ID_REL)
);

 -- (6,'Matematica e informatica,Via Machiavelli',30,44121,'Ferrara')



CREATE TABLE Studente (

    MATRICOLA           CHAR(6),
    NOME                VARCHAR(55) NOT NULL,
    COGNOME             VARCHAR(55) NOT NULL,
-- Indirizzo
    VIA                 VARCHAR(155),
    CIVICO              VARCHAR(6),
    CAP                 CHAR(5),
    CITTA               VARCHAR(55),

    NUMERO_TELEFONO     CHAR(10),
    
    PRIMARY KEY (MATRICOLA)
);

CREATE TABLE Prestito (

    ID_PRESTITO         INT AUTO_INCREMENT,
    
    MATRICOLA_S         CHAR(6)  NOT NULL,						-- MATRICOLA STUDENTE
    ID_L              	INT,      	  							-- ID LIBRO
    DATA_USCITA         DATE,

    FOREIGN KEY (ID_L) REFERENCES Libro(ID_LIBRO) ON DELETE CASCADE ON UPDATE CASCADE ,
    FOREIGN KEY (MATRICOLA_S) REFERENCES Studente(MATRICOLA) ON DELETE CASCADE ON UPDATE CASCADE,

    PRIMARY KEY (ID_PRESTITO)
);

