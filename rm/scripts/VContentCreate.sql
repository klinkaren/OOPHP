DROP VIEW IF EXISTS VContent;
 
CREATE VIEW VContent
AS
SELECT 
  C.*,
  GROUP_CONCAT(G.name) AS genre
FROM content AS C
  LEFT OUTER JOIN blog2genre AS B2G
    ON C.id = B2G.idContent
  LEFT OUTER JOIN contentgenre AS G
    ON B2G.idGenre = G.id
WHERE C.TYPE = "post"
GROUP BY C.id
;
 
SELECT * FROM VContent;