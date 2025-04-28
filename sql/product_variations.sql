SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS 0_fa_product_variations;

CREATE TABLE 0_fa_product_variations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    main_product_id varchar(50) NOT NULL,
    variation_stock_id VARCHAR(50) NOT NULL UNIQUE CHECK (CHAR_LENGTH(variation_stock_id) > 5), -- Guardrail: Stock ID must be valid
    attribute_values JSON NOT NULL -- Guardrail: Must be valid JSON
);

ALTER TABLE 0_fa_product_variations ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
--ALTER TABLE 0_fa_product_variations ADD FOREIGN KEY (main_product_id) REFERENCES 0_stock_master(stock_id);
