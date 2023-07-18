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


-- (3,'Titolo del libro','068254989-4','English',2014,8);
CREATE TABLE Libro (
    
    ID_LIBRO       		INT,

    ISBN                CHAR(11),
    ID_S 				INT,
    FOREIGN KEY(ID_S) REFERENCES Succursale(ID_SUCC),
    FOREIGN KEY(ISBN) REFERENCES ISBN_Info(ISBN),
    
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

    FOREIGN KEY (ID_L) REFERENCES Libro(ID_LIBRO),
    FOREIGN KEY (ID_A) REFERENCES Autore(ID_AUTORE),
    
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

    FOREIGN KEY (ID_L) REFERENCES Libro(ID_LIBRO),
    FOREIGN KEY (MATRICOLA_S) REFERENCES Studente(MATRICOLA),

    PRIMARY KEY (ID_PRESTITO)
);

