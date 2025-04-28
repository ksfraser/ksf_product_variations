<?php
class Admin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkExistingAttributes() {
        $query = "SELECT COUNT(*) AS total FROM fa_product_attributes";
        return $this->db->query($query)->fetch_assoc()['total'];
    }

    public function insertPredefinedAttributes() {
        $predefinedAttributes = [
            ['Opinion', 1],
            ['Size', 2],
            ['Age', 3],
            ['Shape', 4],
            ['Color', 5],
            ['Origin', 6],
            ['Material', 7],
            ['Purpose', 8]
        ];

        foreach ($predefinedAttributes as $attr) {
            $query = "INSERT INTO fa_product_attributes (attribute_name, sort_order) VALUES (?, ?) ON DUPLICATE KEY UPDATE attribute_name = attribute_name";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $attr[0], $attr[1]);
            $stmt->execute();
        }

        return true;
    }

    public function insertPredefinedValues() {
        $predefinedValues = [
            [1, 'Stylish'], [1, 'Elegant'], [1, 'Trendy'], [1, 'Casual'], [1, 'Sporty'], [1, 'Classic'],
            [2, 'XX-Small'], [2, 'X-Small'], [2, 'Small'], [2, 'Medium'], [2, 'Large'], [2, 'X-Large'], [2, 'XX-Large'], [2, 'Oversized'],
            [3, 'New'], [3, 'Vintage'], [3, 'Retro'], [3, 'Worn'], [3, 'Antique'],
            [4, 'Slim-fit'], [4, 'Loose'], [4, 'Tapered'], [4, 'Boxy'], [4, 'Flared'], [4, 'Straight-cut'], [4, 'Skinny'], [4, 'Wide-leg'],
            [5, 'Red'], [5, 'Blue'], [5, 'Black'], [5, 'White'], [5, 'Green'], [5, 'Yellow'], [5, 'Pink'], [5, 'Gray'], [5, 'Purple'], [5, 'Beige'],
            [6, 'Italian'], [6, 'American'], [6, 'Japanese'], [6, 'French'], [6, 'British'], [6, 'Spanish'], [6, 'German'], [6, 'Canadian'],
            [7, 'Cotton'], [7, 'Wool'], [7, 'Leather'], [7, 'Polyester'], [7, 'Silk'], [7, 'Linen'], [7, 'Denim'], [7, 'Velvet'], [7, 'Suede'], [7, 'Synthetic'],
            [8, 'Formal'], [8, 'Casual'], [8, 'Athletic'], [8, 'Workwear'], [8, 'Outdoor'], [8, 'Beachwear'], [8, 'Loungewear'], [8, 'Partywear']
        ];

        foreach ($predefinedValues as $value) {
            $query = "INSERT INTO fa_product_attribute_values (attribute_id, value_name) VALUES (?, ?) ON DUPLICATE KEY UPDATE value_name = value_name";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("is", $value[0], $value[1]);
            $stmt->execute();
        }

        return true;
    }
public function getInsertedAttributes() {
    $query = "SELECT id, attribute_name FROM fa_product_attributes ORDER BY sort_order ASC";
    return $this->db->query($query);
}

public function getInsertedValues() {
    $query = "SELECT a.attribute_name, v.value_name FROM fa_product_attribute_values v
              JOIN fa_product_attributes a ON v.attribute_id = a.id
              ORDER BY a.sort_order";
    return $this->db->query($query);
}

}
?>
