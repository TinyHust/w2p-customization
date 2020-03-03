<?php
/**
 * @package Nbdesigner
 */
/*
Plugin Name: NBDesigner Customize
Plugin URI: https://cmsmart.net/wordpress-plugins/woocommerce-online-product-designer-plugin
Description: NBDesigner Customize.
Version: 1.0.0
Author: Netbaseteam
Author URI: http://netbaseteam.com/
License: GPLv2 or later
Text Domain: w2p-customize
Domain Path: /langs
WC requires at least: 3.0.0
WC tested up to: 3.5.0
*/

if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
if ( ! defined( 'W2P_NBD_PLUGIN_DIR' ) ) {
    define( 'W2P_NBD_PLUGIN_DIR', plugin_dir_path(__FILE__) );
}
if ( ! defined( 'W2P_NBD_PLUGIN_URL' ) ) {
    define( 'W2P_NBD_PLUGIN_URL', plugin_dir_url(__FILE__) );
}
if(!class_exists('W2P_NBD_CUSTOMIZE')){
    class W2P_NBD_CUSTOMIZE {
        protected static $instance;
        public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }
        public function init(){
            //add_action('nbd_after_option_product_design', array($this, 'product_design_setting'), 10, 3);
            //add_action('nbd_modern_extra_menu', array($this, 'nbd_modern_extra_menu'), 10, 3);
            //add_action('nbd_modern_extra_popup', array($this, 'nbd_modern_extra_popup'), 10, 3);
            //add_action('nbd_modern_before_layer_common_menu', array($this, 'nbd_modern_before_layer_common_menu'), 10, 3);
            //add_action('nbd_after_single_product_design_section', array($this, 'after_single_product_design_section'), 10, 2);
            
            //add_action('nbd_before_option_product_design', array($this, 'utrophy_mockup_setting'), 10, 3);
            //add_action('nbd_modern_extra_popup', array($this, 'utrophy_delete_stage'), 20, 3);
            //add_action('nbd_modern_extra_popup', array($this, 'utrophy_mockup_popup'), 10);
            //add_action('nbd_modern_extra_stages', array($this, 'utrophy_mockup_button'), 10);
            //add_action('nbd_modern_before_stage', array($this, 'utrophy_before_stage'), 10);
            //add_action('nbd_modern_extra_stages', array($this, 'utrophy_after_stage'), 10);
            //add_action('nbd_modern_extra_page_toolbar', array($this, 'utrophy_page_toolbar'), 10);
            //add_filter('nbdesigner_general_settings', array($this, 'utrophy_general_settings'), 10, 1);
            //add_filter('nbdesigner_default_frontend_settings', array($this, 'utrophy_default_frontend_settings'), 10, 1);
            
            //add_action('nbd_modern_extra_popup', array($this, 'i26869_delete_stage'), 20, 3);
            //add_action('nbd_modern_extra_page_toolbar', array($this, 'i26869_page_toolbar'), 10);
            //add_action('nbd_modern_extra_stages', array($this, 'i26869_after_stage'), 10);
            //add_action('nbd_before_option_product_design', array($this, 'i26869_design_setting'), 10, 3);

            if (is_admin()) {
                $this->ajax();
            }

            /*
            add_action('nbd_after_admin_tools', array($this, 'i32485_after_admin_tools'), 10);
            add_action('nbd_loaded', array($this, 'i32485_create_background_folder'), 10);
            add_action('nbd_js_config', array($this, 'i32485_js_config'), 10);
            add_action('nbd_editor_extra_tab_nav', array($this, 'i32485_tab_nav'), 20);
            add_action('nbd_editor_extra_tab_content', array($this, 'i32485_tab_content'), 10);
            apply_filter( 'nbd_customize_ajax_events', array( $this, 'i32485_ajax_events' ) );
            */

            add_action('nbd_editor_extra_tab_nav', array($this, 'i32050_tab_nav'), 20);
            add_action('nbd_editor_extra_tab_content', array($this, 'i32050_tab_content'), 10);
            add_action('nbd_modern_before_design_wrap', array($this, 'i32050_before_design_wrap'), 10);
            add_action('nbd_modern_after_design_wrap', array($this, 'i32050_after_design_wrap'), 10);
            add_action('nbd_extra_js', array($this, 'i32050_extra_js'), 10);
            add_action('nbd_extra_css', array($this, 'i32050_extra_css'), 10);
            //add_action('nbd_editor_process_action', array($this, 'i32050_process_action'), 10);
            add_filter( 'nbo_product_options', array( $this, 'i32050_nbo_product_options' ), 20, 2 );
            add_action( 'after_nbd_save_customer_design', array( $this, 'i32050_save_contour_file' ), 20, 1 );
            add_action( 'nbd_synchronize_output', array( $this, 'i32050_change_order_status' ), 20, 3 );
            add_filter( 'nbd_synchronize_files', array( $this, 'i32050_synchronize_files' ), 10, 5 );
            add_action( 'init', array( $this, 'i32050_register_order_status' ) );
            add_filter( 'wc_order_statuses', array( $this, 'i32050_wc_order_statuses' ) );
            add_action( 'woocommerce_before_add_to_cart_button', array($this, 'i32050_before_add_to_cart_button'), 30 );
            add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'i32050_add_to_cart_text' ), 9999, 1 );
        }
        public function ajax(){
            $ajax_events = array();
            $ajax_events = apply_filters( 'nbd_customize_ajax_events', $ajax_events);
            foreach( $ajax_events as $ajax_event => $nopriv ) {
                add_action( 'wp_ajax_' . $ajax_event, array( $this, $ajax_event ) );
                if ($nopriv) {
                    add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $ajax_event ) );
                }
            }
        }

        function i32050_tab_nav(){
            $animation_dir = 'slideInLeft';
            ?>
            <li id="nav-contour" class="tab animated <?php esc_attr_e( $animation_dir ); ?> animate800" ><i class="icon-nbd icon-nbd-bottom-center"></i><span><?php esc_html_e('Cutline','web-to-print-online-designer'); ?></span></li>
            <li id="nav-background" ng-class="getBackgroundTabClass()" class="tab animated <?php esc_attr_e( $animation_dir ); ?> animate800" ><i class="icon-nbd icon-nbd-fill-color"></i><span><?php esc_html_e('Background','web-to-print-online-designer'); ?></span></li>
            <?php
        }
        function i32050_tab_content(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/i32050-tab-contour.php');
            include_once(W2P_NBD_PLUGIN_DIR . 'views/i32050-tab-bakground.php');
        }
        function i32050_before_design_wrap(){
            ?>
            <div class="nbd-stage-pattern" ng-class="!!cutlines[$index] && !!cutlines[$index].contour ? 'active' : ''"></div>
            <?php
        }
        function i32050_after_design_wrap(){
            ?>
            <div class="contour-wrap" ng-class="!!cutlines[$index] && !!cutlines[$index].contour ? 'active' : ''"></div>
            <?php
        }
        function i32050_extra_js(){
            ?>
            <script type="text/javascript" src="<?php echo W2P_NBD_PLUGIN_URL .'assets/js/contour.js'; ?>"></script>
            <script type="text/javascript" src="<?php echo W2P_NBD_PLUGIN_URL .'assets/js/i32050_extra.js'; ?>"></script>
            <?php
        }
        function i32050_extra_css(){
            ?>
            <link type="text/css" href="<?php echo W2P_NBD_PLUGIN_URL .'assets/css/i32050_extra.css'; ?>" rel="stylesheet" media="all">
            <?php
        }
        function i32050_process_action( $process_action ){
            $process_action = 'saveDataWithContour()';
            return $process_action;
        }
        function i32050_nbo_product_options( $options, $product_id ){
            foreach ($options['fields'] as $key => $field){
                if( isset($field['general']['attributes']['bg_type']) && $field['general']['attributes']['bg_type'] == 'i' ){
                    foreach ($field['general']['attributes']['options'] as $op_index => $option ){
                        foreach( $option['bg_image'] as $bg_index => $bg ){
                            $attachment_id = absint($bg);
                            if( $attachment_id ){
                                $full_src   = wp_get_attachment_image_src( $attachment_id, 'large' );
                                $path       = get_attached_file( $attachment_id );
                                $type       = pathinfo( $path, PATHINFO_EXTENSION );
                                $data       = file_get_contents( $path );
                                $base64     = 'data:image/' . $type . ';base64,' . base64_encode( $data );

                                $options['fields'][$key]['general']['attributes']['options'][$op_index]['pattern'][$bg_index] = array(
                                    'pattern_src'      => $base64,
                                    'pattern_url'      => $full_src[0],
                                    'pattern_width'    => $full_src[1],
                                    'pattern_height'   => $full_src[2]
                                );
                            }else{
                                $options['fields'][$key]['general']['attributes']['options'][$op_index]['pattern'][$bg_index] = array(
                                    'pattern_src'      => '',
                                    'pattern_url'      => '',
                                    'pattern_width'    => 0,
                                    'pattern_height'   => 0
                                );
                            }
                        }
                    };
                }
            }
            return $options;
        }
        function i32050_save_contour_file( $result ){
            $nbd_item_key   = $result['folder'];
            $path           = NBDESIGNER_CUSTOMER_DIR . '/' . $nbd_item_key;
            $path_config    = $path . '/config.json';
            $config         = nbd_get_data_from_json( $path_config );
            if( isset( $config->cutlines ) ){
                $cutlines = (array) $config->cutlines;
                foreach( $cutlines as $key => $cutline ){
                    $cutline_path = $path . '/contour_' . $key . '.svg';
                    file_put_contents( $cutline_path, rawurldecode( $cutline ) );
                }
            }
        }
        function i32050_change_order_status( $nbd_item_key, $order_id, $order_item_id ){
            $order = wc_get_order( $order_id );
            $order->update_status( 'nbd-production' );
        }
        function i32050_synchronize_files( $files, $root_path, $nbd_item_key, $order_id, $order_item_id ){
            $path               = NBDESIGNER_CUSTOMER_DIR .'/'. $nbd_item_key . '/contour_frame_0.svg';
            $destination_path   = $root_path . $order_id .'/'. $order_item_id .'/cutline.svg';
            if( file_exists( $path ) ){
                $files[] =  array(
                    'src'   => $path,
                    'dst'   => $destination_path
                );
            }
            return $files;
        }
        function i32050_register_order_status(){
            register_post_status( 'wc-nbd-production', array(
                'label'                     => __( 'Production', 'web-to-print-online-designer' ),
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( 'Production <span class="count">(%s)</span>', 'Production <span class="count">(%s)</span>', 'web-to-print-online-designer' )
            ) );
        }
        function i32050_wc_order_statuses( $order_statuses ){
            $order_statuses['wc-nbd-production']  = __( 'Production', 'web-to-print-online-designer' );
            return $order_statuses;
        }
        function i32050_before_add_to_cart_button(){
            $post_id        = get_the_ID();
            $post_id        = get_wpml_original_id( $post_id );
            $redirect_link  = add_query_arg( array(
                'product_id'    => $post_id,
                'view'          => 'm'
            ), getUrlPageNBD( 'create' ) );
            include_once( W2P_NBD_PLUGIN_DIR . 'views/i32050_before_add_to_cart.php' );
        }
        function i32050_add_to_cart_text(){
            return esc_attr__( 'Get start', 'web-to-print-online-designer' );
        }

        /* ================================== */

        function i32485_ajax_events( $ajax_events ){
            $ajax_events['nbd_i32485_update_backgrouds'] = true;
            return $ajax_events;
        }
        function i32485_after_admin_tools(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/i32485_admin_tools.php');
        }
        function nbd_i32485_update_backgrouds(){
            $current    = absint( $_POST['current'] );
            $path       = NBDESIGNER_DATA_DIR . '/backgrounds';
            $data_path  = NBDESIGNER_DATA_DIR . '/backgrounds/list.json';
            $list       = array();
            $res        = array(
                'total' => 0,
                'flag'  => 0
            );
            $data       = array();
            if( file_exists( $data_path ) ){
                $data = json_decode( file_get_contents( $data_path ) );
            }

            if( file_exists( $path ) ){
                $list = Nbdesigner_IO::get_list_images( $path, 1 );
                $list = array_values( $list );
            }
            if( count( $list ) ){
                $res['total']   = count( $list );
                $current_path   = $list[ $current ];
                list( $width, $height )     = getimagesize( $current_path );
                $infos          = pathinfo( $current_path );

                $preview_path       = $infos['dirname'] . '/preview/' . $infos['basename'];
                $thumbnail_path     = $infos['dirname'] . '/thumbnail/' . $infos['basename'];
                $preview_size       = apply_filters( 'nbd_max_photo_thumb_size', 800 );
                $thumb_size         = 100;
                $previewAvailable   = 0;
                if( $width > $preview_size || $height > $preview_size ){
                    $previewAvailable   = 1;
                }

                if( !( file_exists( $preview_path ) && file_exists( $thumbnail_path ) ) ){
                    if( $width > $preview_size || $height > $preview_size ){
                        if( $infos['extension'] == 'png' ){
                            NBD_Image::nbdesigner_resize_imagepng( $current_path, $preview_size, $preview_size, $preview_path );
                        } else {
                            NBD_Image::nbdesigner_resize_imagejpg( $current_path, $preview_size, $preview_size, $preview_path );
                        }
                    }else{
                        copy( $current_path, $preview_path );
                    }

                    if( $width > $thumb_size || $height > $thumb_size ){
                        if( $infos['extension'] == 'png' ){
                            NBD_Image::nbdesigner_resize_imagepng( $current_path, $thumb_size, $thumb_size, $thumbnail_path );
                        } else {
                            NBD_Image::nbdesigner_resize_imagejpg( $current_path, $thumb_size, $thumb_size, $thumbnail_path );
                        }
                    }else{
                        copy( $current_path, $thumbnail_path );
                    }
                }

                if( file_exists( $preview_path ) && file_exists( $thumbnail_path ) ){
                    $res['flag']        = 1;
                    $data[ $current ]   = array(
                        'src'               => Nbdesigner_IO::wp_convert_path_to_url( $current_path ),
                        'preview'           => Nbdesigner_IO::wp_convert_path_to_url( $preview_path ),
                        'thumbnail'         => Nbdesigner_IO::wp_convert_path_to_url( $thumbnail_path ),
                        'width'             => $width,
                        'height'            => $height,
                        'previewAvailable'  => $previewAvailable
                    );
                }else{
                    $res['mes']        = __('Try again later!', 'web-to-print-online-designer');
                }
                file_put_contents( $data_path, json_encode( $data ) );
            }

            echo json_encode( $res );
            wp_die();
        }
        function i32485_create_background_folder(){
            $path = NBDESIGNER_DATA_DIR . '/backgrounds';
            if( !file_exists( $path ) ){
                wp_mkdir_p( $path );
            }

            $path_preview   = NBDESIGNER_DATA_DIR . '/backgrounds/preview';
            if( !file_exists( $path_preview ) ){
                wp_mkdir_p( $path_preview );
            }

            $path_thumbnail = NBDESIGNER_DATA_DIR . '/backgrounds/thumbnail';
            if( !file_exists( $path_thumbnail ) ){
                wp_mkdir_p( $path_thumbnail );
            }
        }
        function i32485_js_config(){
            $data_path  = NBDESIGNER_DATA_DIR . '/backgrounds/list.json';
            $data       = json_encode( array() );
            if( file_exists( $data_path ) ){
                $data = file_get_contents( $data_path );
            }
            ?>
                NBDESIGNCONFIG.backgroundList = <?php echo $data; ?>;
            <?php
        }
        function i32485_tab_nav(){
            $animation_dir = 'slideInLeft';
            ?>
            <li id="nav-background" class="tab animated <?php esc_attr_e( $animation_dir ); ?> animate800" ><i class="icon-nbd icon-nbd-fill-color"></i><span><?php esc_html_e('Background','web-to-print-online-designer'); ?></span></li>
            <?php
        }
        function i32485_tab_content(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/i32485-tab-bakground.php');
        }

        /* ================================== */

        function i26869_delete_stage(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/confirm-delete-stage.php');
        }
        function i26869_page_toolbar(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/page-toolbar.php');
        }
        function i26869_after_stage(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/after-stage.php');
        }
        public function i26869_design_setting( $post_id, $option, $designer_setting ){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/i26869-product-settings.php');
        }

        /* ================================== */
        
        public function utrophy_default_frontend_settings( $settings ){
            $settings['nbdesigner_auto_save_draft'] = 'yes';
            $settings['nbdesigner_enable_duplicate_design'] = 'yes';
            $settings['nbdesigner_enable_load_all_design'] = 'yes';
            return $settings;
        }
        public function utrophy_general_settings( $settings ){
            $settings['customization'] = array(
                array(
                    'title' => __( 'Auto save draft design', 'web-to-print-online-designer'),
                    'description'   => '',
                    'id' 		=> 'nbdesigner_auto_save_draft',
                    'default' => 'yes',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', 'web-to-print-online-designer'),
                        'no' => __('No', 'web-to-print-online-designer'),
                    )
                ),
                array(
                    'title' => __( 'Enable duplicate design', 'web-to-print-online-designer'),
                    'description'   => '',
                    'id' 		=> 'nbdesigner_enable_duplicate_design',
                    'default' => 'yes',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', 'web-to-print-online-designer'),
                        'no' => __('No', 'web-to-print-online-designer'),
                    )
                ),
                array(
                    'title' => __( 'Enable load stored design from all products', 'web-to-print-online-designer'),
                    'description'   => '',
                    'id' 		=> 'nbdesigner_enable_load_all_design',
                    'default' => 'yes',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', 'web-to-print-online-designer'),
                        'no' => __('No', 'web-to-print-online-designer'),
                    )
                )
            );
            return $settings;
        }
        function utrophy_delete_stage(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/confirm-delete-stage.php');
        }
        function utrophy_mockup_button(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/mockup-button.php');
        }
        function utrophy_mockup_popup(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/mockup-popup.php');
        }
        function utrophy_mockup_setting( $post_id, $option, $designer_setting ){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/mockup-settings.php');
        }
        function utrophy_before_stage(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/before-stage.php');
        }
        function utrophy_after_stage(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/after-stage.php');
        }
        function utrophy_page_toolbar(){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/page-toolbar.php');
        }
        function nbd_modern_before_layer_common_menu(){
            ?>
            <li ng-if="!settings.is_mobile" class="menu-item item-opacity" ng-click="deleteLayers()">
                <i class="icon-nbd icon-nbd-delete nbd-tooltip-hover" title="<?php _e('Delete','web-to-print-online-designer'); ?>"></i>
            </li>
            <?php
        }
        function nbd_modern_extra_menu(){
            ?>
            <li class="menu-item nbd-popup-tigger" data-popup="popup-nbd-extra-popup">
                <span class="nbd-tooltip-hover-right" title="<?php _e('Help','web-to-print-online-designer'); ?>"><i class="icon-nbd icon-nbd-images"></i></span>
            </li>
            <?php
        }
        function nbd_modern_extra_popup(){
            ?>
            <div class="nbd-popup popup-nbd-extra-popup" data-animate="scale">
                <div class="main-popup">
                    <i class="icon-nbd icon-nbd-clear close-popup"></i>
                    <div class="head">
                        <?php _e('Help','web-to-print-online-designer'); ?>
                    </div>
                    <div class="body">
                        <div class="main-body">
                            <?php _e('Content here','web-to-print-online-designer'); ?>
                        </div>
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
            <?php
        }
        public function product_design_setting( $post_id, $option, $designer_setting ){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/product-settings.php');
        }  
        public function after_single_product_design_section( $pid, $option ){
            include_once(W2P_NBD_PLUGIN_DIR . 'views/after_single_product_design_section.php');
        }
    }
}
$w2p_nbd_cuz = W2P_NBD_CUSTOMIZE::instance();
$w2p_nbd_cuz->init();