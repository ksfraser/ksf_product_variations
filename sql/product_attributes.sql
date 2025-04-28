SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS 0_fa_product_attributes;

CREATE TABLE 0_fa_product_attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attribute_name VARCHAR(50) NOT NULL UNIQUE,
    sort_order INT NOT NULL -- Royal Order of Adjectives (defines order)
);

ALTER TABLE 0_fa_product_attributes ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;



INSERT INTO 0_fa_product_attributes (attribute_name, sort_order) VALUES ('Opinion', 1);
INSERT INTO 0_fa_product_attributes (attribute_name, sort_order) VALUES ('Size', 2);
INSERT INTO 0_fa_product_attributes (attribute_name, sort_order) VALUES ('Age', 3);
INSERT INTO 0_fa_product_attributes (attribute_name, sort_order) VALUES ('Shape', 4);
INSERT INTO 0_fa_product_attributes (attribute_name, sort_order) VALUES ('Color', 5);
INSERT INTO 0_fa_product_attributes (attribute_name, sort_order) VALUES ('Origin', 6);
INSERT INTO 0_fa_product_attributes (attribute_name, sort_order) VALUES ('Material', 7);
INSERT INTO 0_fa_product_attributes (attribute_name, sort_order) VALUES ('Purpose', 8);
