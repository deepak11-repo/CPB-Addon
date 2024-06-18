<?php 

class CPB_Box_Animations_Addon {

    public function __construct() {
        add_action('cpb_type_general_admin_config', array($this, 'cpb_add_animation_field'), 15);
        add_action('cpb_type_general_admin_config', array($this, 'cpb_add_image_fields'), 20);
        add_action('woocommerce_process_product_meta', array($this, 'save_custom_fields'));
        add_action('admin_footer', array($this, 'cpb_add_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'conditionally_enqueue_styles'), 20);
        add_action('wp_head', array($this, 'add_inline_styles'), 20);
        add_action('wp_enqueue_scripts', array($this, 'override_original_plugin_scripts'), 20);
    }

    public function cpb_add_admin_scripts() {
        wp_enqueue_script('cpb-admin-script', plugin_dir_url(__FILE__) . '../../assets/js/script.js', array('jquery'), '1.0', true);
    }  

    public function cpb_add_animation_field($cpb_product) {
        $post_id = is_object($cpb_product) ? $cpb_product->get_id() : $cpb_product;
        $value = get_post_meta($post_id, '_cpb_enable_box_animations', true);
        error_log("Adding animation field for post ID: $post_id");

        woocommerce_wp_checkbox(array(
            'id' => 'cpb_enable_box_animations',
            'label' => __('Enable Box Animations', 'custom-product-boxes'),
            'description' => __('Enable or disable animations for the box', 'custom-product-boxes'),
            'value' => $value === 'yes' ? 'yes' : '',
        ));
    }
    
    public function cpb_add_image_fields($cpb_product) {
        $post_id = is_object($cpb_product) ? $cpb_product->get_id() : $cpb_product;
        $background_image = get_post_meta($post_id, '_cpb_background_image', true);
        $foreground_image = get_post_meta($post_id, '_cpb_foreground_image', true);

        error_log("Adding image fields for post ID: $post_id");

        echo '<div id="cpb_image_fields" style="display:none;">';
        woocommerce_wp_text_input(array(
            'id' => 'cpb_background_image',
            'label' => __('Background Image URL', 'custom-product-boxes'),
            'description' => __('Set the URL for the background image of the box', 'custom-product-boxes'),
            'value' => $background_image,
            'type' => 'text'
        ));

        woocommerce_wp_text_input(array(
            'id' => 'cpb_foreground_image',
            'label' => __('Foreground Image URL', 'custom-product-boxes'),
            'description' => __('Set the URL for the foreground image of the box', 'custom-product-boxes'),
            'value' => $foreground_image,
            'type' => 'text'
        ));
        echo '</div>';
    }
    
    public function save_custom_fields($post_id) {
        error_log("Saving custom fields for post ID: $post_id");
        $enable_box_animations = isset($_POST['cpb_enable_box_animations']) ? 'yes' : 'no';
        $background_image = isset($_POST['cpb_background_image']) ? sanitize_text_field($_POST['cpb_background_image']) : '';
        $foreground_image = isset($_POST['cpb_foreground_image']) ? sanitize_text_field($_POST['cpb_foreground_image']) : '';

        error_log("Animation enabled: $enable_box_animations");
        error_log("Background image URL: $background_image");
        error_log("Foreground image URL: $foreground_image");

        update_post_meta($post_id, '_cpb_enable_box_animations', $enable_box_animations);
        update_post_meta($post_id, '_cpb_background_image', $background_image);
        update_post_meta($post_id, '_cpb_foreground_image', $foreground_image);
    }    

    public function conditionally_enqueue_styles() {
        if (is_product()) {
            global $post;
            $this->enqueue_addon_styles($post->ID);
        }
    }

    private function enqueue_addon_styles($post_id) {
        if (get_post_meta($post_id, '_cpb_enable_box_animations', true) === 'yes') {
            $plugin_url = plugin_dir_url(__FILE__) . '../../assets/css/style.css';
            wp_enqueue_style('custom-style', $plugin_url);
        }
        $box_capacity = get_post_meta($post_id, 'cpb_box_capacity', true);
        if ($box_capacity) {
            $capacity_css_url = plugin_dir_url(__FILE__) . '../../assets/css/cpb-box-' . intval($box_capacity) . '.css';
            wp_enqueue_style('cpb-box-capacity-style', $capacity_css_url);
        }
    }

    public function add_inline_styles() {
        if (is_product()) {
            global $post;
            $background_image = get_post_meta($post->ID, '_cpb_background_image', true);
            $foreground_image = get_post_meta($post->ID, '_cpb_foreground_image', true);
            if ($background_image) {
                echo '<style>.cpb-product-box-wrap { background-image: url(' . esc_url($background_image) . '); }</style>';
            }
            if ($foreground_image) {
                echo '<style>.custom-full-msg { background-image: url(' . esc_url($foreground_image) . '); }</style>';
            }           
        }
    }

    function override_original_plugin_scripts() {
        wp_register_script('custom-plugin-script', plugin_dir_url(__FILE__) . '../../assets/js/addItem.js', array('jquery'), '1.0', true);
        wp_enqueue_script('custom-plugin-script');
    }
    
}

new CPB_Box_Animations_Addon();
