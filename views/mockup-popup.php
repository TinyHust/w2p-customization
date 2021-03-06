<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div class="nbd-popup popup-nbd-mockup-preview" data-animate="scale">
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="overlay-main active">
            <div class="loaded">
                <svg class="circular" viewBox="25 25 50 50" style="width: 40px;height: 40px;">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                </svg>
            </div>
        </div>
        <div class="head hidden-xs" style="font-size: 16px; font-weight: bold; margin-bottom: 15px;">
            <?php _e('Choose mockup style','web-to-print-online-designer'); ?>
        </div>
        <div class="body">
            <div class="main-body">
                <p class="hidden-xs"><?php _e('Content here','web-to-print-online-designer'); ?></p>
                <div class="mockup-wrap nbd-simple-slider" ng-class="!settings.is_mobile ? 'nbd-perfect-scroll' : ''">
                    <span class="prev nbs-slide-nav show-inline-on-mobile">&lt;</span>
                    <div style="overflow: hidden;">
                        <ul class="items">
                            <li class="mockup-preview item" ng-repeat="mockup in resource.mockups" ng-click="mockup.select = !mockup.select">
                                <div class="mockup-preview-wrap">
                                    <div class="nbd-checkbox hidden-on-mobile">
                                        <input id="mockup-{{$index}}" type="checkbox" ng-checked="mockup.select">
                                        <label for="mockup-{{$index}}">&nbsp;</label>
                                    </div>
                                    <img ng-src="{{mockup.src}}"/>
                                    <span class="mockup-name hidden-on-mobile">{{mockup.name}}</span>
                                </div>
                            </li>
                        </ul>
                    </div>  
                    <span class="next nbs-slide-nav show-inline-on-mobile">&gt;</span>
                </div>
                <div style="margin-top: 10px;">
                    <button class="nbd-button hidden-on-mobile" ng-click="downloadMockupPreview()"><?php _e('Download picture','web-to-print-online-designer'); ?></button>
                    <a ng-class="resource.social.wa_link != '' ? '' : 'nbd-disabled'" class="nbd-button show-inline-on-mobile whatsapp_share" href="#"  data-action="share/whatsapp/share">
                        <?php _e('Share','web-to-print-online-designer'); ?>
                        <svg style="vertical-align: baseline; height: 20px;" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <title>whatsapp</title>
                            <path fill="#25d366" d="M17.498 14.382c-0.301-0.15-1.767-0.867-2.040-0.966-0.273-0.101-0.473-0.15-0.673 0.15-0.197 0.295-0.771 0.964-0.944 1.162-0.175 0.195-0.349 0.21-0.646 0.075-0.3-0.15-1.263-0.465-2.403-1.485-0.888-0.795-1.484-1.77-1.66-2.070-0.174-0.3-0.019-0.465 0.13-0.615 0.136-0.135 0.301-0.345 0.451-0.523 0.146-0.181 0.194-0.301 0.297-0.496 0.1-0.21 0.049-0.375-0.025-0.524-0.075-0.15-0.672-1.62-0.922-2.206-0.24-0.584-0.487-0.51-0.672-0.51-0.172-0.015-0.371-0.015-0.571-0.015s-0.523 0.074-0.797 0.359c-0.273 0.3-1.045 1.020-1.045 2.475s1.070 2.865 1.219 3.075c0.149 0.195 2.105 3.195 5.1 4.485 0.714 0.3 1.27 0.48 1.704 0.629 0.714 0.227 1.365 0.195 1.88 0.121 0.574-0.091 1.767-0.721 2.016-1.426 0.255-0.705 0.255-1.29 0.18-1.425-0.074-0.135-0.27-0.21-0.57-0.345zM12.061 21.75h-0.016c-1.77 0-3.524-0.48-5.055-1.38l-0.36-0.214-3.75 0.975 1.005-3.645-0.239-0.375c-0.99-1.576-1.516-3.391-1.516-5.26 0-5.445 4.455-9.885 9.942-9.885 2.654 0 5.145 1.035 7.021 2.91 1.875 1.859 2.909 4.35 2.909 6.99-0.004 5.444-4.46 9.885-9.935 9.885zM20.52 3.449c-2.28-2.204-5.28-3.449-8.475-3.449-6.582 0-11.941 5.334-11.944 11.893 0 2.096 0.549 4.14 1.595 5.945l-1.696 6.162 6.335-1.652c1.746 0.943 3.71 1.444 5.71 1.447h0.006c6.585 0 11.946-5.336 11.949-11.896 0-3.176-1.24-6.165-3.495-8.411z"></path>
                        </svg>
                    </a>
                    <button class="nbd-button" ng-click="cancelMockupPreview()"><?php _e('Cancel','web-to-print-online-designer'); ?></button>
                </div>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>