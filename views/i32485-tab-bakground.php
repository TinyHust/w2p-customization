<div class="tab" id="tab-background">
    <div class="tab-main tab-scroll" style="padding: 15px 10px;">
        <ul class="main-color-palette nbd-perfect-scroll" >
            <li class="color-palette-add" ng-click="showBgColorPalette()" ng-style="{'background-color': currentColor}"></li>
            <li ng-repeat="color in listAddedColor track by $index" ng-click="changeBackgroundCanvas(color)" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background-color': color}"></li>
            <li ng-repeat="color in resource.defaultPalette[0] track by $index" ng-click="changeBackgroundCanvas(color)" class="color-palette-item" data-color="{{color}}" title="{{color}}" ng-style="{'background': color}"></li>
        </ul>
        <div class="nbd-text-color-picker" id="nbd-bg-color-picker" ng-class="showBgColorPicker ? 'active' : ''" >
            <spectrum-colorpicker
                ng-model="currentColor"
                options="{
                    preferredFormat: 'hex',
                    color: '#fff',
                    flat: true,
                    showButtons: false,
                    showInput: true,
                    containerClassName: 'nbd-sp'
                }">
            </spectrum-colorpicker>
            <div style="text-align: <?php echo (is_rtl()) ? 'right' : 'left'?>">
                <button class="nbd-button" ng-click="addColor();changeBackgroundCanvas(currentColor);"><?php esc_html_e('Choose','web-to-print-online-designer'); ?></button>
            </div>
        </div>
        <div class="nbd-background-wrap">
            <div class="nbd-background loading" ng-click="changeBackgroundImg( bg )" ng-repeat="bg in resource.background" data-src="{{bg.thumbnail}}"></div>
        </div>
    </div>
</div>