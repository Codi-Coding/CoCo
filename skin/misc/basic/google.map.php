<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

//설정값
list($lat, $lng, $zoom) = explode(",",$geo);
$lat = $lat ? $lat : '37.566535';
$lng = $lng ? $lng : '126.977969';
$zoom = $zoom ? $zoom : 14;

//지역정보
if($place) {
	$address = $place;
} else {
	$json = google_map_address_json($lat, $lng);
	$address = $json['results'][0]['formatted_address'];
}

$address = urlencode($address);

?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>구글지도보기</title>
<style>
	body { margin:0; padding:0; font:normal 12px dotum; -webkit-text-size-adjust:100%; }
	a { color: rgb(51, 51, 51); cursor: pointer; text-decoration: none; }
	a:hover, a:focus, a:active { color: crimson; text-decoration: none; }
	.infowindow { min-width:180px; max-width:280px; line-height:22px; }
	.infoline { height:6px; }
</style>
<script src="https://maps.google.com/maps/api/js?v=3.exp&language=ko&region=kr&key=<?php echo APMS_GOOGLE_MAP_KEY;?>"></script>
<script>
	// 구글맵
	var map;
	var marker;
	var markerimg = '../img/map-icon.png';
	var infowindow;
	var geocoder;
	var myLatlng;

	function addLoadEvent(func) {
		var oldonload = window.onload;
		if (typeof window.onload != 'function') {
			window.onload = func;
		} else {
			window.onload = function() {
				if (oldonload) {
					oldonload();
				}
				func();
			}
		}
	}

	function initialize() {
		myLatlng = new google.maps.LatLng("<?php echo $lat; ?>", "<?php echo $lng; ?>");
		geocoder = new google.maps.Geocoder();
		var myOptions = {
			zoom: <?php echo $zoom; ?>,
			scaleControl: true,
			navigationControl: true,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.SMALL,
				position: google.maps.ControlPosition.TOP_RIGHT
			},
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}

		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		marker = new google.maps.Marker({
			position: myLatlng,
			icon: markerimg,
			map: map
		});

		infowindow = new google.maps.InfoWindow();

		var infotxt = '';
		<?php if($marker) { ?>
			infotxt += "<?php echo $marker;?>";
			infotxt += "<div class='infoline'></div>";
		<?php } ?>
		infotxt += "<a href='#' onclick='geocodeAddress();'>자세히 보기</a>";

		infowindow.setContent("<div class='infowindow'>" + infotxt + "</div>");
		infowindow.open(map,marker);

		google.maps.event.addListener(map, 'zoom_changed', function() {
			zoomLevel = map.getZoom(); 
			if (zoomLevel > 19) { 
			  map.setZoom(19); 
			} else if (zoomLevel < 1) { 
			  map.setZoom(1); 
			}   
		});
	}

	function geocodeAddress() {
		var address = "<?php echo $address;?>";

		if(address) {
			address = "place/" + address + "/";
		}

		var url = "https://www.google.co.kr/maps/" + address + "@<?php echo $lat;?>,<?php echo $lng;?>,<?php echo $zoom;?>z?hl=ko";
		window.open(url);
		return false;
	}
</script>
</head>
<body>
	<div id="map_canvas" class="google_map" style="width:100%; height:480px;"></div>
	<script> addLoadEvent(initialize); </script>
</body>
</html>