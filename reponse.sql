-- 1 --
SELECT *
FROM products AS prod, categories AS cat, brand AS br
WHERE br.brand_name="Haro"
AND cat.category_name="Electric Bikes"
AND br.brand_id=prod.brand_id
AND cat.category_id=prod.category_id;


-- 2 --
SELECT *
FROM products AS prod, categories AS cat, brand AS br
WHERE br.brand_name="Haro"
AND cat.category_name="Electric Bikes"
AND br.brand_id=prod.brand_id
AND cat.category_id=prod.category_id
AND prod.list_price * 0.2 AS MONTANT_TVA,
AND SUM(prod.list_price,MONTANT_TVA) AS pTTC;


-- 3 --
SELECT prod.product_name, prod.list_price
FROM products AS prod
WHERE prod.list_price >=500
AND prod.list_price<=1500;


-- 4 --
SELECT prod.product_name, prod.model_year, prod.list_price, br.brand_name
FROM products AS prod, brand AS br
WHERE br.brand_name LIKE 'H%';


-- 5 --
SELECT prod.product_name, prod.model_year, prod.list_price
FROM products AS prod, brand AS br
WHERE prod.product_name LIKE '%Ice%';


-- 6 --
DELETE
FROM products as prod
WHERE prod.brand_id=9;


-- 7 --
DELETE
FROM products as prod
WHERE prod.category_id=6;


-- 8 --
UPDATE products
SET list_price=1499 WHERE product_id=9;


-- 9 --
INSERT INTO category (category_name)
VALUES ('Roller skates');


-- 10 --
INSERT INTO products(products_name,brand_id,category_id,model_year,list_price)
VALUES('roller skates cool',2,8,2020,258);





