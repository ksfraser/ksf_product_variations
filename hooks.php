<?php
// Prevent direct access
/*
if (!defined('FA_ROOT')) {
    die("Access Denied");
}
*/

// Add new tab in the Stock app
$hooks = array(
    'stock' => array(
        'tab' => array(
            'title' => _("Product Variations"),
            'url' => "modules/ksf_product_variations/index.php",
            'access' => 'SA_ITEM'
        )
    )
);



define('SS_PRODUCT_VARIATIONS', 101<<8);

class hooks_ksf_product_variations extends hooks {
        var $module_name = 'ksf_product_variations';

        /*
                Install additonal menu options provided by module
        */
        function install_options($app) {
                global $path_to_root;

                switch($app->id) {
                        case 'stock':
                                $app->add_rapp_function(2, _('&Product Variations'), $path_to_root.'/modules/ksf_product_variations/index.php', 'SA_PRODUCT_VARIATIONS',
                                        MENU_ENTRY);
                                break;
                }
        }

        function install_access()
        {

                $security_sections[SS_PRODUCT_VARIATIONS] = _("Product Variations");

                $security_areas['SA_PRODUCT_VARIATIONS'] = array(SS_PRODUCT_VARIATIONS|1, _("Product Variations"));
                //$security_areas['SA_PRODUCT_VARIATIONS'] = array(SS_PRODUCT_VARIATIONS|1, _("Product Variations"));
                return array($security_areas, $security_sections);
        }

        /* This method is called on extension activation for company.   */
        function activate_extension($company, $check_only=true)
        {
                global $db_connections;

                $updates = array(
			'product_attributes.sql' => array('ksf_product_variations'),
			'product_attributes_values.sql' => array('ksf_product_variations'),
			'product_variations.sql' => array('ksf_product_variations'),
                );

                return $this->update_databases($company, $updates, $check_only);
        }
}
