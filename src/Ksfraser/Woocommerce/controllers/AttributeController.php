<?php
include '../models/Attribute.php';

class AttributeController {
    private $attributeModel;

    public function __construct($db) {
        $this->attributeModel = new Attribute($db);
    }

    public function create() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $attribute_name = trim($_POST['attribute_name']);
                $sort_order = intval($_POST['sort_order']);

                if ($this->attributeModel->create($attribute_name, $sort_order)) {
                    header("Location: /attributes/list");
                } else {
                    throw new Exception("Failed to create attribute.");
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function list() {
        $attributes = $this->attributeModel->getAll();
        include '../views/attributes/list.php';
    }

	public function update() {
	    try {
	        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	            $id = intval($_POST['id']);
	            $attribute_name = trim($_POST['attribute_name']);
	            $sort_order = intval($_POST['sort_order']);
	
	            if ($this->attributeModel->update($id, $attribute_name, $sort_order)) {
	                header("Location: /attributes/list");
	            } else {
	                throw new Exception("Failed to update attribute.");
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
	
	            if ($this->attributeModel->delete($id)) {
	                header("Location: /attributes/list");
	            } else {
	                throw new Exception("Failed to delete attribute.");
	            }
	        }
	    } catch (Exception $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
}
?>
