SELECT DISTINCT G.name, G.id
FROM Genre AS G
  INNER JOIN Movie2Genre AS M2G
    ON G.id = M2G.idGenre
    GROUP BY G.name ASC