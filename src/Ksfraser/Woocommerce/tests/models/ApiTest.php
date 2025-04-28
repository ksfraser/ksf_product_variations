<?php
use PHPUnit\Framework\TestCase;
require_once 'tests/ApiTestHelper.php';

class ApiTest extends TestCase {
    private $apiHelper;

    protected function setUp(): void {
        $this->apiHelper = new ApiTestHelper();
    }

    public function testSuccessfulApiCall() {
        $mockResponse = $this->apiHelper->mockApiResponse(200, ['type_no' => 1234, 'status' => 'success']);
        $this->assertEquals(200, $mockResponse['status']);
        $this->assertStringContainsString('success', $mockResponse['body']);
    }

    public function testFailedApiCall() {
        $mockResponse = $this->apiHelper->mockApiResponse(500, ['error' => 'Internal Server Error']);
        $this->assertEquals(500, $mockResponse['status']);
        $this->assertStringContainsString('error', $mockResponse['body']);
    }
}
?>
