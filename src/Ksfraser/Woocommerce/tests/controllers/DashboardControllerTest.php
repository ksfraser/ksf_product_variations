<?php
use PHPUnit\Framework\TestCase;
require_once 'controllers/DashboardController.php';
require_once 'models/ProductVariation.php';

class DashboardControllerTest extends TestCase {
    private $db;
    private $dashboardController;
    private $variationModel;

    protected function setUp(): void {
        $this->db = $this->createMock(mysqli::class);
        $this->variationModel = $this->createMock(ProductVariation::class);
        $this->dashboardController = new DashboardController($this->db);
    }

    public function testSummary() {
        $this->variationModel->expects($this->once())
                             ->method('getPaginatedResults')
                             ->willReturn([['product_name' => 'T-Shirt', 'variation_count' => 3]]);
        
        $this->variationModel->expects($this->once())
                             ->method('getTotalResults')
                             ->willReturn(1);

        $this->assertNotNull($this->dashboardController->summary(1));
    }
}
?>
