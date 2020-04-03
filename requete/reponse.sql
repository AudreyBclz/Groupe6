-- 1 --
SELECT  products.name,
        products.model_year,
        products.price,
        categories.nameCat,
        brands.brand_name
FROM products
INNER JOIN categories ON products.category_id = categories.idCat
INNER JOIN brands ON products.brand_id = brands.brand_id
WHERE brands.brand_name = "Haro"
AND categories.nameCat = "Electric Bikes";


-- 2 --
SELECT     products.name,
           products.model_year,
           categories.nameCat,
           brands.brand_name,
           products.price AS PrixHT,
           CAST(products.price*0.2 as DECIMAL(9,2)) AS TVA,
           CAST(products.price*1.2 as DECIMAL(9,2)) AS PrixTTC
FROM products
         INNER JOIN categories ON products.category_id = categories.idCat
         INNER JOIN brands ON products.brand_id = brands.brand_id



-- 3 --
SELECT *
FROM products
WHERE products.price BETWEEN 500 AND 1500


-- 4 --
SELECT  products.name,
        products.model_year,
        products.price,
        brands.brand_name
FROM products
         INNER JOIN brands ON products.brand_id=brands.brand_id
WHERE brands.brand_name LIKE 'H%'


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



