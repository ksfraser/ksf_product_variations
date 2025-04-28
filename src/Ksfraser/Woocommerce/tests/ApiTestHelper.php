<?php
class ApiTestHelper {
    public function mockApiResponse($statusCode, $body) {
        return [
            'status' => $statusCode,
            'body' => json_encode($body)
        ];
    }
}
?>
