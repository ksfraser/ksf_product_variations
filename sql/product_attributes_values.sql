SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS 0_fa_product_attribute_values;


CREATE TABLE 0_fa_product_attribute_values (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attribute_id INT NOT NULL,
    value_name VARCHAR(50) NOT NULL
);

ALTER TABLE 0_fa_product_attribute_values ADD COLUMN abbreviation VARCHAR(10) NOT NULL default '';
ALTER TABLE 0_fa_product_attribute_values ADD FOREIGN KEY (attribute_id) REFERENCES 0_fa_product_attributes(id);



INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (1, 'Stylish');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (1, 'Elegant');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (1, 'Trendy');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (1, 'Casual');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (1, 'Sporty');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (1, 'Classic');

INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (2, 'XX-Small');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (2, 'X-Small');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (2, 'Small');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (2, 'Medium');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (2, 'Large');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (2, 'X-Large');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (2, 'XX-Large');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (2, 'Oversized');

INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (3, 'New');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (3, 'Vintage');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (3, 'Retro');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (3, 'Worn');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (3, 'Antique');

INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (4, 'Slim-fit');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (4, 'Loose');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (4, 'Tapered');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (4, 'Boxy');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (4, 'Flared');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (4, 'Straight-cut');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (4, 'Skinny');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (4, 'Wide-leg');

INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'Red');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'Blue');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'Black');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'White');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'Green');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'Yellow');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'Pink');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'Gray');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'Purple');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (5, 'Beige');


INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (6, 'Italian');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (6, 'American');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (6, 'Japanese');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (6, 'French');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (6, 'British');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (6, 'Spanish');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (6, 'German');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (6, 'Canadian');

INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Cotton');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Wool');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Leather');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Polyester');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Silk');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Linen');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Denim');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Velvet');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Suede');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (7, 'Synthetic');

INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (8, 'Formal');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (8, 'Casual');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (8, 'Athletic');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (8, 'Workwear');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (8, 'Outdoor');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (8, 'Beachwear');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (8, 'Loungewear');
INSERT INTO 0_fa_product_attribute_values (attribute_id, value_name) VALUES (8, 'Partywear');
