<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div class="nbd-qty-wrap temporary-hidden" >
    <?php _e('Qty','web-to-print-online-designer'); ?>
    <input type="number" min="1" step="1" class="nbd-qty" ng-model="resource.config.qtys[$index].value" ng-change="updateQtys()"/>
    <select class="nbd-qty-variation"  ng-if="resource.config.variations">
        <option ng-repeat="variation in resource.config.variations" value="{{variation.index}}">{{variation.name}}</option>
    </select>
</div>