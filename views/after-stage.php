<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div ng-if="!settings.is_mobile" class="nbd-add-stage temporary-hidden" ng-click="addStage(true)" ng-show="resource.canAdd">
    <?php _e('+Duplicate Design','web-to-print-online-designer'); ?>
</div>

