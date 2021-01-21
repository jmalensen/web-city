
(function($) {
	'use strict';
    
    
    $.fn.ciMap = function(customSettings, options) {
       
		var self = this,
            map = null,
			settings = $.extend({

				mapZoom: {
					mobile: 14,
					laptop: 15
				},
				mapCenter: {
					lat: 48.0246012,
					lng: -1.7513758
				}

			}, customSettings);

		var gMapsOptions = {
			el: '#' + self.attr('id'),
			zoom: settings.mapZoom.mobile,
			scrollwheel: true,
	        zoomControl : false,
            fullScreenControl: false,
	        panControl : false,
	        streetViewControl : false,
	        mapTypeControl: false,
	        overviewMapControl: false,
            scaleControl: false,
			lat: settings.mapCenter.lat,
			lng: settings.mapCenter.lng, 
			height: '100%',
            // maxZoom: 18,
		};

		if(options){
			if(options.length > 0) {
				for(var i = 0; i < options.length; i++) {
					$.extend(gMapsOptions, options[i]);
				}
			}
		}

		var createMap = function() {

			map = new GMaps(gMapsOptions);

		    // Manage window resize

		    manageMapSize();

			var resizeTimer;
			$(window).on('resize', function(e) {

				clearTimeout(resizeTimer);
				
				resizeTimer = setTimeout(function() {
					manageMapSize();
				}, 250);

			});

		};

		var manageMapSize = function() {
            
            if ($(window).width() < 768)
                map.setZoom(settings.mapZoom.mobile);
            else
                map.setZoom(settings.mapZoom.laptop);

		};
        
        createMap();

		return map;

	};

	$(document).ready(function() {

        var map = null;

		var init = function() {
                        
			if ( (!_.isUndefined(CI_MARKERS) && !_.isEmpty(CI_MARKERS)) ) {
                initMap();
                addMarkers();
			}

		};

		var initMap = function() {

			var clusterStyles = [
				{
					url: window.location.origin + "/ville-bruz/wp-content/themes/ci_ville_bruz/images/cluster_marker.png",
					width: 49,
					height: 61,
					textColor: '#FFF',
					textSize: 16,
					anchor: [-20,0],
					iconAnchor: [20,70]
				}
			];
            

            map = $('#bruz-map').ciMap( {}, [
                {               
                    markerClusterer: function(map) {
                        var options = {
                            averageCenter: true,
                            styles: clusterStyles

                        };
                        return new MarkerClusterer(map, [], options);
                    }
                }
            ] );
            

		};

		var addMarkers = function() {

			var listMarker = CI_MARKERS;

			_.forEach(listMarker, function(marker) {

				if (!_.isEmpty(marker.infoWindow)){
					_.forEach(marker, function() {
                        
                        
                        marker.click = function(e) {
                            map.setCenter(marker.lat, marker.lng);
                            map.panBy(0,-100);
                            
                            setTimeout(function(){
                                $('.infoWindow').closest('.gm-style-iw').parent().addClass('custom-iw');

                            }, 0);
                            
                            //add loading
                            /*$('.infoWindow').empty();
                            var template_directory = window.location.origin + "/wp-content/themes/ci_ville_bruz/";
                            if( window.location.origin.indexOf('cirennes.concept-image.fr') != -1)
                                template_directory = window.location.origin + "/place-to-paint//wp-content/themes/ci_ville_bruz/";

                            $('.infoWindow').append('<img id="img-loading" src="'+ template_directory + '/images/tail-spin.svg" class="loading">');

                            jQuery.post(
                                ajaxurl,
                                {
                                    'action': 'get_marker_info',
                                    'id': marker.infoWindow.ID,
                                },
                                function(response){
                                    $('.infoWindow').empty();
                                    $('.infoWindow').append(response);
                                    setTimeout(function(){
                                        $('.infoWindow').closest('.gm-style-iw').parent().addClass('custom-iw');

                                        //load image
                                        var img = $('.infoWindow').find('figure img');
                                        var img_url = img.attr('img-src');
                                        // img.attr('src', img_url);
                                        img.one('load', function() {
                                            // image loaded
                                            $(this).removeClass('loading');
                                        }).attr('src', img_url);

                                    }, 0);

                                }
                            );*/
                        };

					});

                    map.addMarker(marker);
				}

			});

		};
        
        if($('body').hasClass('page-template-page-interactive-map')) init();
        

	});

})(jQuery);