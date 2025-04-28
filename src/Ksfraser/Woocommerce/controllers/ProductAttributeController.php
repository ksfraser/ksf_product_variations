<?php
include '../models/ProductAttributeMapping.php';

class ProductAttributeController {
    private $productAttributeModel;

    public function __construct($db) {
        $this->productAttributeModel = new ProductAttributeMapping($db);
    }

    public function associate() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $product_id = intval($_POST['product_id']);
                $attribute_id = intval($_POST['attribute_id']);

                if ($this->productAttributeModel->associate($product_id, $attribute_id)) {
                    header("Location: /products/attributes");
                } else {
                    throw new Exception("Failed to associate attribute with product.");
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
