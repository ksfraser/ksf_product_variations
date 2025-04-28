<?php
use PHPUnit\Framework\TestCase;
require_once 'models/ProductVariation.php';

class ProductVariationTest extends TestCase {
    private $db;
    private $variationModel;

    protected function setUp(): void {
        $this->db = $this->createMock(mysqli::class);
        $this->variationModel = new ProductVariation($this->db);
    }

    public function testGenerateValidVariation() {
        $validAttributes = [
            ['value_name' => 'Red', 'sort_order' => 1],
            ['value_name' => 'Large', 'sort_order' => 2]
        ];

        $stockID = $this->variationModel->buildStockID(1, $validAttributes);
        $this->assertEquals("Product-Red-Large", $stockID);
    }

    public function testGenerateInvalidVariation() {
        $this->expectException(Exception::class);
        $this->variationModel->generateVariations(0, []);
    }
}
?>
