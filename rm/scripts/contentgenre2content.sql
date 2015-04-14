DROP TABLE IF EXISTS Blog2Genre;
CREATE TABLE Blog2Genre
(
  idContent INT NOT NULL,
  idGenre INT NOT NULL,
 
  FOREIGN KEY (idContent) REFERENCES Content (id),
  FOREIGN KEY (idGenre) REFERENCES ContentGenre (id),
 
  PRIMARY KEY (idContent, idGenre)
) ENGINE INNODB;
 
 
INSERT INTO Blog2Genre (idContent, idGenre) VALUES
  (3, 4)
;