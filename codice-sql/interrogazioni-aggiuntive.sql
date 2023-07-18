-- a. Numero di libri pubblicati in un determinato anno.

				SELECT i.ANNO_PUBBLICAZIONE, COUNT(l.ID_LIBRO)
					FROM Libro AS l, ISBN_Info AS i 
						WHERE i.ISBN = l.ISBN AND i.ANNO_PUBBLICAZIONE
							GROUP BY (i.ANNO_PUBBLICAZIONE);
						
-- b. Numero di prestiti effettuati in una determinata succursale.

				SELECT s.NOME AS Nome_Succursale, COUNT(p.ID_PRESTITO) AS Numero_Prestiti
					FROM Succursale s
						LEFT JOIN Libro l ON s.ID_SUCC = l.ID_S
							LEFT JOIN Prestito p ON l.ID_LIBRO = p.ID_L
								GROUP BY s.NOME, s.ID_SUCC;
								
-- c. Numero di libri pubblicati per autore.

				SELECT A.ID_AUTORE, A.NOME AS Nome, A.COGNOME AS Cognome, COUNT(L.ID_LIBRO) AS Numero_Pubblicati
					FROM Autore A
						LEFT JOIN Scritto_Da SD ON A.ID_AUTORE = SD.ID_A
							LEFT JOIN Libro L ON SD.ID_L = L.ID_LIBRO
								GROUP BY A.ID_AUTORE, A.NOME, A.COGNOME;
				
