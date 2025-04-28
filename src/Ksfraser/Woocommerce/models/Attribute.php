<?php
class Attribute {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($attribute_name, $sort_order) {
        if (empty($attribute_name) || $sort_order <= 0) {
            throw new Exception("Invalid attribute data.");
        }

        $query = "INSERT INTO fa_product_attributes (attribute_name, sort_order) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $attribute_name, $sort_order);
        return $stmt->execute();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM fa_product_attributes ORDER BY sort_order ASC");
    }

	public function update($id, $attribute_name, $sort_order) {
	    if (empty($id) || empty($attribute_name) || $sort_order <= 0) {
	        throw new Exception("Invalid attribute update data.");
	    }
	
	    $query = "UPDATE fa_product_attributes SET attribute_name = ?, sort_order = ? WHERE id = ?";
	    $stmt = $this->db->prepare($query);
	    $stmt->bind_param("sii", $attribute_name, $sort_order, $id);
	    return $stmt->execute();
	}
	public function delete($id) {
	    if (empty($id)) {
	        throw new Exception("Invalid attribute ID.");
	    }
	
	    // Check if the attribute is used in products
	    $checkQuery = "SELECT COUNT(*) as count FROM fa_product_attribute_mapping WHERE attribute_id = ?";
	    $stmt = $this->db->prepare($checkQuery);
	    $stmt->bind_param("i", $id);
	    $stmt->execute();
	    $result = $stmt->get_result()->fetch_assoc();
	    
	    if ($result['count'] > 0) {
	        throw new Exception("Cannot delete attribute in use.");
	    }
	
	    // Delete the attribute
	    $query = "DELETE FROM fa_product_attributes WHERE id = ?";
	    $stmt = $this->db->prepare($query);
	    $stmt->bind_param("i", $id);
	    return $stmt->execute();
	}
	public function countAttributes() {
	    $query = "SELECT COUNT(*) AS total_attributes FROM fa_product_attributes";
	    return $this->db->query($query)->fetch_assoc()['total_attributes'];
	}
	
	public function countAttributeValues() {
	    $query = "SELECT COUNT(*) AS total_attribute_values FROM fa_product_attribute_values";
	    return $this->db->query($query)->fetch_assoc()['total_attribute_values'];
	}
}
?>
