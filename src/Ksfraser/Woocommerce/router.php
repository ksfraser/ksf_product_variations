<?php


<?php
// Autoload controllers dynamically
spl_autoload_register(function ($class) {
    if (file_exists("controllers/$class.php")) {
        require_once "controllers/$class.php";
    }
});

// Parse request URL
$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$segments = explode('/', $requestUri);

// Determine controller
$controllerName = ucfirst($segments[0]) . "Controller"; // Converts 'attributes' to 'AttributeController'
$method = $segments[1] ?? 'index'; // Defaults to 'index' if no second-level route is provided
$parameters = array_slice($segments, 2); // Grab remaining URL segments as parameters

// Check if controller exists
if (file_exists("controllers/$controllerName.php")) {
    $controllerInstance = new $controllerName($db); // Pass database instance

    // Check if method exists
    if (method_exists($controllerInstance, $method)) {
        call_user_func_array([$controllerInstance, $method], $parameters); // Call method with parameters
    } else {
        http_response_code(404);
        echo "Error: Method '$method' not found in '$controllerName'.";
    }
} else {
    http_response_code(404);
    echo "Error: Controller '$controllerName' not found.";
}

/**

include 'controllers/AttributeController.php';

$controller = new AttributeController($db);

$request = $_SERVER['REQUEST_URI'];


if ($request == "/variations/saveEditedVariations") {
    $controller = new VariationController($db);
    $controller->saveEditedVariations();
}
else
if ($request == "/admin/confirm") {
    $controller = new AdminController($db);
    $controller->confirmInsertedData();
}
else
if ($request == "/admin/prepopulate") {
    $controller = new AdminController($db);
    $controller->prepopulateData();
}
else if ($request == "/dashboard/summary") {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $controller = new DashboardController($db);
    $controller->summary($page);
}
else if ($request == "/dashboard/filteredSummary") {
    $controller = new DashboardController($db);
    $controller->filteredSummary();
}
else if ($request == "/attributes/list") {
    $controller->list();
} elseif ($request == "/attributes/create") {
    $controller->create();
} elseif ($request == "/variations/bulkUpdate") {
    $controller->bulkUpdate();
} elseif ($request == "/variations/bulkDelete") {
    $controller->bulkDelete();
} else {
    echo "404 - Page Not Found";
}
?>

*/

