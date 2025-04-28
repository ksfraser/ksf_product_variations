<?php
use PHPUnit\Framework\TestCase;
require_once 'controllers/VariationController.php';

class VariationControllerTest extends TestCase {
    private $db;
    private $variationController;

    protected function setUp(): void {
        $this->db = $this->createMock(mysqli::class);
        $this->variationController = new VariationController($this->db);
    }

    public function testGenerateVariations() {
        // Mock database queries and responses
        $this->db->expects($this->exactly(2))
                 ->method('query')
                 ->willReturnOnConsecutiveCalls(
                     $this->mockProductData(), // First call fetches the product
                     $this->mockAttributeValues() // Second call fetches attribute values
                 );

        // Simulate POST data
        $_POST = [
            'product_id' => 1,
            'attributes' => [2, 3] // Size, Color
        ];

        // Capture generated variations
        ob_start();
        $this->variationController->generateVariations();
        $output = ob_get_clean();

        $this->assertStringContainsString("Variations generated successfully!", $output);
    }

    public function testPreviewVariations() {
        // Mock database queries and responses
        $this->db->expects($this->exactly(2))
                 ->method('query')
                 ->willReturnOnConsecutiveCalls(
                     $this->mockProductData(), // First call fetches the product
                     $this->mockAttributeValues() // Second call fetches attribute values
                 );

        // Simulate POST data
        $_POST = [
            'product_id' => 1,
            'attributes' => [2, 3] // Size, Color
        ];

        ob_start();
        $this->variationController->previewVariations();
        $output = ob_get_clean();

        $this->assertStringContainsString("Preview Generated Variations", $output);
    }

    private function mockProductData() {
        $productData = $this->createMock(mysqli_result::class);
        $productData->method('fetch_assoc')->willReturn([
            'stock_id' => 'shirt',
            'description' => 'Shirt'
        ]);
        return $productData;
    }

    private function mockAttributeValues() {
        $attributeData = $this->createMock(mysqli_result::class);
        $attributeData->method('fetch_all')->willReturn([
            ['Extra Large', 'XL'],
            ['Red', 'Red']
        ]);
        return $attributeData;
    }
}
?>
