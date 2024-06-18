<?php
    /**
     * Plugin Name: Custom Product Boxes AddOn
     * Plugin URI: https://www.wisdmlabs.com/assorted-bundles-woocommerce-custom-product-boxes-plugin/
     * Description: The Custom Product Boxes is an extension for your WooCommerce store, using which, your customers will be able to select products, and create and purchase their own personalized bundles.
     * Version: 4.3.6
     * Author: WisdmLabs
     * Author URI: http://www.wisdmlabs.com
     * Text Domain: custom-product-boxes
     * License: GPL 
     */

    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    // Define the path to the activation file.
    $activation_file = plugin_dir_path( __FILE__ ) . 'includes/activation/activation.php';
    // Include the activation file.
    if ( file_exists( $activation_file ) ) {
        require_once $activation_file;
    } else {
        error_log('Activation file not found: ' . $activation_file);
    }

    function my_custom_cpb_get_template($located, $template_name, $args, $template_path, $default_path) {
        $target_template = 'product-layouts/desktop-layouts/cpb_new_layout_vertical/single-product/cpb-progress-wrap.php';
        
        if ($template_name === $target_template) {
            $custom_template = plugin_dir_path(__FILE__) . 'templates/' . $target_template;
            
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }
    
        return $located;
    }
    add_filter('wc_get_template', 'my_custom_cpb_get_template', 10, 5);