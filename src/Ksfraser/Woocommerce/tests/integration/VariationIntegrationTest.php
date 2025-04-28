<?php
use PHPUnit\Framework\TestCase;

class VariationIntegrationTest extends TestCase {
    private $db;

    protected function setUp(): void {
        $this->db = new mysqli(getenv("DB_HOST"), getenv("DB_USER"), getenv("DB_PASSWORD"), getenv("DB_NAME"));
        $this->db->query("START TRANSACTION"); // Start transaction to isolate tests
    }

    protected function tearDown(): void {
        $this->db->query("ROLLBACK"); // Rollback changes after each test
        $this->db->close();
    }

    public function testVariationGenerationWorkflow() {
        // Step 1: Insert a base product
        $this->db->query("INSERT INTO fa_products (stock_id, description) VALUES ('shirt', 'Shirt')");

        // Step 2: Insert attributes and values
        $this->db->query("INSERT INTO fa_product_attributes (id, attribute_name, sort_order) VALUES (1, 'Size', 1)");
        $this->db->query("INSERT INTO fa_product_attributes (id, attribute_name, sort_order) VALUES (2, 'Color', 2)");
        $this->db->query("INSERT INTO fa_product_attribute_values (attribute_id, value_name, abbreviation) VALUES (1, 'Small', 'S')");
        $this->db->query("INSERT INTO fa_product_attribute_values (attribute_id, value_name, abbreviation) VALUES (1, 'Large', 'L')");
        $this->db->query("INSERT INTO fa_product_attribute_values (attribute_id, value_name, abbreviation) VALUES (2, 'Red', 'Red')");
        $this->db->query("INSERT INTO fa_product_attribute_values (attribute_id, value_name, abbreviation) VALUES (2, 'Blue', 'Blue')");

        // Step 3: Simulate generating variations
        $attributeValues = [
            ['value_name' => 'Small', 'abbreviation' => 'S'],
            ['value_name' => 'Red', 'abbreviation' => 'Red']
        ];
        $variations = [];
        $this->generateCombinations([[$attributeValues[0]], [$attributeValues[1]]], [], 'shirt', 'Shirt', $variations);

        // Verify variations are generated
        $this->assertCount(1, $variations);
        $this->assertEquals('shirt-S-Red', $variations[0]['stock_id']);
        $this->assertEquals('Shirt Small Red', $variations[0]['description']);

        // Step 4: Save variations to database
        foreach ($variations as $variation) {
            $this->db->query("INSERT INTO fa_product_variations (main_product_id, variation_stock_id, attribute_values) 
                              VALUES ('shirt', '{$variation['stock_id']}', '".json_encode($variation)."')");
        }

        // Step 5: Fetch and validate from database
        $result = $this->db->query("SELECT * FROM fa_product_variations WHERE variation_stock_id = 'shirt-S-Red'");
        $this->assertEquals(1, $result->num_rows);
    }

    public function testPreviewEditingWorkflow() {
        // Step 1: Insert a variation
        $this->db->query("INSERT INTO fa_product_variations (main_product_id, variation_stock_id, attribute_values) 
                          VALUES ('shirt', 'shirt-S-Red', '{\"description\": \"Small Red Shirt\"}')");

        // Step 2: Simulate editing Stock ID and description
        $editedStockId = 'shirt-M-Blue';
        $editedDescription = 'Medium Blue Shirt';
        $this->db->query("UPDATE fa_product_variations SET variation_stock_id = '{$editedStockId}', 
                          attribute_values = JSON_SET(attribute_values, '$.description', '{$editedDescription}') 
                          WHERE variation_stock_id = 'shirt-S-Red'");

        // Step 3: Validate updates in the database
        $result = $this->db->query("SELECT * FROM fa_product_variations WHERE variation_stock_id = '{$editedStockId}'");
        $this->assertEquals(1, $result->num_rows);

        $row = $result->fetch_assoc();
        $this->assertStringContainsString($editedDescription, $row['attribute_values']);
    }

    private function generateCombinations($attributes, $currentCombination, $baseStockId, $baseDescription, &$variations) {
        if (empty($attributes)) {
            $stockId = strtolower($baseStockId . '-' . implode('-', array_column($currentCombination, 'abbreviation')));
            $description = $baseDescription . ' ' . implode(' ', array_column($currentCombination, 'value_name'));

            $variations[] = [
                'stock_id' => $stockId,
                'description' => $description
            ];
            return;
        }

        $currentAttribute = array_shift($attributes);
        foreach ($currentAttribute as $value) {
            $this->generateCombinations($attributes, array_merge($currentCombination, [$value]), $baseStockId, $baseDescription, $variations);
        }
    }
}
?>
