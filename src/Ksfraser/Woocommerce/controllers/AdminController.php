<?php
include '../models/Admin.php';

class AdminController {
    private $adminModel;

    public function __construct($db) {
        $this->adminModel = new Admin($db);
    }

public function prepopulateData() {
    try {
        $existing = $this->adminModel->checkExistingAttributes();
        if ($existing > 0) {
            header("Location: /admin/confirm"); // Redirect to confirmation screen
            exit;
        }

        $this->adminModel->insertPredefinedAttributes();
        $this->adminModel->insertPredefinedValues();

        header("Location: /admin/confirm"); // Redirect after insertion
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

public function confirmInsertedData() {
    $attributes = $this->adminModel->getInsertedAttributes();
    $values = $this->adminModel->getInsertedValues();
    include '../views/admin/confirm.php';
}

}
?>
