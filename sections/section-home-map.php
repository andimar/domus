<?php

$custom_header = get_custom_header();

$image = wp_get_attachment_image_url( $custom_header->attachment_id, 'regina-lite-slider-image-sizes' );

// get image meta by ID
$image_meta = get_post_meta( $image_id );


?>
<style>
		 /* Always set the map height explicitly to define the size of the div
			* element that contains the map. */
		 #domus_map {
			 height: 100%;
		 }
</style>

<div id="home-map" class="clear">
	<div id="services-title-block" class="col-xs-12">
	 <a id="dovesiamo"></a>
	 <div class="section-info">
			 <h2>Dove Siamo</h2>
			 <hr>
			 <p>Il laboratorio è facile da raggiungere con la metro C (stazione Mirti o Gardenie), con le linee dei tram 5 e 19</p>
			 <!--p>Per chi arriva in auto, parcheggio convenzionato (Via dei Castani) </p-->
	 </div><!--.section-info-->
 </div><!--.col-xs-12-->
<div class="clear"></div>
<div id="domus_map">

</div>
	<?php
	do_shortcode('[osm_map_v3 map_center="41.8864,12.5662" zoom="18.2" width="100%" height="350" post_markers="1" ]');
	do_shortcode('[leaflet-map lat="41.886301" lng="12.555290" zoom="19" width="100%" height="250"]');
	echo '<!--ciao-->'
?>


<!--script>
	var domus_map;
	function initMap() {
		var lab_coords = {lat: 41.886301, lng: 12.566290};
		var domus_map = new google.maps.Map(document.getElementById('domus_map'), {
			center: lab_coords,
			zoom: 19,
			scrollwheel: false
		});
		var marker = new google.maps.Marker({
			position: lab_coords,
			map: domus_map
		});
	}
</script-->

<!--script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAORHAA_QwiSGtgkAan1AbABI2DVW3ZF9s&callback=initMap"></script-->
<!--scrip t async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcKxgf-eroJpcG-ciEdgWlhTuMDfHLCpY&callback=initMap"></script-->







</div><!--/#home-map.clear-->
