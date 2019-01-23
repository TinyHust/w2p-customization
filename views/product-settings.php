<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<?php
    $art_cat_path = NBDESIGNER_DATA_DIR . '/art_cat.json';
    $list_art_cats = (array)json_decode(file_get_contents($art_cat_path));
    $allow_all_art_cat =  false;
    if( !isset($option['art_cats']) ){
        $allow_all_art_cat = true;
        $option['art_cats'] = array();
    }
?>
<div class="nbdesigner-opt-inner">
    <div>
        <label for="nbdesigner_list_art_cats" class="nbdesigner-option-label"><?php _e('Clipart categories can use', 'web-to-print-online-designer'); ?></label>
        <select name="_nbdesigner_option[art_cats][]" multiple="" id="nbdesigner_list_art_cats" class="nbd-slect-woo" style="width: 500px;">
            <?php 
                foreach($list_art_cats as $art_cat ): 
                    $selected = ($allow_all_art_cat || in_array( $art_cat->id, $option['art_cats'] )) ? ' selected="selected" ' : ''; 
            ?>
            <option value="<?php echo $art_cat->id; ?>" <?php echo $selected; ?>><?php echo $art_cat->name; ?></option>
            <?php  endforeach; ?>
        </select>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery('.nbd-slect-woo').selectWoo();
    });
</script>