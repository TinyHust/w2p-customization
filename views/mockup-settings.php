<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<style>
    .nbd-mockup-preview-wrap {
        float: left;
    }
    .nbd-mockup-preview {
        float: left;
        width: 150px;
        height: 100px;
        position: relative;
        border-radius: 4px;
        border: 2px solid #fff;
        cursor: pointer;
        text-align: center;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    .nbd-mockup-preview .action {
        position: absolute;
        bottom: 3px;
        width: 100%;
        text-align: center;
        display: none;
        left: 0;
    }
    .nbd-mockup-preview:hover .action{
        display: inline-block;
    }
    .nbd-add-mockup {
        display: inline-block;
        border: 2px dashed #fff;
        border-radius: 4px;
        height: 100px;
        width: 100px;
        text-align: center;
        line-height: 100px;
        color: #555;
        float: left;
        cursor: pointer;
        margin-left: 5px;
    }
    .nbd-mockup-preview-config {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: -1;
        opacity: 0;
        width: 100vw;
        height: 100vh;
    }
    .nbd-mockup-preview-config.show {
        opacity: 1;
        z-index: 999999;
    }
    .nbd-mockup-preview-config-inner {
        position: relative;
        width: 100%;
        height: 100%;
    }
    .nbd-mockup-preview-backdrop {
        background: #000;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0.7;
    }
    .nbd-mockup-preview-con {
        background: #fff;
        position: absolute;
        box-sizing: border-box;
        top: 50%;
        left: 50%;
        width: 500px;
        height: 500px;
        border-radius: 4px;
        transform: translate(-300px, -250px);
    }
    .nbd-mockup-preview-con-wrap {
        position: relative;
        height: 100%;
        width: 100%;
    }
    .nbd-mockup-preview-con-wrap .close-config {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        width: 30px;
        height: 30px;
        font-size: 30px;
        line-height: 30px;
        z-index: 2;
    }
    .nbd-mockup-preview-con-inner {
        width: 100%;
        height: 100%;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }
    .nbd-mockup-preview-con-inner .nbd-mockup-placeholder{
        position: absolute;
        background: rgba(255,255,255,0.3);
        cursor: move;
    }
    .nbd-mockup-placeholder .ui-resizable-handle {
        background-color: #FFF;
        border: 2px solid #428BCA;
        height: 5px;
        width: 5px;
    }
    .nbd-mockup-placeholder .ui-resizable-handle.ui-resizable-se {
        bottom: -5px;
        right: -5px;
    }
    .nbd-mockup-align-wrap {
        width: 100%;
        height: 33.333333%;
    }
    .nbd-mockup-align {
        display: inline-block;
        width: 33.3333%;
        float: left;
        height: 100%;
        line-height: calc(100%);
        box-sizing: border-box;
        border: 1px solid #ddd;
        cursor: pointer;
    }
    .nbd-mockup-align.active {
        background: rgba(0,115,170,0.3);
    }
    .hidden_mockup_name {
        position: absolute;
        top: 40px;
        width: 100%;
        background: rgba(255,255,255,0.7) !important;
        left: -1px;
        box-shadow: none !important;
        border: none !important;
        text-align: center;
    }
</style>
<div class="nbdesigner-opt-inner">
    <label class="nbdesigner-option-label nbdesigner-setting-box-label"><?php  _e('Mockup preview', 'web-to-print-online-designer'); ?></label>
    <div style="float: left; display: inline-block;">
        <div class="nbd-mockup-preview-wrap" id="nbd-mockup-preview-wrap">
        <?php 
            $mockups = isset( $option['mockup_preview'] ) ? $option['mockup_preview'] : array(
                0 => array('sid' => 22,
                        'top' => 50,
                        'left' => 300,
                        'width' => 200,
                        'height' => 200,
                        'anchor'    => 'c',
                        's_top'    =>  0,
                        's_left'    =>  0,
                        's_width'    =>  500,
                        's_height'    =>  500,
                        'name'  => __('Enter mockup name', 'web-to-print-online-designer')
                    )
            );
            foreach( $mockups as $mk => $mockup ){
                $mk_src = is_numeric( $mockup['sid'] ) ? wp_get_attachment_url( $mockup['sid'] ) : '';
        ?>
            <div class="nbd-mockup-preview" data-index="<?php echo $mk; ?>">
                <img src="<?php echo $mk_src; ?>" style="max-width: 100%;max-height: 100%;" onclick="NBDESIGNADMIN.changeMockupImage(this)"/>
                <input class="hidden_mockup_name" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][name]" type="text" value="<?php echo $mockup['name']; ?>"/>
                <div class="action">
                    <a class="button nbd-config-mockup-preview" onclick="NBDESIGNADMIN.configMockup(this, true)" title="<?php _e('Config mockup', 'web-to-print-online-designer'); ?>">
                        <span class="dashicons dashicons-admin-generic" style="margin-top: 3px;"></span>
                    </a>
                    <a class="button nbd-change-mockup-preview" onclick="NBDESIGNADMIN.changeMockupImage(this)" title="<?php _e('Change image', 'web-to-print-online-designer'); ?>">
                        <span class="dashicons dashicons-update" style="margin-top: 3px;"></span>
                        <input type="hidden" data class="hidden_mockup_preview" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][sid]" value="<?php echo $mockup['sid']; ?>" >
                    </a>
                    <a class="button nbdesigner-delete" onclick="NBDESIGNADMIN.removeMockupImage(this)" title="<?php _e('Remove image', 'web-to-print-online-designer'); ?>">
                        <span class="dashicons dashicons-no-alt" style="margin-top: 3px;"></span>
                    </a>
                </div>
                <div class="nbd-mockup-preview-config">
                    <div class="nbd-mockup-preview-config-inner">
                        <div class="nbd-mockup-preview-backdrop" onclick="NBDESIGNADMIN.closeconfigMockup(this)"></div>
                        <div class="nbd-mockup-preview-con">
                            <div class="nbd-mockup-preview-con-wrap">
                                <span class="dashicons dashicons-no-alt close-config" onclick="NBDESIGNADMIN.closeconfigMockup(this)"></span>
                                <div class="nbd-mockup-preview-con-inner">
                                    <img src="<?php echo $mk_src; ?>" style="max-width: 100%;max-height: 100%;" />
                                    <input type="hidden" data class="hidden_mockup_anchor" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][anchor]" value="<?php echo $mockup['anchor']; ?>" >
                                    <input type="hidden" data class="hidden_mockup_top" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][top]" value="<?php echo $mockup['top']; ?>" >
                                    <input type="hidden" data class="hidden_mockup_left" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][left]" value="<?php echo $mockup['left']; ?>" >
                                    <input type="hidden" data class="hidden_mockup_width" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][width]" value="<?php echo $mockup['width']; ?>" >
                                    <input type="hidden" data class="hidden_mockup_height" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][height]" value="<?php echo $mockup['height']; ?>" >
                                    <input type="hidden" data class="hidden_mockup_s_top" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][s_top]" value="<?php echo $mockup['s_top']; ?>" >
                                    <input type="hidden" data class="hidden_mockup_s_left" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][s_left]" value="<?php echo $mockup['s_left']; ?>" >
                                    <input type="hidden" data class="hidden_mockup_s_width" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][s_width]" value="<?php echo $mockup['s_width']; ?>" >
                                    <input type="hidden" data class="hidden_mockup_s_height" name="_nbdesigner_option[mockup_preview][<?php echo $mk; ?>][s_height]" value="<?php echo $mockup['s_height']; ?>" >
                                    <div class="nbd-mockup-placeholder" style="width: <?php echo $mockup['width']; ?>px; height: <?php echo $mockup['height']; ?>px; top: <?php echo $mockup['top']; ?>px; left: <?php echo $mockup['left']; ?>px;">
                                        <div class="nbd-mockup-align-wrap">
                                            <div class="nbd-mockup-align <?php if($mockup['anchor'] == 'nw'){ echo 'active'; }; ?>" onclick="NBDESIGNADMIN.setMockupAnchor(this, 'nw')" title="<?php _e('Anchor top left', 'web-to-print-online-designer'); ?>"></div>
                                            <div class="nbd-mockup-align <?php if($mockup['anchor'] == 'n'){ echo 'active'; }; ?>" onclick="NBDESIGNADMIN.setMockupAnchor(this, 'n')" title="<?php _e('Anchor top', 'web-to-print-online-designer'); ?>"></div>
                                            <div class="nbd-mockup-align <?php if($mockup['anchor'] == 'ne'){ echo 'active'; }; ?>" onclick="NBDESIGNADMIN.setMockupAnchor(this, 'ne')" title="<?php _e('Anchor top right', 'web-to-print-online-designer'); ?>"></div>
                                        </div>
                                        <div class="nbd-mockup-align-wrap">
                                            <div class="nbd-mockup-align <?php if($mockup['anchor'] == 'w'){ echo 'active'; }; ?>" onclick="NBDESIGNADMIN.setMockupAnchor(this, 'w')" title="<?php _e('Anchor left', 'web-to-print-online-designer'); ?>"></div>
                                            <div class="nbd-mockup-align  <?php if($mockup['anchor'] == 'c'){ echo 'active'; }; ?>" onclick="NBDESIGNADMIN.setMockupAnchor(this, 'c')" title="<?php _e('Anchor center', 'web-to-print-online-designer'); ?>"></div>
                                            <div class="nbd-mockup-align <?php if($mockup['anchor'] == 'e'){ echo 'active'; }; ?>" onclick="NBDESIGNADMIN.setMockupAnchor(this, 'e')" title="<?php _e('Anchor right', 'web-to-print-online-designer'); ?>"></div>
                                        </div>
                                        <div class="nbd-mockup-align-wrap">
                                            <div class="nbd-mockup-align <?php if($mockup['anchor'] == 'ws'){ echo 'active'; }; ?>" onclick="NBDESIGNADMIN.setMockupAnchor(this, 'ws')" title="<?php _e('Anchor bottom left', 'web-to-print-online-designer'); ?>"></div>
                                            <div class="nbd-mockup-align <?php if($mockup['anchor'] == 's'){ echo 'active'; }; ?>" onclick="NBDESIGNADMIN.setMockupAnchor(this, 's')" title="<?php _e('Anchor bottom', 'web-to-print-online-designer'); ?>"></div>
                                            <div class="nbd-mockup-align <?php if($mockup['anchor'] == 'se'){ echo 'active'; }; ?>" onclick="NBDESIGNADMIN.setMockupAnchor(this, 'se')" title="<?php _e('Anchor bottom right', 'web-to-print-online-designer'); ?>"></div>
                                        </div>                                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }; ?>
        </div>
        <a class="nbd-add-mockup" onclick="NBDESIGNADMIN.addMockupImage()" title="<?php _e('Add more', 'web-to-print-online-designer'); ?>">
            <span class="dashicons dashicons-plus" style="line-height: 100px;"></span>
        </a>
        <div class="nbdesigner-clearfix"></div>
    </div>
</div>