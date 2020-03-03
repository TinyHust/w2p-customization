<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<script type="text/javascript">
    var nbd_redirect_link = "<?php echo $redirect_link; ?>";

    jQuery( document ).ready( function(){
        jQuery( '#triggerDesign' ).addClass('nbd-force-hiden');
        jQuery( '.quantity' ).addClass('nbd-force-hiden');
    } );

    function build_redirect_link(){
        if( !!window.nbOption ){
            var serialize = jQuery('[name^="nbd-field"]').serialize();
            if( jQuery('input[name="quantity"]').length > 0 ){
                var qty = jQuery('input[name="quantity"]').val();
                serialize += '&qty=' + qty;
            }
            var form_values = window.btoa( serialize );
            nbd_redirect_link += '&nbo_values=' + form_values;
        }
        return nbd_redirect_link;
    }

    function nbd_redirect( e ){
        e.preventDefault();
        window.location.href = build_redirect_link();
        return false;
    }

    jQuery('form .single_add_to_cart_button').on('click', function(e){
        nbd_redirect( e );
    });
    jQuery('.variations_form, form.cart').on('submit', function(e){
        nbd_redirect( e );
    });
</script>