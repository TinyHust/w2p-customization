jQuery(document).on( 'nbd_app_loaded', function(){
    var $scope = angular.element( document.getElementById( 'design-container' ) ).scope();
    $scope.currentContourType = '';
    $scope.cutlines = [];
    $scope.resetContour = function(stageIndex){
        var stageIndex = stageIndex ? stageIndex : $scope.currentStage;
        $scope.cutlines[stageIndex] = {};
    };
    $scope.initContour = function( type, stageIndex ){
        $scope.deactiveAllLayer();
        setTimeout(function(){
            var stageIndex = stageIndex ? stageIndex : $scope.currentStage,
            _stage = $scope.stages[stageIndex],
            _canvas = _stage.canvas,
            width = _canvas.width,
            height = _canvas.height,
            data = _canvas.toDataURL(),
            shadow = width / 100,
            hasImagePattern = false,
            patternWidth,
            patternHeight,
            patternSrc,
            patternSvgFillc = "#ffffff",
            patternSvg,
            info = {
                outline: '#FF00FF',
                width: width,
                height: height
            };
            $scope.cutlines[stageIndex] = {};

            if( !_canvas.getObjects().length ){
                return;
            }

            $scope.currentContourType = type;
            var img = new Image;
            $scope.toggleStageLoading();

            $scope.settings.product_data.product[stageIndex].pattern = {
                type: 'image',
                src: 'https://d6ce0no7ktiq.cloudfront.net/images/web/editor/prismatic_pp_laser_bg.png',
                width: 194,
                height: 194
            };

            if( angular.isDefined( $scope.settings.product_data.product[stageIndex].pattern ) ){
                var pattern = $scope.settings.product_data.product[stageIndex].pattern;
                if( pattern.type == 'color' ){
                    patternSvgFillc = pattern.color;
                }else{
                    patternSvgFillc = 'url(#material_pattern)';
                    patternSrc = pattern.src;
                    patternWidth = pattern.width;
                    patternHeight = pattern.height;
                    hasImagePattern = true;
                }
            }

            setTimeout(function(){
                img.onload = function(){
                    function buildSvg( pathcmd, info ){
                        var svg = '<svg version="1.1" width="' + info.width + '" height="' + info.height + '"' + ' viewBox="0 0 ' + info.width + ' ' + info.height + '" ' + ' xmlns="http://www.w3.org/2000/svg">',
                        strokec = info.outline,
                        fillc = "none",
                        fillrule = '';

                        if( angular.isDefined( $scope.settings.product_data.product[stageIndex].pattern ) ){
                            strokec = "transparent";
                        }

                        svg += '<defs><clipPath id="stiker_contour"><path d="' + pathcmd + '" /></clipPath></defs>';
                        svg += '<path d="';
                        svg += pathcmd;
                        svg += '" stroke="' + strokec + '" fill="' + fillc + '"' + fillrule + '/></svg>';
                        return svg;
                    }

                    function buildPatternSvg( pathcmd, info ){
                        var svg = '<svg version="1.1" width="' + info.width + '" height="' + info.height + '"' + ' viewBox="0 0 ' + info.width + ' ' + info.height + '" ' + ' xmlns="http://www.w3.org/2000/svg">',
                        strokec = 'none',
                        fillrule = '';

                        $scope.cutlines[stageIndex].clipPath = '<path d="' + pathcmd + '" />';
                        $scope.cutlines[stageIndex].shadow = '<filter id="contour_shadow" x="-50%" y="-50%" width="200%" height="200%" filterRes="1920" style="display : inline"><feOffset result="offOut" in="SourceAlpha" dx="' + shadow + '" dy="' + shadow + '"></feOffset><feGaussianBlur result="blurOut" in="offOut" stdDeviation="' + 2 * shadow + '"></feGaussianBlur><feColorMatrix result="matrixOut" in="blurOut" type="matrix" values="1 0 0 0 0.2, 0 1 0 0 0.2, 0 0 1 0 0.2, 0 0 0 1 0"></feColorMatrix><feBlend in="SourceGraphic" in2="matrixOut" mode="normal"></feBlend></filter>';
                        svg += '<defs><clipPath id="stiker_contour"><path d="' + pathcmd + '" /></clipPath>';
                        svg += $scope.cutlines[stageIndex].shadow;
                        
                        if( hasImagePattern ){
                            $scope.cutlines[stageIndex].pattern += '<pattern id="material_pattern" x="0" y="0" width="' + patternWidth / info.width + '" height="' + patternHeight / info.height + '"><image x="0px" y="0px" width="' + patternWidth + '" height="' + patternHeight + '" xlink:href="' + patternSrc + '"></image></pattern>';
                            svg += $scope.cutlines[stageIndex].pattern;
                        }

                        svg += '</defs>';
                        svg += '<path d="';
                        svg += pathcmd;
                        svg += '" stroke="' + strokec + '" fill="' + patternSvgFillc + '"' + fillrule + ' filter="url(#contour_shadow)"/></svg>';
                        return svg;
                    }

                    function buildShapePatternSvg( pathcmd, info ){
                        var svg = '<svg version="1.1" width="' + info.width + '" height="' + info.height + '"' + ' viewBox="0 0 ' + info.width + ' ' + info.height + '" ' + ' xmlns="http://www.w3.org/2000/svg">';

                        $scope.cutlines[stageIndex].clipPath = '<path d="' + pathcmd + '" />';
                        $scope.cutlines[stageIndex].shadow = '<filter id="contour_shadow" x="-50%" y="-50%" width="200%" height="200%" filterRes="1920" style="display : inline"><feOffset result="offOut" in="SourceAlpha" dx="' + shadow + '" dy="' + shadow + '"></feOffset><feGaussianBlur result="blurOut" in="offOut" stdDeviation="' + 2 * shadow + '"></feGaussianBlur><feColorMatrix result="matrixOut" in="blurOut" type="matrix" values="1 0 0 0 0.2, 0 1 0 0 0.2, 0 0 1 0 0.2, 0 0 0 1 0"></feColorMatrix><feBlend in="SourceGraphic" in2="matrixOut" mode="normal"></feBlend></filter>';
                        svg += '<defs><clipPath id="stiker_contour">' + pathcmd + '</clipPath>';
                        svg += $scope.cutlines[stageIndex].shadow;

                        if( hasImagePattern ){
                            $scope.cutlines[stageIndex].pattern += '<pattern id="material_pattern" x="0" y="0" width="' + patternWidth / info.width + '" height="' + patternHeight / info.height + '"><image x="0px" y="0px" width="' + patternWidth + '" height="' + patternHeight + '" xlink:href="' + patternSrc + '"></image></pattern>';
                            svg += $scope.cutlines[stageIndex].pattern;
                        }

                        svg += '</defs>';
                        svg += pathcmd + '</svg>';
                        return svg;
                    }

                    function _potrace( info ){
                        var options = {
                            color: 'none',
                            outline: info.outline,
                            margin: info.margin
                        };

                        Potrace.clear();
                        Potrace.setParameter( options );
                        Potrace.loadData( img, width, height );
                        Potrace.process(function(){
                            var svgObj = Potrace.getSVG(1, "curve", true),
                            svg = buildSvg( svgObj.pathcmd, info);
                            jQuery('.contour-wrap').html('').append( svg );
                            $scope.cutlines[stageIndex].contour = svg;

                            patternSvg = buildPatternSvg( svgObj.pathcmd, info);
                            jQuery('.nbd-stage-pattern').html('').append( patternSvg );
                            $scope.toggleStageLoading();
                        });
                    }

                    switch( type ){
                        case 's':
                            info.margin = 10;
                            _potrace( info );
                            break;
                        case 'm':
                            info.margin = 20;
                            _potrace( info );
                            break;
                        case 'l':
                            info.margin = 30;
                            _potrace( info );
                            break;
                        case 'r':
                            var pathcmd = '<rect width="' + width + '" height="' + height + '" fill="none" stroke="#ff00ff"></rect>';
                            var svg = '<svg viewBox="0 0 ' + width + ' ' + height + '" xmlns="http://www.w3.org/2000/svg">' + pathcmd + '</svg>';
                            jQuery('.contour-wrap').html('').append( svg );
                            $scope.cutlines[stageIndex].contour = svg;

                            var patternPathCmd = '<rect width="' + width + '" height="' + height + '" fill="' + patternSvgFillc + '" stroke="none" filter="url(#contour_shadow)"></rect>';
                            patternSvg = buildShapePatternSvg( patternPathCmd, info );
                            jQuery('.nbd-stage-pattern').html('').append( patternSvg );

                            $scope.toggleStageLoading();
                            break;
                        case 'c':
                            var pathcmd = '<g transform="translate(' + width / 2 + ', ' + height / 2 + ')"><circle cx="0" cy="0" r="' + height / 2 + '" fill="none" stroke="#ff00ff"></circle></g>';
                            svg = '<svg viewBox="0 0 ' + width + ' ' + height + '" xmlns="http://www.w3.org/2000/svg">' + pathcmd + '</svg>';
                            jQuery('.contour-wrap').html('').append( svg );
                            $scope.cutlines[stageIndex].contour = svg;

                            var patternPathCmd = '<g transform="translate(' + width / 2 + ', ' + height / 2 + ')"><circle cx="0" cy="0" r="' + height / 2 + '" fill="' + patternSvgFillc + '" stroke="none" filter="url(#contour_shadow)"></circle></g>';
                            patternSvg = buildShapePatternSvg( patternPathCmd, info );
                            jQuery('.nbd-stage-pattern').html('').append( patternSvg );
                            $scope.cutlines[stageIndex].contour = svg;

                            $scope.toggleStageLoading();
                            break;
                        case 'rc':
                            var radius = width / 10,
                            pathcmd = '<rect width="' + width + '" height="' + height + '" rx="' + radius + '" fill="none" stroke="#ff00ff"></rect>';
                            var svg = '<svg viewBox="0 0 ' + width + ' ' + height + '" xmlns="http://www.w3.org/2000/svg">' + pathcmd + '</svg>';
                            jQuery('.contour-wrap').html('').append( svg );
                            $scope.cutlines[stageIndex].contour = svg;

                            var patternPathCmd = '<rect width="' + width + '" height="' + height + '" rx="' + radius + '" fill="' + patternSvgFillc + '" stroke="none" filter="url(#contour_shadow)"></rect>';
                            patternSvg = buildShapePatternSvg( patternPathCmd, info );
                            jQuery('.nbd-stage-pattern').html('').append( patternSvg );

                            $scope.toggleStageLoading();
                            break;
                    }
                };
                img.src = data;
            }, 100);
        });
    };
    $scope.saveDataWithContour = function(){
        alert('hello');
    }
    $scope.stageDesignChanged = function(){
        $scope.$parent.$broadcast('stageDesignChanged');
    };
    $scope.$on('stageDesignChanged', function(event, args) {
        $scope.resetContour();
    });
});