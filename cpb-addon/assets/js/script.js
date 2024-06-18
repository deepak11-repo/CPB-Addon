jQuery(document).ready(function($) {
    function toggleImageFields() {
        if ($('#cpb_enable_box_animations').is(':checked')) {
            $('#cpb_image_fields').show();
        } else {
            $('#cpb_image_fields').hide();
        }
    }
    toggleImageFields();
    $('#cpb_enable_box_animations').change(function() {
        toggleImageFields();
    });
});



