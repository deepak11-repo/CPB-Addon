<?php

/**
 * Check if the main CPB plugin is active by checking for the main class.
 *
 * @return bool
 */
function is_cpb_plugin_active() {
    return class_exists( 'Custom_Product_Boxes' );
}

/**
 * Activation hook for the addon plugin.
 */
function cpb_addon_activation_hook() {
    if ( ! is_cpb_plugin_active() ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die(
            __( 'This addon plugin requires the Custom Product Boxes plugin to be installed and active.', 'cpb-addon' ),
            __( 'Plugin Activation Error', 'cpb-addon' ),
            array( 'back_link' => true )
        );
    }
}
register_activation_hook( __FILE__, 'cpb_addon_activation_hook' );

/**
 * Admin notice for missing CPB plugin.
 */
function cpb_addon_admin_notice() {
    if ( ! is_cpb_plugin_active() ) {
        ?>
        <div class="notice notice-error">
            <p>
                <?php
                    printf(
                        __( 'The <strong>CPB Addon Plugin</strong> requires the Custom Product Boxes plugin to be installed and active.', 'cpb-addon' )
                    );
                ?>
            </p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'cpb_addon_admin_notice' );

require_once plugin_dir_path( __FILE__ ) . '../admin/index.php';

