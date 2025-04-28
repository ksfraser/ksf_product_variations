<?php
include '../models/ProductVariation.php';

class VariationController {
    private $variationModel;
    private $db;

    public function __construct($db) {
	$this->db = $db;
        $this->variationModel = new ProductVariation($db);
    }

    public function generate() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $product_id = intval($_POST['product_id']);
                $attribute_values = json_decode($_POST['attribute_values'], true);

                if ($this->variationModel->generateVariations($product_id, $attribute_values)) {
                    header("Location: /variations/list");
                } else {
                    throw new Exception("Failed to generate variations.");
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
	public function update() {
	    try {
	        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	            $id = intval($_POST['id']);
	            $new_stock_id = trim($_POST['new_stock_id']);
	            $attribute_values = json_decode($_POST['attribute_values'], true);
	
	            if ($this->variationModel->updateVariation($id, $new_stock_id, $attribute_values)) {
	                header("Location: /variations/list");
	            } else {
	                throw new Exception("Failed to update variation.");
	            }
	        }
	    } catch (Exception $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	
	public function delete() {
	    try {
	        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	            $id = intval($_POST['id']);
	
	            if ($this->variationModel->deleteVariation($id)) {
	                header("Location: /variations/list");
	            } else {
	                throw new Exception("Failed to delete variation.");
	            }
	        }
	    } catch (Exception $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	public function bulkUpdate() {
	    try {
	        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	            $variations = json_decode($_POST['variations'], true);
	
	            if ($this->variationModel->bulkUpdateVariations($variations)) {
	                header("Location: /variations/list");
	            } else {
	                throw new Exception("Failed to bulk update variations.");
	            }
	        }
	    } catch (Exception $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	public function bulkDelete() {
	    try {
	        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	            $variationIds = json_decode($_POST['variation_ids'], true);
	
	            if ($this->variationModel->bulkDeleteVariations($variationIds)) {
	                header("Location: /variations/list");
	            } else {
	                throw new Exception("Failed to bulk delete variations.");
	            }
	        }
	    } catch (Exception $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
    public function generateScreen() {
        // Fetch all products
        $products = $this->db->query("SELECT stock_id, description FROM fa_products");

        // Fetch all attributes
        $attributes = $this->db->query("SELECT id, attribute_name FROM fa_product_attributes");

        include '../views/variations/generate.php';
    }

    public function generateVariations() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = intval($_POST['product_id']);
            $selectedAttributes = $_POST['attributes']; // Array of attribute IDs

            // Fetch product details
            $product = $this->db->query("SELECT stock_id, description FROM fa_products WHERE stock_id = {$productId}")->fetch_assoc();

            // Fetch attribute values
            $attributeValues = [];
            foreach ($selectedAttributes as $attributeId) {
                $result = $this->db->query("SELECT value_name, abbreviation FROM fa_product_attribute_values WHERE attribute_id = {$attributeId}");
                $attributeValues[$attributeId] = $result->fetch_all(MYSQLI_ASSOC);
            }

            // Generate variations
            $variations = [];
            $this->generateCombinations(array_values($attributeValues), [], $product['stock_id'], $product['description'], $variations);

            // Insert variations into database
            foreach ($variations as $variation) {
                $this->db->query("INSERT INTO fa_product_variations (main_product_id, variation_stock_id, attribute_values)
                                  VALUES ('{$productId}', '{$variation['stock_id']}', '".json_encode($variation['attributes'])."')");
            }

            echo "Variations generated successfully!";
        }
    }

    private function generateCombinations($attributes, $currentCombination, $baseStockId, $baseDescription, &$variations) {
        if (empty($attributes)) {
            // Build stock ID and description
            $stockId = strtolower($baseStockId . '-' . implode('-', array_column($currentCombination, 'abbreviation')));
            $description = $baseDescription . ' ' . implode(' ', array_column($currentCombination, 'value_name'));

            $variations[] = [
                'stock_id' => $stockId,
                'attributes' => $currentCombination
            ];
            return;
        }

        $currentAttribute = array_shift($attributes);
        foreach ($currentAttribute as $value) {
            $this->generateCombinations($attributes, array_merge($currentCombination, [$value]), $baseStockId, $baseDescription, $variations);
        }
    }
    public function saveEditedVariations() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $editedVariations = json_decode($_POST['edited_variations'], true); // Expect JSON-encoded data

            foreach ($editedVariations as $variation) {
                $stockId = $this->db->real_escape_string($variation['stock_id']);
                $description = $this->db->real_escape_string($variation['description']);
                $originalStockId = $this->db->real_escape_string($variation['original_stock_id']);

                // Update the database
                $query = "UPDATE fa_product_variations SET
                          variation_stock_id = '{$stockId}',
                          attribute_values = JSON_SET(attribute_values, '$.description', '{$description}')
                          WHERE variation_stock_id = '{$originalStockId}'";
                $this->db->query($query);
            }

            echo "Variations successfully updated!";
        }
    }
}
