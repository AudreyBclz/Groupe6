INSERT INTO products (products.name, products.brand_id, products.category_id, products.model_year, products.price)
VALUES ('Iphone 11',
        (SELECT brands.brand_id FROM brands WHERE brands.brand_name='Iphone'),
        (SELECT categories.idCat FROM categories WHERE categories.nameCat="Apple"),
        '2021',
        1234)