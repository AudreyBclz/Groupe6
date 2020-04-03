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
SELECT     products.name,
           products.model_year,
           products.price AS PrixHT
FROM products
WHERE products.name LIKE "%lce%"