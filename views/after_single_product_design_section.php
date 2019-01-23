<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<style type="text/css">
    .nbd-disclaimer-wrapper {
        display: none;
    }
    .nbd-additional-action {
        overflow: hidden;
        margin-bottom: 15px;
    }
    .nbd-additional-action:after {
        content: '';
        display: block;
        clear: both;
    }
    .nbd-save_for_later {
        float: left;
    }
    .nbd-pdf_preview {
        float: right;
    }
    .nbd-disclaimer-wrapper.show {
        display: block;
    }
    .nbc-hidden {
        display: none !important;
    }
</style>
<div class="nbd-disclaimer-wrapper">
    <p style="color: red;" class="nbd-disclaimer">
        <?php _e('PROOF AGREEMENT: I clicked PDF Preview on the previous screen and proofed my design. I have verified that spelling and contents are correct. I am satisfied with the document layout. I UNDERSTAND MATCH-UP WILL PRINT THE PRODUCT EXACTLY AS I HAVE PROVIDED. I understand no changes are allowed after checkout. Once the order is produced, Match-Up will only accept responsibility on claims where the product does not match the design provided at checkout. PROOF YOUR ORDER! We do not proof orders for you. You must proof your order beore you checkout!', 'web-to-print-online-designer'); ?>
    </p>
    <p style="color: red;" class="nbd-agreement">
        <?php _e('I clicked PDF Preview on the previous screen and reviewd my information for accuracy', 'web-to-print-online-designer'); ?>
        <input style="cursor: pointer;" type="checkbox" onclick="agreementBeforeAddToCart(this)"/>
    </p>
    <div class="nbd-additional-action">
        <a class="button alt nbd-save_for_later" onclick="NBDESIGNERPRODUCT.download_pdf(event)"><img class="nbd-pdf-loading hide" src="<?php echo NBDESIGNER_PLUGIN_URL.'assets/images/loading.gif' ?>"/> <?php _e('PDF preview', 'web-to-print-online-designer'); ?></a>
        <?php if( is_user_logged_in() ): ?>
        <a class="button alt nbd-pdf_preview" onclick="NBDESIGNERPRODUCT.save_for_later(event)"><img class="nbd-save-loading hide" src="<?php echo NBDESIGNER_PLUGIN_URL.'assets/images/loading.gif' ?>"/> <?php _e('Save for later', 'web-to-print-online-designer'); ?></a>
        <?php endif; ?>
    </div>
    <div style="display: none;text-align: right;" class="saved-design-link">
        <?php _e('Your design has been saved!', 'web-to-print-online-designer'); ?> <a href="<?php echo wc_get_endpoint_url( 'my-designs', '', wc_get_page_permalink( 'myaccount' ) ); ?>" target="_blank"><?php _e('View all', 'web-to-print-online-designer'); ?></a>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.single_add_to_cart_button').addClass("nbc-hidden");
    });
    jQuery(document).on('after_show_design_thumbnail', function(){
        jQuery('.nbd-disclaimer-wrapper').addClass('show');
    });
    window.agreementBeforeAddToCart = function( t ){
        console.log(jQuery(t).is(":checked"));
        if( jQuery(t).is(":checked") ){
            jQuery('.single_add_to_cart_button').removeClass("nbc-hidden");
        }else{
            jQuery('.single_add_to_cart_button').addClass("nbc-hidden");
        }
    };
</script> 