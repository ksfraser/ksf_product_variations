<?php
use PHPUnit\Framework\TestCase;
require_once 'models/Admin.php';

class AdminTest extends TestCase {
    private $db;
    private $adminModel;

    protected function setUp(): void {
        $this->db = $this->createMock(mysqli::class);
        $this->adminModel = new Admin($this->db);
    }

    public function testPrepopulateData() {
        $this->db->expects($this->once())
                 ->method('query')
                 ->with($this->stringContains('INSERT INTO fa_product_attributes'))
                 ->willReturn(true);

        $this->assertTrue($this->adminModel->insertPredefinedAttributes());
    }

    public function testConfirmInsertedData() {
        // Mock attribute data
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_assoc')->willReturn([
            'id' => 1,
            'attribute_name' => 'Size'
        ]);
        $this->db->expects($this->once())
                 ->method('query')
                 ->with($this->stringContains('SELECT id, attribute_name'))
                 ->willReturn($mockResult);

        $result = $this->adminModel->getInsertedAttributes();
        $this->assertEquals(1, $result->num_rows);
    }
}
?>
