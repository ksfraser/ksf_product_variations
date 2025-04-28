<?php
include '../models/Attribute.php';
include '../models/ProductVariation.php';

class DashboardController {
    private $attributeModel;
    private $variationModel;

    public function __construct($db) {
        $this->attributeModel = new Attribute($db);
        $this->variationModel = new ProductVariation($db);
    }

    public function summary() {
        try {
  	      $limit = 10; // Results per page
        	$offset = ($page - 1) * $limit;
        
        	$totalResults = $this->variationModel->getTotalResults();
        	$totalPages = ceil($totalResults / $limit);

        $paginatedResults = $this->variationModel->getPaginatedResults($offset, $limit);
/*
            $totalAttributes = $this->attributeModel->countAttributes();
            $totalAttributeValues = $this->attributeModel->countAttributeValues();
            $variationsByProduct = $this->variationModel->countVariationsPerProduct();
*/

            include '../views/dashboard/summary.php';
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
	public function filteredSummary() {
	    try {
	        $minCount = isset($_GET['minCount']) ? intval($_GET['minCount']) : 0;
	        $maxCount = isset($_GET['maxCount']) ? intval($_GET['maxCount']) : PHP_INT_MAX;
	        $attributeId = isset($_GET['attributeId']) ? intval($_GET['attributeId']) : null;
	        $inStock = isset($_GET['inStock']) ? intval($_GET['inStock']) : null;
	
	        if ($attributeId) {
	            $filteredVariations = $this->variationModel->filterByAttribute($attributeId);
	        } elseif ($inStock !== null) {
	            $filteredVariations = $this->variationModel->filterByStockStatus($inStock);
	        } else {
	            $filteredVariations = $this->variationModel->filterByVariationCount($minCount, $maxCount);
	        }
	
	        include '../views/dashboard/filtered_summary.php';
	    } catch (Exception $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
}
?>
