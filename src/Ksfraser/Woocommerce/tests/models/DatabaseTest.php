<?php
use PHPUnit\Framework\TestCase;
require_once 'tests/DatabaseTestHelper.php';

class DatabaseTest extends TestCase {
    private $dbHelper;

    protected function setUp(): void {
        $this->dbHelper = new DatabaseTestHelper();
        $this->dbHelper->beginTransaction(); // Ensure rollback after tests
    }

    protected function tearDown(): void {
        $this->dbHelper->rollbackTransaction();
        $this->dbHelper->close();
    }

    public function testInsertVariation() {
        $query = "INSERT INTO fa_product_variations (main_product_id, variation_stock_id, attribute_values)
                  VALUES (1, 'shirt-XL-Red', '{\"description\": \"Extra Large Red Shirt\"}')";
        $this->assertTrue($this->dbHelper->executeQuery($query));
    }

    public function testRetrieveVariation() {
        $query = "INSERT INTO fa_product_variations (main_product_id, variation_stock_id, attribute_values)
                  VALUES (1, 'shirt-XL-Red', '{\"description\": \"Extra Large Red Shirt\"}')";
        $this->dbHelper->executeQuery($query);

        $result = $this->dbHelper->executeQuery("SELECT * FROM fa_product_variations WHERE variation_stock_id = 'shirt-XL-Red'");
        $this->assertEquals(1, $result->num_rows);
    }
}
?>
