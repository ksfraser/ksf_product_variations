<?php
global $path_to_root;
if( strlen( $path_to_root ) < 5 )
{
	$path_to_root = "../..";
}
include_once "$path_to_root/includes/session.inc";
include_once "$path_to_root/includes/ui.inc";
include_once "$path_to_root/includes/db/connect_db.inc";

page(_("Available Screens"));

$path = "./src/Ksfraser/Woocommerce/";

// Function to scan the controllers directory
function getControllers() {
    $controllerFiles = glob("$path/controllers/*.php");
    $controllers = [];

    foreach ($controllerFiles as $file) {
        $name = basename($file, ".php");
        $controllers[$name] = [];
        
        // Extract methods dynamically from each controller
        require_once $file;
        if (class_exists($name)) {
            $methods = get_class_methods($name);
            foreach ($methods as $method) {
                $controllers[$name][] = $method;
            }
        }
    }

    return $controllers;
}

// Function to scan the views directory
function getViews() {
    $viewFiles = glob("$path/views/*/*.php");
    $views = [];

    foreach ($viewFiles as $file) {
        $category = basename(dirname($file)); // Get subfolder name
        if (!isset($views[$category])) {
            $views[$category] = [];
        }
        $views[$category][] = basename($file);
    }

    return $views;
}

// Get available controllers and views
$controllers = getControllers();
$views = getViews();

// Display controllers and their methods
start_table(TABLESTYLE, "width=80%");
table_header(array(_("Controller"), _("Available Methods")));

foreach ($controllers as $controller => $methods) {
    foreach ($methods as $method) {
        label_row($controller, $method, "<a href='/{$controller}/{$method}'>Go</a>");
    }
}

end_table();

// Display views
start_table(TABLESTYLE, "width=80%");
table_header(array(_("Category"), _("View Files")));

foreach ($views as $category => $files) {
    foreach ($files as $file) {
        label_row($category, $file, "<a href='/views/{$category}/{$file}'>View</a>");
    }
}

end_table();
end_page();
?>
