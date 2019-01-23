<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div class="nbd-popup popup-select popup-nbd-delete-stage-alert" data-animate="scale">
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head">
            <?php _e('Delete this design','web-to-print-online-designer'); ?>
        </div>
        <div class="body">
            <div class="main-body">
                <span class="title"><?php _e('Are you sure you want to delete this design?','web-to-print-online-designer'); ?></span>
                <div class="main-select">
                    <button ng-click="closePopup('.popup-nbd-delete-stage-alert')" class="nbd-button select-no"><i class="icon-nbd icon-nbd-clear"></i> <?php _e('No','web-to-print-online-designer'); ?></button>
                    <button ng-click="removeStage()" class="nbd-button select-yes"><i class="icon-nbd icon-nbd-fomat-done"></i> <?php _e('Yes','web-to-print-online-designer'); ?></button>
                </div>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>