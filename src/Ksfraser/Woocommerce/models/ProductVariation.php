<?php
class ProductVariation {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function generateVariations($product_id, $attribute_values) {
        if (empty($product_id) || empty($attribute_values)) {
            throw new Exception("Invalid data for generating variations.");
        }

        // Sort attributes by Royal Order
        usort($attribute_values, function($a, $b) {
            return $a['sort_order'] <=> $b['sort_order'];
        });

        // Generate stock ID
        $stock_id = $this->buildStockID($product_id, $attribute_values);

        // Insert into database
        $query = "INSERT INTO fa_product_variations (main_product_id, variation_stock_id, attribute_values) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $json_values = json_encode($attribute_values);
        $stmt->bind_param("iss", $product_id, $stock_id, $json_values);
        return $stmt->execute();
    }

    private function buildStockID($product_id, $attribute_values) {
        $nameQuery = "SELECT name FROM fa_products WHERE id = ?";
        $stmt = $this->db->prepare($nameQuery);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        $stock_id = $product['name'];

        foreach ($attribute_values as $attr) {
            $stock_id .= "-" . $attr['value_name']; // Append attributes in correct order
        }

        return $stock_id;
    }
	public function updateVariation($id, $new_stock_id, $attribute_values) {
	    if (empty($id) || empty($new_stock_id) || empty($attribute_values)) {
	        throw new Exception("Invalid variation update.");
	    }
	
	    $query = "UPDATE fa_product_variations SET variation_stock_id = ?, attribute_values = ? WHERE id = ?";
	    $stmt = $this->db->prepare($query);
	    $json_values = json_encode($attribute_values);
	    $stmt->bind_param("ssi", $new_stock_id, $json_values, $id);
	    return $stmt->execute();
	}
	
	public function deleteVariation($id) {
	    if (empty($id)) {
	        throw new Exception("Invalid variation ID.");
	    }
	
	    $query = "DELETE FROM fa_product_variations WHERE id = ?";
	    $stmt = $this->db->prepare($query);
	    $stmt->bind_param("i", $id);
	    return $stmt->execute();
	}
	public function bulkUpdateVariations($variations) {
	    foreach ($variations as $variation) {
	        $id = intval($variation['id']);
	        $new_stock_id = trim($variation['new_stock_id']);
	        $attribute_values = json_encode($variation['attribute_values']);
	
	        if (empty($id) || empty($new_stock_id) || empty($attribute_values)) {
	            throw new Exception("Invalid data for variation ID: {$id}");
	        }
	
	        $query = "UPDATE fa_product_variations SET variation_stock_id = ?, attribute_values = ? WHERE id = ?";
	        $stmt = $this->db->prepare($query);
	        $stmt->bind_param("ssi", $new_stock_id, $attribute_values, $id);
	        if (!$stmt->execute()) {
	            throw new Exception("Failed to update variation ID: {$id}");
	        }
	    }
	    return true;
	}
	public function bulkDeleteVariations($variationIds) {
	    foreach ($variationIds as $id) {
	        $id = intval($id);
	        if (empty($id)) {
	            throw new Exception("Invalid variation ID for deletion: {$id}");
	        }
	
	        $query = "DELETE FROM fa_product_variations WHERE id = ?";
	        $stmt = $this->db->prepare($query);
	        $stmt->bind_param("i", $id);
	        if (!$stmt->execute()) {
	            throw new Exception("Failed to delete variation ID: {$id}");
	        }
	    }
	    return true;
	}
	public function countVariationsPerProduct() {
	    $query = "SELECT p.name AS product_name, COUNT(v.id) AS variation_count
	              FROM fa_products p
	              LEFT JOIN fa_product_variations v ON p.stock_id = v.main_product_id
	              GROUP BY p.stock_id";
	    return $this->db->query($query);
	}
	public function filterByVariationCount($minCount = 0, $maxCount = PHP_INT_MAX) {
	    $query = "SELECT p.name AS product_name, COUNT(v.id) AS variation_count
	              FROM fa_products p
	              LEFT JOIN fa_product_variations v ON p.stock_id = v.main_product_id
	              GROUP BY p.stock_id
	              HAVING variation_count BETWEEN ? AND ?";
	    $stmt = $this->db->prepare($query);
	    $stmt->bind_param("ii", $minCount, $maxCount);
	    $stmt->execute();
	    return $stmt->get_result();
	}
	public function filterByAttribute($attributeId) {
	    $query = "SELECT p.name AS product_name, COUNT(v.id) AS variation_count
	              FROM fa_products p
	              JOIN fa_product_attribute_mapping pam ON p.stock_id = pam.product_id
	              JOIN fa_product_variations v ON p.stock_id = v.main_product_id
	              WHERE pam.attribute_id = ?
	              GROUP BY p.stock_id";
	    $stmt = $this->db->prepare($query);
	    $stmt->bind_param("i", $attributeId);
	    $stmt->execute();
	    return $stmt->get_result();
	}
	public function filterByStockStatus($inStock = true) {
	    $query = "SELECT p.name AS product_name, COUNT(v.id) AS variation_count
	              FROM fa_products p
	              LEFT JOIN fa_product_variations v ON p.stock_id = v.main_product_id
	              WHERE p.in_stock = ?
	              GROUP BY p.stock_id";
	    $stmt = $this->db->prepare($query);
	    $stmt->bind_param("i", $inStock);
	    $stmt->execute();
	    return $stmt->get_result();
	}
	public function getPaginatedResults($offset, $limit) {
	    $query = "SELECT p.name AS product_name, COUNT(v.id) AS variation_count
	              FROM fa_products p
	              LEFT JOIN fa_product_variations v ON p.stock_id = v.main_product_id
	              GROUP BY p.stock_id
	              LIMIT ?, ?";
	    $stmt = $this->db->prepare($query);
	    $stmt->bind_param("ii", $offset, $limit);
	    $stmt->execute();
	    return $stmt->get_result();
	}
	
	public function getTotalResults() {
	    $query = "SELECT COUNT(DISTINCT p.stock_id) AS total_products FROM fa_products p";
	    return $this->db->query($query)->fetch_assoc()['total_products'];
	}
}
?>
