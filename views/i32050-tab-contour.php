<div class="tab" id="tab-contour">
    <div class="tab-main tab-scroll contour-type-wrap">
        <div class="contour-type" ng-class="currentContourType == 's' ? 'active' : ''" ng-click="initContour('s')">
            <svg viewBox="0 0 512 512" xml:space="preserve"><path fill="#404762" d="M432.7,404.7c-10.3-8.1-22.8-13.9-36.3-16.8l-64.6-13c-6.8-1.3-11.7-7.4-11.7-14.4v-14.8 c4.2-5.8,8.1-13.6,12.2-21.7c3.2-6.3,8-15.7,10.4-18.2c13.1-13.1,25.7-27.9,29.7-47c3.7-17.9,0.1-27.2-4.2-34.8 c0-18.8-0.6-42.4-5-59.6c-0.5-23.2-4.7-36.3-15.4-47.7c-7.5-8.1-18.5-10-27.4-11.5c-3.5-0.6-8.3-1.4-10.1-2.4 c-15.7-8.5-31.2-12.6-49.8-13c-38.8,1.6-86.5,26.3-102.5,70.3c-5,13.4-4.5,35.4-4,53.1l-0.4,10.6c-3.8,7.4-7.5,16.9-3.9,34.8 c3.9,19.1,16.5,33.9,29.9,47.2c2.2,2.2,7.1,11.8,10.3,18.1c4.2,8.1,8.1,15.8,12.3,21.6v14.8c0,7-4.9,13.1-11.7,14.4l-64.7,13 c-13.5,2.9-26,8.6-36.2,16.7c-3.2,2.6-8.4,19.5-8.7,23.6c-0.3,4.1-4,52.2,3.4,51.9c101.8,0,118.1,3,184.2,3s111.3,2.8,179.9,2.8 C451.4,463,448.3,443.4,432.7,404.7z"/><path fill="none" stroke="#ff00ff" stroke-width="7" stroke-miterlimit="10" d="M478,483.2l-5.1-47.3c-0.4-4.5-11.5-36.5-21.6-46c-13.3-12.4-47.7-25.2-68-26.9l-33.8-4.3 c-10.6-4.3-8.8-7.1-3.8-16c3.9-6.9,15.5-23.3,18.4-26c16.1-14.5,29.2-35.6,34-56.6c4.5-19.7-0.9-34.7-6.1-43.1 c0-20.8-0.1-41.7-5.6-60.6c-0.7-25.6-5-43.3-18.1-55.9c-9.2-8.9-19.8-15.1-30.7-16.7c-4.3-0.7-14.1-3.5-16.3-4.5 c-19.4-9.4-40.4-10.7-63.3-11c-47.9,1.8-98.4,27.6-118.1,76.1c-6.1,14.8-9.1,39.1-8.1,60.1l2,20c-4.7,8.2-10.6,12.8-6.1,32.6 c4.8,21,15.4,36.4,31.8,51.1c2.7,2.5,8.7,14,12.7,20.9c7.7,14,6.3,24.7,6.3,24.7c0,7.8-59.6,12-69.4,15.7l-25.6,13.9 c-16,15-22.2,22.2-25.8,38.3c-2,5.3-0.3,13.8-0.7,18.3L57,480.5"/></svg>
            <span><?php _e('Small','web-to-print-online-designer'); ?></span>
        </div>
        <div class="contour-type" ng-class="currentContourType == 'm' ? 'active' : ''" ng-click="initContour('m')">
            <svg viewBox="0 0 512 512" xml:space="preserve"><path fill="#404762" d="M432.7,404.7c-10.3-8.1-22.8-13.9-36.3-16.8l-64.6-13c-6.8-1.3-11.7-7.4-11.7-14.4v-14.8 c4.2-5.8,8.1-13.6,12.2-21.7c3.2-6.3,8-15.7,10.4-18.2c13.1-13.1,25.7-27.9,29.7-47c3.7-17.9,0.1-27.2-4.2-34.8 c0-18.8-0.6-42.4-5-59.6c-0.5-23.2-4.7-36.3-15.4-47.7c-7.5-8.1-18.5-10-27.4-11.5c-3.5-0.6-8.3-1.4-10.1-2.4 c-15.7-8.5-31.2-12.6-49.8-13c-38.8,1.6-86.5,26.3-102.5,70.3c-5,13.4-4.5,35.4-4,53.1l-0.4,10.6c-3.8,7.4-7.5,16.9-3.9,34.8 c3.9,19.1,16.5,33.9,29.9,47.2c2.2,2.2,7.1,11.8,10.3,18.1c4.2,8.1,8.1,15.8,12.3,21.6v14.8c0,7-4.9,13.1-11.7,14.4l-64.7,13 c-13.5,2.9-26,8.6-36.2,16.7c-3.2,2.6-8.4,19.5-8.7,23.6c-0.3,4.1-4,52.2,3.4,51.9c101.8,0,118.1,3,184.2,3s111.3,2.8,179.9,2.8 C451.4,463,448.3,443.4,432.7,404.7z"/><path fill="none" stroke="#ff00ff" stroke-width="7" stroke-miterlimit="10" d="M494,483.2l-5.5-50.6c-0.4-4.8-12.4-39.1-23.4-49.3c-14.4-13.3-51.7-27-73.7-28.8L377,351 c-11.5-4.6,8.8-31.1,12-34c17.5-15.5,20.8-50.5,26-73c4.9-21.1-0.4-38.1-6-47c0-22.2-3.1-45.7-9-66c-0.7-27.4-10.4-44-24.6-57.5 c-10-9.6-21.4-16.1-33.3-17.9c-4.6-0.7-15.2-3.7-17.6-4.8c-21-10-43.7-11.4-68.5-11.8c-51.9,1.9-106.6,29.5-128,81.5 c-6.6,15.8-16.1,35-15,57.5l2,26c-5.1,8.8-9.9,30.8-5,52c5.2,22.5,6.2,32.3,24,48c15,22,14,43.3,14,43.3c0,8.3-57.7,14.2-68.3,18.2 L55,377c-17.3,16.1-12,23.1-15.9,40.3c-2.1,5.7-0.3,14.8-0.7,19.6L38,480.3"/></svg>
            <span><?php _e('Medium','web-to-print-online-designer'); ?></span>
        </div>
        <div class="contour-type" ng-class="currentContourType == 'l' ? 'active' : ''" ng-click="initContour('l')">
            <svg viewBox="0 0 512 512" xml:space="preserve"><path fill="#404762" d="M432.7,404.7c-10.3-8.1-22.8-13.9-36.3-16.8l-64.6-13c-6.8-1.3-11.7-7.4-11.7-14.4v-14.8 c4.2-5.8,8.1-13.6,12.2-21.7c3.2-6.3,8-15.7,10.4-18.2c13.1-13.1,25.7-27.9,29.7-47c3.7-17.9,0.1-27.2-4.2-34.8 c0-18.8-0.6-42.4-5-59.6c-0.5-23.2-4.7-36.3-15.4-47.7c-7.5-8.1-18.5-10-27.4-11.5c-3.5-0.6-8.3-1.4-10.1-2.4 c-15.7-8.5-31.2-12.6-49.8-13c-38.8,1.6-86.5,26.3-102.5,70.3c-5,13.4-4.5,35.4-4,53.1l-0.4,10.6c-3.8,7.4-7.5,16.9-3.9,34.8 c3.9,19.1,16.5,33.9,29.9,47.2c2.2,2.2,7.1,11.8,10.3,18.1c4.2,8.1,8.1,15.8,12.3,21.6v14.8c0,7-4.9,13.1-11.7,14.4l-64.7,13 c-13.5,2.9-26,8.6-36.2,16.7c-3.2,2.6-8.4,19.5-8.7,23.6c-0.3,4.1-4,52.2,3.4,51.9c101.8,0,118.1,3,184.2,3s111.3,2.8,179.9,2.8 C451.4,463,448.3,443.4,432.7,404.7z"/><path fill="none" stroke="#ff00ff" stroke-width="7" stroke-miterlimit="10" d="M512,486l-8-56c-0.5-5-9.8-43.8-21-55c-24-24-9.6-6-47-33c-7.8-5.6-37-3.6-24-32c26-44,23.4-51.6,29-75 c5.2-22,1-44.7-5-54c0-23.2-3.6-36.9-10-58c-0.8-28.6-19.9-49.9-35-64c-10.7-10-36.6-19.8-49.2-21.7c-5-0.7-16.3-3.9-18.8-5 c-22.4-10.5-46.7-11.9-73.2-12.3c-55.4,2-124,30.8-146.8,85c-7.1,16.5-15.2,44.5-14,68l1,17c-5.4,9.1-11.3,39.5-6,61.6 c5.6,23.5,12.5,46.5,23,69.4c11.7,25.5-35.6,29.9-47,34l-32,12c-18.5,16.8-15.8,24-20,42c-2.3,5.9-0.5,19-1,24l-7,46"/></svg>
            <span><?php _e('Large','web-to-print-online-designer'); ?></span>
        </div>
        <div class="contour-type" ng-class="currentContourType == 'r' ? 'active' : ''" ng-click="initContour('r')">
            <svg viewBox="0 0 40 30" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="26" x="2" y="2" fill="none" stroke="#404762" stroke-width="2"></rect></svg>
            <span><?php _e('Rectangle','web-to-print-online-designer'); ?></span>
        </div>
        <div class="contour-type" ng-class="currentContourType == 'c' ? 'active' : ''" ng-click="initContour('c')">
            <svg viewBox="0 0 40 30"><path fill="none" stroke="#404762" x="2" y="2" stroke-width="2" d="M 5, 15 a 13,13 0 1,0 26,0 a 13,13 0 1,0 -26,0"></path></svg>
            <span><?php _e('Circle','web-to-print-online-designer'); ?></span>
        </div>
        <div class="contour-type" ng-class="currentContourType == 'rc' ? 'active' : ''" ng-click="initContour('rc')">
            <svg viewBox="0 0 40 30" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="26" x="2" y="2" rx="6" fill="none" stroke="#404762" stroke-width="2"></rect></svg>
            <span><?php _e('Round conners','web-to-print-online-designer'); ?></span>
        </div>
    </div>
</div>