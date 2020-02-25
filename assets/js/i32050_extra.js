jQuery(document).on( 'nbd_app_loaded', function(){
    var $scope = angular.element( document.getElementById( 'design-container' ) ).scope();
    $scope.currentContourType = '';
    $scope.cutlines = [];
    $scope.resetContour = function(stageIndex){
        var stageIndex = stageIndex ? stageIndex : $scope.currentStage;
        $scope.cutlines[stageIndex] = {};
    };
    $scope.initContour = function( type, stageIndex, callback ){
        var stageIndex = stageIndex ? stageIndex : $scope.currentStage,
        _stage = $scope.stages[stageIndex],
        _canvas = _stage.canvas,
        width = _canvas.width,
        height = _canvas.height,
        info = {
            outline: '#FF00FF',
            width: width,
            height: height
        };

        function checkNeedResize( img ){
            var _canvas = document.createElement("canvas");
            _canvas.width = width;
            _canvas.height = height;
            var _ctx = _canvas.getContext('2d');
            _ctx.drawImage(img, 0, 0, width, height, 0, 0, width, height);
            var imgdataobj = _ctx.getImageData(0, 0, width, height);
    
            var i, j, check = false, index;
            for (j = 0; j < info.margin; j++) {
                if( check ){
                    break;
                }
    
                for (i = 0; i < width; i++) {
                    index = (width * j + i) * 4;
                    if( imgdataobj.data[index + 3] > 0 ) {
                        check = true;
                        break;
                    }
                }
                
            }
            if( check ) return check;
    
            for (j = height - info.margin; j < height; j++) {
                if( check ){
                    break;
                }
    
                for (i = 0; i < width; i++) {
                    index = (width * j + i) * 4;
                    if( imgdataobj.data[index + 3] > 0 ) {
                        check = true;
                        break;
                    }
                }
            }
            if( check ) return check;
    
            for (j = 0; j < height; j++) {
                if( check ){
                    break;
                }
    
                for (i = 0; i < info.margin; i++) {
                    index = (width * j + i) * 4;
                    if( imgdataobj.data[index + 3] > 0 ) {
                        check = true;
                        break;
                    }
                }
            }
            if( check ) return check;
    
            for (j = 0; j < height; j++) {
                if( check ){
                    break;
                }
    
                for (i = width - info.margin; i < width; i++) {
                    index = (width * j + i) * 4;
                    if( imgdataobj.data[index + 3] > 0 ) {
                        check = true;
                        break;
                    }
                }
            }
    
            return check;
        }

        function resizeStage(){
            var ratio = ( width - 2 * info.margin ) / width;
            
            var objs = [];
            _canvas.forEachObject(function(obj, index) {
                if( obj.get('selectable') ) objs.push(obj);
            });
            var selection = new fabric.ActiveSelection(objs, {
                canvas: _canvas
            });
            selection.addWithUpdate();
            _canvas.setActiveObject(selection);

            obj = _canvas.getActiveObject();
            var scale = _stage.states.scaleRange[_stage.states.currentScaleIndex].ratio,
                scaleX = obj.scaleX,
                scaleY = obj.scaleY,
                left = obj.left / scale,
                top = obj.top / scale;
            var tempScaleX = scaleX * ratio,
                tempScaleY = scaleY * ratio,
                tempLeft = info.margin + left * ratio,
                tempTop = info.margin + top * ratio;

            obj.scaleX = tempScaleX;
            obj.scaleY = tempScaleY;
            obj.left = tempLeft;
            obj.top = tempTop;
            obj.setCoords();

            $scope.deactiveAllLayer( stageIndex );

            $scope.renderStage( stageIndex );
        }

        $scope.deactiveAllLayer( stageIndex );
        setTimeout(function(){
            var data = _canvas.toDataURL(),
            shadow = width / 100,
            hasPattern = false,
            hasImagePattern = false,
            patternWidth,
            patternHeight,
            patternSrc,
            patternSvgFillc = "#ffffff",
            patternSvg;

            $scope.cutlines[stageIndex] = {};

            if( !_canvas.getObjects().length ){
                return;
            }

            $scope.currentContourType = type;
            var img = new Image;

            if( typeof callback != 'function' ){
                $scope.toggleStageLoading();
            }

            if( angular.isDefined( $scope.settings.product_data.product[stageIndex].pattern ) ){
                hasPattern = true;
                var pattern = $scope.settings.product_data.product[stageIndex].pattern;
                if( pattern.type == 'color' ){
                    patternSvgFillc = pattern.color;
                }else{
                    if( pattern.src != '' ){
                        patternSvgFillc = 'url(#material_pattern_' + stageIndex + ')';
                        patternSrc = pattern.src;
                        patternWidth = pattern.width;
                        patternHeight = pattern.height;
                        hasImagePattern = true;
                    }else{
                        hasPattern = false;
                        hasImagePattern = false;
                    }
                }
            }

            setTimeout(function(){
                img.onload = function(){
                    function buildSvg( pathcmd, info ){
                        var svg = '<svg version="1.1" width="' + info.width + '" height="' + info.height + '"' + ' viewBox="0 0 ' + info.width + ' ' + info.height + '" ' + ' xmlns="http://www.w3.org/2000/svg">',
                        strokec = info.outline,
                        fillc = "none",
                        fillrule = '';

                        if( hasImagePattern ){
                            strokec = "transparent";
                        }

                        svg += '<defs><clipPath id="stiker_contour_' + stageIndex + '"><path d="' + pathcmd + '" /></clipPath></defs>';
                        svg += '<path d="';
                        svg += pathcmd;
                        svg += '" stroke="' + strokec + '" fill="' + fillc + '"' + fillrule + '/></svg>';
                        return svg;
                    }

                    function buildPatternSvg( pathcmd, info ){
                        var svg = '<svg version="1.1" width="' + info.width + '" height="' + info.height + '"' + ' viewBox="0 0 ' + info.width + ' ' + info.height + '" ' + ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">',
                        strokec = 'none',
                        fillrule = '';

                        $scope.cutlines[stageIndex].clipPath = '<path d="' + pathcmd + '" />';
                        $scope.cutlines[stageIndex].shadow = '<filter id="contour_shadow_' + stageIndex + '" x="-50%" y="-50%" width="200%" height="200%" filterRes="1920" style="display : inline"><feOffset result="offOut" in="SourceAlpha" dx="' + shadow + '" dy="' + shadow + '"></feOffset><feGaussianBlur result="blurOut" in="offOut" stdDeviation="' + 2 * shadow + '"></feGaussianBlur><feColorMatrix result="matrixOut" in="blurOut" type="matrix" values="1 0 0 0 0.2, 0 1 0 0 0.2, 0 0 1 0 0.2, 0 0 0 1 0"></feColorMatrix><feBlend in="SourceGraphic" in2="matrixOut" mode="normal"></feBlend></filter>';
                        svg += '<defs><clipPath id="stiker_contour_' + stageIndex + '"><path d="' + pathcmd + '" /></clipPath>';
                        svg += $scope.cutlines[stageIndex].shadow;
                        
                        if( hasImagePattern ){
                            $scope.cutlines[stageIndex].pattern = '<pattern id="material_pattern_' + stageIndex + '" x="0" y="0" width="' + patternWidth / info.width + '" height="' + patternHeight / info.height + '"><image x="0px" y="0px" width="' + patternWidth + '" height="' + patternHeight + '" xlink:href="' + patternSrc + '"></image></pattern>';
                            svg += $scope.cutlines[stageIndex].pattern;
                        }

                        $scope.cutlines[stageIndex].patternPath = '<path d="' + pathcmd + '" stroke="' + strokec + '" fill="' + patternSvgFillc + '"' + fillrule + ' filter="url(#contour_shadow_' + stageIndex + ')"/>';

                        svg += '</defs>';
                        svg += pathcmd;
                        svg += $scope.cutlines[stageIndex].patternPath + '</svg>';
                        return svg;
                    }

                    function buildShapePatternSvg( pathcmd, info ){
                        var svg = '<svg version="1.1" width="' + info.width + '" height="' + info.height + '"' + ' viewBox="0 0 ' + info.width + ' ' + info.height + '" ' + ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">';

                        //$scope.cutlines[stageIndex].clipPath = pathcmd;
                        $scope.cutlines[stageIndex].shadow = '<filter id="contour_shadow_' + stageIndex + '" x="-50%" y="-50%" width="200%" height="200%" filterRes="1920" style="display : inline"><feOffset result="offOut" in="SourceAlpha" dx="' + shadow + '" dy="' + shadow + '"></feOffset><feGaussianBlur result="blurOut" in="offOut" stdDeviation="' + 2 * shadow + '"></feGaussianBlur><feColorMatrix result="matrixOut" in="blurOut" type="matrix" values="1 0 0 0 0.2, 0 1 0 0 0.2, 0 0 1 0 0.2, 0 0 0 1 0"></feColorMatrix><feBlend in="SourceGraphic" in2="matrixOut" mode="normal"></feBlend></filter>';
                        svg += '<defs><clipPath id="stiker_contour_' + stageIndex + '">' + pathcmd + '</clipPath>';
                        svg += $scope.cutlines[stageIndex].shadow;

                        if( hasImagePattern ){
                            $scope.cutlines[stageIndex].pattern = '<pattern id="material_pattern_' + stageIndex + '" x="0" y="0" width="' + patternWidth / info.width + '" height="' + patternHeight / info.height + '"><image x="0px" y="0px" width="' + patternWidth + '" height="' + patternHeight + '" xlink:href="' + patternSrc + '"></image></pattern>';
                            svg += $scope.cutlines[stageIndex].pattern;
                        }

                        svg += '</defs>';
                        svg += pathcmd + '</svg>';
                        return svg;
                    }

                    function _potrace( info, img ){
                        var options = {
                            color: 'none',
                            outline: info.outline,
                            margin: info.margin
                        };

                        Potrace.clear();
                        Potrace.setParameter( options );
                        Potrace.loadData( img, Math.floor( width ), Math.floor( height ) );
                        Potrace.process(function(){
                            var svgObj = Potrace.getSVG(1, "curve", true),
                            svg = buildSvg( svgObj.pathcmd, info);
                            jQuery('#stage-container-' + stageIndex + ' .contour-wrap').html('').append( svg );
                            $scope.cutlines[stageIndex].contour = svg;
                            $scope.cutlines[stageIndex].needResize = svgObj.needResize;

                            patternSvg = buildPatternSvg( svgObj.pathcmd, info);
                            jQuery('#stage-container-' + stageIndex + ' .nbd-stage-pattern').html('').append( patternSvg );

                            if( typeof callback == 'function' ){
                                callback();
                            }else{
                                $scope.toggleStageLoading();
                            }
                        });
                    }

                    function prepareBeforePotrace(){
                        if( !checkNeedResize( img ) ){
                            _potrace( info, img );
                        }else{
                            resizeStage();
                            setTimeout(function(){
                                var new_data = _canvas.toDataURL(),
                                new_img = new Image;
                                new_img.onload = function(){
                                    _potrace( info, new_img );
                                };
                                new_img.src = new_data;
                            }, 100);
                        }
                    }

                    switch( type ){
                        case 's':
                            info.margin = 10;
                            prepareBeforePotrace();
                            break;
                        case 'm':
                            info.margin = 20;
                            prepareBeforePotrace();
                            break;
                        case 'l':
                            info.margin = 30;
                            prepareBeforePotrace();
                            break;
                        case 'r':
                            var pathcmd = '<rect width="' + width + '" height="' + height + '" fill="none" stroke="#ff00ff"></rect>';
                            var svg = '<svg viewBox="0 0 ' + width + ' ' + height + '" xmlns="http://www.w3.org/2000/svg">' + pathcmd + '</svg>';
                            jQuery('#stage-container-' + stageIndex + ' .contour-wrap').html('').append( svg );
                            $scope.cutlines[stageIndex].contour = svg;
                            $scope.cutlines[stageIndex].needResize = false;
                            $scope.cutlines[stageIndex].clipPath = pathcmd;

                            var patternPathCmd = '<rect width="' + width + '" height="' + height + '" fill="' + patternSvgFillc + '" stroke="none" filter="url(#contour_shadow_' + stageIndex + ')"></rect>';
                            $scope.cutlines[stageIndex].patternPath = patternPathCmd;

                            patternSvg = buildShapePatternSvg( patternPathCmd, info );
                            jQuery('#stage-container-' + stageIndex + ' .nbd-stage-pattern').html('').append( patternSvg );

                            if( typeof callback == 'function' ){
                                callback();
                            }else{
                                $scope.toggleStageLoading();
                            }
                            break;
                        case 'c':
                            var radio = (width > height ? height : width) / 2;
                            var pathcmd = '<path d="M ' + ( width / 2 - radio ) + ', ' + height / 2 + ' a ' + radio + ',' + radio + ' 0 1,0 ' + 2 * radio + ', 0 a ' + radio + ',' + radio + ' 0 1,0 -' + 2 * radio + ', 0" fill="none" stroke="#ff00ff"/>';
                            svg = '<svg viewBox="0 0 ' + width + ' ' + height + '" xmlns="http://www.w3.org/2000/svg">' + pathcmd + '</svg>';
                            jQuery('#stage-container-' + stageIndex + ' .contour-wrap').html('').append( svg );
                            $scope.cutlines[stageIndex].contour = svg;
                            $scope.cutlines[stageIndex].clipPath = pathcmd;
                            $scope.cutlines[stageIndex].needResize = false;

                            var patternPathCmd = '<path d="M ' + ( width / 2 - radio ) + ', ' + height / 2 + ' a ' + radio + ',' + radio + ' 0 1,0 ' + 2 * radio + ', 0 a ' + radio + ',' + radio + ' 0 1,0 -' + 2 * radio + ', 0" fill="' + patternSvgFillc + '" filter="url(#contour_shadow_' + stageIndex + ')"/>';
                            $scope.cutlines[stageIndex].patternPath = patternPathCmd;

                            patternSvg = buildShapePatternSvg( patternPathCmd, info );
                            jQuery('#stage-container-' + stageIndex + ' .nbd-stage-pattern').html('').append( patternSvg );

                            if( typeof callback == 'function' ){
                                callback();
                            }else{
                                $scope.toggleStageLoading();
                            }
                            break;
                        case 'rc':
                            var radius = width / 10,
                            pathcmd = '<rect width="' + width + '" height="' + height + '" rx="' + radius + '" fill="none" stroke="#ff00ff"></rect>';
                            var svg = '<svg viewBox="0 0 ' + width + ' ' + height + '" xmlns="http://www.w3.org/2000/svg">' + pathcmd + '</svg>';
                            jQuery('#stage-container-' + stageIndex + ' .contour-wrap').html('').append( svg );
                            $scope.cutlines[stageIndex].contour = svg;
                            $scope.cutlines[stageIndex].needResize = false;
                            $scope.cutlines[stageIndex].clipPath = pathcmd;

                            var patternPathCmd = '<rect width="' + width + '" height="' + height + '" rx="' + radius + '" fill="' + patternSvgFillc + '" stroke="none" filter="url(#contour_shadow_' + stageIndex + ')"></rect>';
                            $scope.cutlines[stageIndex].patternPath = patternPathCmd;

                            patternSvg = buildShapePatternSvg( patternPathCmd, info );
                            jQuery('#stage-container-' + stageIndex + ' .nbd-stage-pattern').html('').append( patternSvg );

                            if( typeof callback == 'function' ){
                                callback();
                            }else{
                                $scope.toggleStageLoading();
                            }
                            break;
                    }
                };
                img.src = data;
            }, 100);
        });
    };
    $scope.stageDesignChanged = function(){
        $scope.$parent.$broadcast('stageDesignChanged');
    };
    $scope.$on('stageDesignChanged', function(event, args) {
        $scope.resetContour();
    });
    $scope.afterChangeExtraOdOptions = function(){
        angular.forEach($scope.settings.product_data.product, function(side, key){
            var selector;
            switch( $scope.currentContourType ){
                case 's':
                case 'm':
                case 'l':
                case 'c':
                    selector = 'path';
                    break;
                case 'r':
                case 'rc':
                    selector = 'rect';
                    break;
            }
            jQuery('#stage-container-' + key + ' .nbd-stage-pattern svg ' + selector).attr('fill', '#ffffff');
            if( !!$scope.cutlines[key] && !!side.pattern ){
                var _stage = $scope.stages[key],
                _canvas = _stage.canvas,
                width = _canvas.width,
                height = _canvas.height;

                function buildPatternSvg(){
                    var svg = '<svg version="1.1" width="' + width + '" height="' + height + '"' + ' viewBox="0 0 ' + width + ' ' + height + '" ' + ' xmlns="http://www.w3.org/2000/svg">';
                    svg += '<defs>';
                    svg += $scope.cutlines[key].shadow;
                    svg += $scope.cutlines[key].pattern;
                    svg += '</defs>';
                    svg += $scope.cutlines[key].clipPath + '</svg>';
                    return svg;
                }

                if(side.pattern.type == 'image' && !!side.pattern.src ){
                    var patternWidth = Number( side.pattern.width ),
                    patternHeight = Number( side.pattern.height ),
                    patternSrc = side.pattern.src;
                    $scope.cutlines[key].pattern = '<pattern id="material_pattern_' + key + '" x="0" y="0" width="' + patternWidth / width + '" height="' + patternHeight / height + '"><image x="0px" y="0px" width="' + patternWidth + '" height="' + patternHeight + '" xlink:href="' + patternSrc + '"></image></pattern>';
                    var svg = buildPatternSvg();
                    jQuery('#stage-container-' + key + ' .nbd-stage-pattern').html('').append( svg );
                    jQuery('#stage-container-' + key + ' .nbd-stage-pattern svg ' + selector).attr('fill', 'url(#material_pattern_' + key + ')');
                }else{
                    delete $scope.cutlines[key].pattern;
                }
            }
        });
    };
    $scope.saveDataWithContour = function( callback ){
        var type = $scope.currentContourType != '' ? $scope.currentContourType : 'm',
        readyStages = [];
        
        function createSvgPreview( index ){
            var _stage = $scope.stages[index],
            _canvas = _stage.canvas,
            width = _canvas.width,
            height = _canvas.height,
            image = _canvas.toDataURL();

            if( !!$scope.cutlines[index].pattern ){
                patternSvgFillc = 'url(#material_pattern_' + index + ')';
            }else{
                patternSvgFillc = '#ffffff';
            }

            var svg = '<svg version="1.1" width="' + width + '" height="' + height + '"' + ' viewBox="0 0 ' + width + ' ' + height + '" ' + ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">';
            svg += '<defs>';
            svg +=      $scope.cutlines[index].shadow;
            if( !!$scope.cutlines[index].pattern ) svg += $scope.cutlines[index].pattern;
            svg +=      '<clipPath id="stiker_contour_' + index + '">' + $scope.cutlines[index].clipPath + '</clipPath>';
            svg += '</defs>';
            svg +=      $scope.cutlines[index].patternPath;
            svg +=      '<image x="0" y="0" width="' + width + '" height="' + height + '"' + ' xlink:href="' + image + '" />';
            svg += '</svg>';
            return svg;
        }

        function createPreview( index ){
            $scope.deactiveAllLayer( index );
            var _stage = $scope.stages[index],
            _canvas = _stage.canvas,
            width = _canvas.width,
            height = _canvas.height,
            key = 'frame_' + index;

            var canvasSvg = _canvas.toSVG(),
            newCanvasvg,
            clipPath = '<clipPath id="stiker_contour_' + index + '">' + $scope.cutlines[index].clipPath + '</clipPath>';
            newCanvasvg = canvasSvg.replace('<\/defs>', clipPath + '<\/defs><g clip-path="url(#stiker_contour_' + index + ')"><rect x="0" y="0" width="' + width + '" height="' + height + '" fill="red"/>');
            newCanvasvg = newCanvasvg.replace('<\/svg>', '<\/g><\/svg>');
            console.log( newCanvasvg );
            _stage.svg = newCanvasvg;


            $scope.resource.jsonDesign[key] = _canvas.toJSON($scope.includeExport);

            var svg = createSvgPreview( index ),
            svgBlob = new Blob([svg], {type: "image/svg+xml;charset=utf-8"}),
            url = window.URL.createObjectURL(svgBlob),
            img = new Image();
            img.onload = function() {
                var canvas = document.createElement("canvas");
                canvas.width = width;
                canvas.height = height;
                var context = canvas.getContext('2d');
                context.drawImage(img, 0, 0);
                window.URL.revokeObjectURL(svgBlob);
                
                _stage.design = canvas.toDataURL();
                readyStages[index] = true;
            }
            img.src = url;
        }

        _.each($scope.stages, function(stage, index){
            readyStages[index] = false;
            if( !$scope.cutlines[index] ){
                $scope.initContour( type, index, function(){
                    createPreview( index );
                } );
            }else{
                createPreview( index );
            }
        });

        var interval = setInterval(function(){
            var check = true;

            _.each($scope.stages, function(stage, index){
                check = check && readyStages[index];
            });

            if( check ){
                callback();
                clearInterval( interval );
            }
        }, 100);
    }

    $scope.saveData = function(type){
        jQuery('.variations_form, form.cart').find('[name="nbo-ignore-design"]').remove();
        if( angular.isUndefined( type ) && angular.isDefined( nbd_window.nbOption ) && angular.isDefined( nbd_window.nbOption.odOption ) 
                && angular.isDefined( nbd_window.nbOption.odOption.page ) && angular.isDefined( nbd_window.nbOption.odOption.page.list_page ) && nbd_window.nbOption.odOption.page.list_page.length == 0 ){
            if(NBDESIGNCONFIG.show_nbo_option == "1" && NBDESIGNCONFIG.task == 'new' && NBDESIGNCONFIG.task2 == '' ){
                nbd_window.jQuery('.variations_form, form.cart').append('<input name="nbo-ignore-design" type="hidden" value="1" />');
                jQuery('.variations_form, form.cart').submit();
                return;
            }
            return;
        }
        if( angular.isUndefined(type) ) type = $scope.settings.task;
        if(type != 'share' && type != 'save_draft' ) $scope.toggleStageLoading( 6E4 );
        if(type == 'typography') $scope.resource.usedFonts = [];
        var excludeType = ['saveforlater', 'share', 'download-pdf', 'preview_mockup', 'save_draft', 'download-jpg'];
        if( !_.includes(excludeType, type) ) $scope.maybeZoomStage = true;

        $scope.maybeZoomStage = false;
        $scope.saveDesign();

        $scope.saveDataWithContour(function(){
            var NBDDataFactory = angular.element(document.getElementById('design-container')).injector().get('NBDDataFactory');

            $scope.resource.config.viewport = $scope.viewPort;
            /* Backward compatible version 1.x */
            $scope.resource.config.scale =  (jQuery(window).innerWidth() > (jQuery(window).innerHeight() - 120) ? jQuery(window).innerHeight() - 120 : jQuery(window).innerWidth()) / 500;  
            $scope.resource.config.product = $scope.settings.product_data.product;
            if( angular.isDefined($scope.settings.product_data.origin_product) ){
                $scope.resource.config.origin_product = $scope.settings.product_data.origin_product;
            }
            $scope.resource.config.dpi = $scope.settings.product_data.option.dpi;
            if( $scope.settings.product_data.option.option_dpi ){
                $scope.resource.config.option_dpi = true;
            }
            if( angular.isDefined( NBDESIGNCONFIG['design_id'] ) ){
                $scope.resource.config.design_id = NBDESIGNCONFIG['design_id'];
            }
            var dataObj = {};
            dataObj.used_font = new Blob([JSON.stringify($scope.resource.usedFonts)], {type: "application/json"}); 
            if( type == 'template' ) $scope.resource.jsonDesign.canvas = {width: $scope.templateSize.width, height: $scope.templateSize.height};
            dataObj.design = new Blob([JSON.stringify($scope.resource.jsonDesign)], {type: "application/json"});
            _.each($scope.stages, function(stage, index){
                var key = 'frame_' + index,
                    svg_key = 'frame_' + index + '_svg'; 
                dataObj[key] = $scope.makeblob(stage.design);
                if(type != 'typography' && type != 'template' ){
                    dataObj[svg_key] = new Blob([stage.svg], {type: "image/svg"});  
                }
            });
            switch(type){
                case 'typography':
                    dataObj.type = 'save_typography';
                    dataObj.id = $scope.resource.currentTypo;
                    _.each($scope.stages, function(stage, index){
                        var key = 'frame_' + index;
                        dataObj[key] = $scope.makeblob(stage.design);
                    });
                    NBDDataFactory.get('nbd_get_resource', dataObj, function(data){
                        $scope.stages[0].states.usedFonts = [];
                        alert('Success!');
                    });
                    break;
                case 'template':
                    dataObj.type = 'save_template';
                    dataObj.source = 'media';
                    dataObj.tem_name = $scope.templateName;
                    dataObj.cid = $scope.templateCat;
                    jQuery('.popup-template .close-popup').triggerHandler('click');
                    NBDDataFactory.get('nbd_get_resource', dataObj, function(data){
                        data = JSON.parse(data);
                        if( data.flag == 1 ){
                            _.each($scope.stages, function(stage, index){
                                stage.states.usedFonts = [];
                            });
                            $scope.resource.usedFonts = [];
                            $scope.listAddedColor = [];
                            $scope.resetStage();
                            $scope.toggleStageLoading();
                            alert('Success!');
                        }else{
                            alert('Try again!');
                        }
                    });
                    break;
                case 'saveforlater':
                default:
                    ['product_id', 'variation_id', 'task', 'task2', 'design_type', 'nbd_item_key', 'cart_item_key', 'order_id', 'enable_upload_without_design', 'auto_add_to_cart', 'ui_mode'].forEach(function(key){
                        dataObj[key] = NBDESIGNCONFIG[key];
                    });
                    if( angular.isDefined( NBDESIGNCONFIG['design_id'] ) ){
                        dataObj['design_id'] = NBDESIGNCONFIG['design_id'];
                    }
                    if( type == 'share' ) dataObj['share'] = 1;
                    dataObj['nbd_file'] = '';
                    dataObj.config = new Blob([JSON.stringify($scope.resource.config)], {type: "application/json"}); 

                    if( $scope.resource.config.qty != null ){
                        dataObj.qty = $scope.resource.config.qty;
                    }else{
                        delete $scope.resource.config.qty;
                    }
                    setTimeout(function(){
                        var action = ( !_.includes(excludeType, type) && NBDESIGNCONFIG.task == 'new' && NBDESIGNCONFIG.ui_mode == 2 ) ?  'nbd_save_cart_design' : 'nbd_save_customer_design';
                        if(NBDESIGNCONFIG.show_nbo_option == "1" && NBDESIGNCONFIG.task == 'new'){
                            action = 'nbd_save_customer_design';
                        }
                        if(type == 'save_draft'){
                            action = 'nbd_save_draft_design';
                            dataObj.save_draft = 1;
                            if( angular.isDefined($scope.resource.draft_folder) && $scope.resource.draft_folder != '' ) dataObj.draft_folder = $scope.resource.draft_folder;
                        }
                        if(type == 'preview_mockup') {
                            dataObj.generate_mockup = 1;
                            jQuery('.nbd-popup.popup-nbd-mockup-preview').find('.overlay-main').addClass('active');
                        }
                        if( NBDESIGNCONFIG.task == 'create' || ( NBDESIGNCONFIG.task == 'edit' && NBDESIGNCONFIG.design_type == 'template' )  ){
                            if( $scope.customTemplate.type == 2 ){
                                dataObj['template_thumb'] = $scope.customTemplate.template_thumb;
                            }
                            dataObj['template_name'] = $scope.customTemplate.name;
                            dataObj['template_type'] = $scope.customTemplate.type;
                            var selectedTags = $scope.validateTemplateTags();
                            dataObj['template_tags'] = selectedTags.join(',');
                            dataObj['template_colors'] = $scope.customTemplate.selectedColors.join(',');
                            $scope.closePopup( '.popup-template-tags' );
                        }
                        NBDDataFactory.get(action, dataObj, function(data){
                            data = JSON.parse(data);
                            if(data.flag == 'success'){
                                if( type == 'save_draft' ){
                                    $scope.resource.draft_folder = data.draft_folder;
                                    return;
                                }
                                if( type == 'preview_mockup' ){
                                    if( data.mockups ){
                                        $scope.resource.mockups = data.mockups;
                                        $scope.resource.social.folder = data.folder;
                                        var origin_url = 'whatsapp://send?text=';
                                        var d = new Date();
                                        var share_url = NBDESIGNCONFIG.nbd_create_own_page + '?product_id=' + NBDESIGNCONFIG.product_id + '&variation_id=' + NBDESIGNCONFIG.variation_id + '&reference=' + $scope.resource.social.folder + '&nbd_share_id=' + $scope.resource.social.folder + '&t=' + d.getTime();
                                        $scope.resource.social.wa_link = origin_url + encodeURIComponent(share_url);
                                        jQuery('.whatsapp_share').attr('href', $scope.resource.social.wa_link);
                                    }
                                    setTimeout(function(){
                                        jQuery('.nbd-simple-slider').nbSimpleSlider();
                                    });
                                    jQuery('.nbd-popup.popup-nbd-mockup-preview').find('.overlay-main').removeClass('active');
                                    $scope.toggleStageLoading();
                                    return;
                                }
                                if( type == 'download-pdf' || type == 'download-jpg' ){
                                    var _dataObj = {nbd_item_key: data.folder};
                                    var action2 = type == 'download-pdf' ? 'nbd_frontend_download_pdf' : 'nbd_frontend_download_jpeg';
                                    NBDDataFactory.get(action2, _dataObj, function(_data){
                                        _data = JSON.parse(_data);
                                        if(_data[0].flag == 1){
                                            var filename = type == 'download-pdf' ? 'design.pdf' : 'designs.zip',
                                            t = new Date().getTime(),
                                            a = document.createElement('a');
                                            a.setAttribute('href', _data[0].link + '?t=' + t);
                                            a.setAttribute('download', filename);
                                            a.style.display = 'none';
                                            document.body.appendChild(a);
                                            a.click();
                                            document.body.removeChild(a);
                                            $scope.toggleStageLoading();
                                        }
                                    });
                                    return;
                                }
                                if( NBDESIGNCONFIG.ui_mode == 3 ){
                                    if( NBDESIGNCONFIG.task == 'new' && NBDESIGNCONFIG.task2 == '' ){
                                        $scope.toggleStageLoading();
                                        jQuery(document).triggerHandler( 'nbd_design_stored', {_type: type} );
                                        return;
                                    }else{
                                        if(NBDESIGNCONFIG['redirect_url'] != ""){
                                            window.location = NBDESIGNCONFIG['redirect_url'];
                                            return;
                                        };
                                    }
                                }
                                if( type == 'saveforlater' ){
                                    var _dataObj = {product_id: NBDESIGNCONFIG.product_id, variation_id: NBDESIGNCONFIG.variation_id, folder: data.folder};
                                    if( angular.isDefined( $scope.selectedMyDesign ) && $scope.selectedMyDesign != '' ){
                                        _dataObj.pre_folder = $scope.selectedMyDesign;
                                    }
                                    NBDDataFactory.get('nbd_save_for_later', _dataObj, function(_data){
                                        _data = JSON.parse(_data);
                                        if( angular.isDefined( $scope.selectedMyDesign ) && $scope.selectedMyDesign != '' ){
                                            if( _data.src ){
                                                _.each($scope.resource.myTemplates, function(template, index){
                                                    if( template.id == _data.folder ){
                                                        template.src = _data.src;
                                                    }
                                                });
                                            }
                                        };
                                        $scope.toggleStageLoading();
                                    }); 
                                    return;
                                } if( type == 'share' ) {
                                    $scope.resource.social.folder = data.sfolder;
                                    jQuery('.nbd-popup.popup-share').find('.overlay-main').removeClass('active');   
                                    return;
                                }else{
                                    if(NBDESIGNCONFIG.show_nbo_option == "1" && ( NBDESIGNCONFIG.task == 'new' || NBDESIGNCONFIG.task2 == 'update' ) ){
                                        jQuery('.variations_form, form.cart').submit();
                                        return;
                                    }
                                    if(NBDESIGNCONFIG['redirect_url'] != ""){
                                        window.location = NBDESIGNCONFIG['redirect_url'];
                                        return;
                                    };
                                    if( NBDESIGNCONFIG['nbdesigner_auto_add_cart_in_detail_page'] == "yes" &&  NBDESIGNCONFIG.task == 'new' && NBDESIGNCONFIG.ui_mode == 1 && !( angular.isDefined( NBDESIGNCONFIG.edit_option_mode ) && NBDESIGNCONFIG.edit_option_mode == '1' ) ){
                                        nbd_window.jQuery('.variations_form, form.cart').append('<input name="add-to-cart" type="hidden" value="'+NBDESIGNCONFIG.product_id+'" />');
                                        nbd_window.jQuery('.variations_form, form.cart').append('<input name="nbd-auto-add-to-cart-in-detail-page" type="hidden" value="1" />');
                                        nbd_window.jQuery(nbd_window.document).triggerHandler( 'nbd_design_stored', {_type: type, prevent_ajax: 1} );
                                    }else{
                                        nbd_window.NBDESIGNERPRODUCT.product_id = NBDESIGNCONFIG['product_id'];
                                        nbd_window.NBDESIGNERPRODUCT.variation_id = NBDESIGNCONFIG['variation_id'];
                                        nbd_window.NBDESIGNERPRODUCT.folder = data.folder;
                                        nbd_window.NBDESIGNERPRODUCT.show_design_thumbnail(data.image, NBDESIGNCONFIG['task'], $scope.resource.config);
                                        nbd_window.NBDESIGNERPRODUCT.get_sugget_design(NBDESIGNCONFIG['product_id'], NBDESIGNCONFIG['variation_id']);   

                                        if( NBDESIGNCONFIG.ui_mode == 1 && angular.isDefined( data.gallery ) ){
                                            nbd_window.jQuery(nbd_window.document).triggerHandler( 'nbd_update_gallery', {gallery: data.gallery, folder: data.folder} );
                                        }
                                        $scope.toggleStageLoading();
                                        setTimeout(function(){
                                            _.each($scope.stages, function(stage, index){
                                                $scope.zoomStage(stage.states.fitScaleIndex, index);
                                            });
                                        });
                                    }
                                }
                            }else{
                                console.log('Oops! Design has not been saved!');
                                if(type != 'save_draft'){ $scope.toggleStageLoading() };
                            }
                        }); 
                    });
                    break;
            }

        });
    };
});