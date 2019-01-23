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
            
            add_action('nbd_before_option_product_design', array($this, 'utrophy_mockup_setting'), 10, 3);
            add_action('nbd_modern_extra_popup', array($this, 'utrophy_delete_stage'), 20, 3);
            add_action('nbd_modern_extra_popup', array($this, 'utrophy_mockup_popup'), 10);
            add_action('nbd_modern_extra_stages', array($this, 'utrophy_mockup_button'), 10);
            //add_action('nbd_modern_before_stage', array($this, 'utrophy_before_stage'), 10);
            add_action('nbd_modern_extra_stages', array($this, 'utrophy_after_stage'), 10);
            add_action('nbd_modern_extra_page_toolbar', array($this, 'utrophy_page_toolbar'), 10);
            add_filter('nbdesigner_general_settings', array($this, 'utrophy_general_settings'), 10, 1);
            add_filter('nbdesigner_default_frontend_settings', array($this, 'utrophy_default_frontend_settings'), 10, 1);
        } 
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