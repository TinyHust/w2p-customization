<?php if (!defined('ABSPATH')) exit;  
    $new_side_name = isset($option['new_side_name']) ? $option['new_side_name'] : __('New', 'web-to-print-online-designer');
    $max_number_side = isset($option['max_number_side']) ? $option['max_number_side'] : 1;
    $additional_price = isset($option['additional_price']) ? $option['additional_price'] : 0;
?>
<div class="nbdesigner-opt-inner">
    <div>
        <label for="nbdesigner_new_side_name" class="nbdesigner-option-label"><?php _e('New side name', 'web-to-print-online-designer'); ?></label>
        <input type="text" class="short" id="nbdesigner_new_side_name"  name="_nbdesigner_option[new_side_name]" value="<?php echo $new_side_name; ?>" >
    </div>
</div>
<div class="nbdesigner-opt-inner">
    <div>
        <label for="nbdesigner_max_number_side" class="nbdesigner-option-label"><?php _e('Max number of sides', 'web-to-print-online-designer'); ?></label>
        <input type="number" step="1" min="0" class="short" id="nbdesigner_max_number_side"  name="_nbdesigner_option[max_number_side]" value="<?php echo $max_number_side; ?>" >
    </div>
</div>
<div class="nbdesigner-opt-inner">
    <div>
        <label for="nbdesigner_additional_price" class="nbdesigner-option-label"><?php _e('Additional price for a new  side', 'web-to-print-online-designer'); ?></label>
        <input type="number" step="any" class="short wc_input_price" id="nbdesigner_additional_price"  name="_nbdesigner_option[additional_price]" value="<?php echo $additional_price; ?>" >
    </div>
</div>