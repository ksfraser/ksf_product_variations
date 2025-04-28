<?php
class ProductAttributeMapping {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function associate($product_id, $attribute_id) {
        if (empty($product_id) || empty($attribute_id)) {
            throw new Exception("Invalid product-attribute association.");
        }

        $query = "INSERT INTO fa_product_attribute_mapping (product_id, attribute_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $product_id, $attribute_id);
        return $stmt->execute();
    }

    public function getAttributesForProduct($product_id) {
        $query = "SELECT a.attribute_name FROM fa_product_attribute_mapping pam
                  JOIN fa_product_attributes a ON pam.attribute_id = a.id
                  WHERE pam.product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
