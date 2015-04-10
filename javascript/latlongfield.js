//jQuery(document).ready(function(){
//	jQuery('input.latlong').locationPicker({
//		width: "500px",
//		height: "300px",
//		defaultLat: 51.92556,
//		defaultLng: 4.47646,
//		maptype: "ROADMAP",
//		defaultZoom: 15
//	});
//});

(function($){
	$.entwine('ss', function($){
		/**
		 * 
		 */
		$('input.latlong').entwine({
			onadd: function() {
				$(this).locationPicker({
					width: "500px",
					height: "300px",
					defaultLat: 51.92556,
					defaultLng: 4.47646,
					maptype: "ROADMAP",
					defaultZoom: 15
				});
			}
		});
	});
})(jQuery);
