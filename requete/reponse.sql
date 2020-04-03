-- 1 --
SELECT name, model_year, price,nameCat,brand_name
FROM products AS prod, categories AS cat, brands AS br
WHERE br.brand_name="Haro"
AND cat.nameCat="Electric Bikes"


-- 2 --
SELECT
	prod.name,
    prod.model_year,
    prod.price,
    cat.nameCat,
    br.brand_name,
    ROUND(prod.price*0.2,2) AS MontantTVA,
    ROUND(prod.price*1.2,2) AS PrixTTC
FROM products AS prod, categories AS cat, brands AS br
WHERE br.brand_name="Haro"
AND cat.nameCat="Electric Bikes"


-- 3 --
SELECT prod.name
FROM products AS prod
WHERE prod.price >=500
AND prod.price<=1500


-- 4 --
SELECT prod.name, prod.model_year, prod.price
FROM products AS prod, brands AS br
WHERE br.brand_name LIKE 'H%'


-- 5 --
SELECT prod.name, prod.model_year, prod.price
FROM products AS prod
WHERE prod.name LIKE '%lce%' -- Je ne savais pas si c'était un l ou un i, je trouve une occurence avec lce --


-- 6 --
DELETE
FROM products
WHERE products.brand_id= (SELECT brands.brand_id FROM brands WHERE brands.brand_name="Trek");


-- 7 --
DELETE
FROM products
WHERE products.category_id= (SELECT categories.idCat FROM categories WHERE categories.nameCat="Mountain Bikes");


-- 8 --
UPDATE products
SET products.price=1499 WHERE products.id=9; -- Il n'y a pas de produit avec id 9 dans la DB --


-- 9 --
INSERT INTO categories (nameCat)
VALUES ('Roller skates')


-- 10 --
INSERT INTO products(products.name,products.brand_id,products.category_id,products.model_year,products.price)
VALUES('roller skates cool',
        (SELECT brands.brand_id FROM brands WHERE brands.brand_name="Haro"),
        (SELECT categories.idCat FROM categories WHERE categories.nameCat="Roller skates"),
        2020,
        258);

;



