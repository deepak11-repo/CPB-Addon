<?php
/**
 * Progress Section.
 *
 * This template can be overridden by copying it to yourtheme/custom-product-boxes/single-product/cpb-progress-wrap.php
 *
 * HOWEVER, on occasion Custom Product Boxes will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package CPB/Templates
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<div class="<?php echo esc_attr( apply_filters( 'cpb_progress_wrap_classes', 'progress-wrap' ) ); ?>" <?php echo esc_attr( apply_filters( 'cpb_progress_wrap_data_attributes', '' ) ); ?> >
    <div class="cpb-filled-progress">
        <div class="cpb-box-count">
            <span class="cpb-filled-count"><b>0</b></span>
            <span class="cpb-slash">/</span>
            <span class="cpb-total-count"><?php echo esc_html( $product->get_box_capacity() ); ?></span>
        </div>
        <div class="cpb-progress-bar">
            <div class="cpb-filled-part">
                
            </div>
        </div>
    </div>
    <div class="cpb-calculated-price-wrap">
        <span class="cpb-calculated-label"><?php echo esc_html( CPB_Settings::get_cpb_setting( 'cpb_grand_total_label' ) ); ?></span>
        <span class="cpb-calculated-price"><?php echo wp_kses_post( strip_tags( wc_price( wc_get_price_to_display( $product ) ) ) ); ?></span>
    </div>
    <?php do_action( 'cpb_accessibility_wrap', $product ); ?>
    
    <div class="custom-full-msg">
    </div>

</div>

<script>
    jQuery(document).ready(function($) {
        // Store the initial value of .cpb-box-quantity-field-input input.qty
        var total_boxes = parseInt(jQuery('.cpb-box-quantity-field-input input.qty').val());
        console.log('Total Boxes:', total_boxes);

        // Bind a click event handler to .cpb-img-overlay
        jQuery(document).on('click', '.cpb-products-wrap .cpb-img-overlay', function() {
            // Increment the value of total_boxes
            total_boxes++;
            console.log('Total Boxes incremented:', total_boxes);

            // Update the value of .cpb-box-quantity-field-input input.qty
            jQuery('.cpb-box-quantity-field-input input.qty').val(total_boxes);

            // Check if total_boxes equals filled when a click event occurs
            checkFullMsgVisibility();
        });

        // Bind a click event handler to .cpb-refresh
        jQuery(document).on('click', '.cpb-refresh', function() {
            var total_items = 0;
            jQuery(".cpb-products-wrap .cpb-product-inner").each(function(index, element) {
                total_items += parseInt(jQuery(element).attr('data-count'));
            });
            // Set total_boxes to 0
            total_boxes = 0;
            console.log('Total Boxes reset to 0');
            // Update the value of .cpb-box-quantity-field-input input.qty to 0
            jQuery('.cpb-box-quantity-field-input input.qty').val(total_boxes);
            // Hide the full message
            $('.custom-full-msg').hide();
        });


        // Function to check visibility of the full message
        function checkFullMsgVisibility() {
            var total_items = 0;
            var total_boxes = $('.cpb-product-box-wrap .cpb-empty-box-inner').length;        
            jQuery(".cpb-products-wrap .cpb-product-inner").each(function(index, element) {
                total_items += parseInt(jQuery(element).attr('data-count'));
            });

            // If total_items equals total_boxes, show the message
            if (total_items === total_boxes) {
                $('.custom-full-msg').show();
                console.log('FULL');
            } else {
                $('.custom-full-msg').hide();
            }
        }
    });
</script>

<?php
