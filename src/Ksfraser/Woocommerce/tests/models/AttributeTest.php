<?php
use PHPUnit\Framework\TestCase;
require_once 'models/Attribute.php';

class AttributeTest extends TestCase {
    private $db;
    private $attributeModel;

    protected function setUp(): void {
        $this->db = $this->createMock(mysqli::class);
        $this->attributeModel = new Attribute($this->db);
    }

    public function testCreateValidAttribute() {
        $this->db->expects($this->once())
                 ->method('prepare')
                 ->willReturn(true);

        $this->assertTrue($this->attributeModel->create("Color", 1));
    }

    public function testCreateInvalidAttribute() {
        $this->expectException(Exception::class);
        $this->attributeModel->create("", -1);
    }
}
?>
