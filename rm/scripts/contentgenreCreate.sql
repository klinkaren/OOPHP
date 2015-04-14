--
-- Add tables for genre
--
DROP TABLE IF EXISTS ContentGenre;
CREATE TABLE ContentGenre
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name CHAR(20) NOT NULL -- crime, svenskt, college, drama, etc
) ENGINE INNODB CHARACTER SET utf8;
 
INSERT INTO ContentGenre (name) VALUES 
  ('skådespelare'), ('skvaller'),
  ('film'), ('RM'), ('krönika'), 
  ('klipp'), ('tävling'), ('trailer')
;

SELECT * FROM contentgenre;