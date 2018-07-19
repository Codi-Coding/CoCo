<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 지도 치환자 : 지도 또는 map
$map_txt = "지도";

?>

<style>
	body {margin:0;padding:0;background:#fff;color:#000;font-size:0.75em;}
	input, textarea { width:100%; line-height:22px !important; margin:0; border-radius:0; border:1px solid #ced9de;background:#f6f9fa;vertical-align:middle; -webkit-appearance:none}
	input { height: 22px !important; }
	textarea { padding:2; height:60px; }
	button {margin:0; padding:4px 8px; border:0; background:#000; color:#fff; border-radius:0; font-size:1em; -webkit-appearance:none; cursor:pointer}
	table{ width:100%; border-collapse:collapse; padding:0px; margin:0px; border:0px; } 
	th { text-align:center; padding:6px 10px; border-bottom:1px solid #ddd; background:#fafafa; white-space:nowrap;}
	th.white { background:#fff;}
	td { padding:6px 10px; border-bottom:1px solid #ddd;}
</style>

<?php
if($act == 'map') { 
	// 지도 초기값
	$lat = '37.566535';
	$lng = '126.977969';
	$zoom = 16;
	$map_width = '100%';
	$map_height = '425px';
?>
	<style>
		div#map { position: relative; overflow:hidden; }
		div#crosshair {
			position: absolute;
		    top: 50%;
			height: 50px;
		    width: 50px;
			left: 50%;
		    margin-left: -25px;
			margin-top:-50px;
			display: block;
		    background-image: url('../img/map-icon.png');
			background-position: center center;
		    background-repeat: no-repeat;
		}
	</style>
	<script src="https://maps.google.com/maps/api/js?v=3.exp&language=ko&region=kr&key=<?php echo APMS_GOOGLE_MAP_KEY;?>"></script>
	<script>
		var map;
		var geocoder;
		var centerChangedLast;
		var reverseGeocodedLast;
		var currentReverseGeocodeResponse;

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
			var latlng = new google.maps.LatLng(<?php echo $lat;?>, <?php echo $lng;?>);
			var myOptions = {
				zoom: <?php echo $zoom;?>,
				scaleControl: true,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			geocoder = new google.maps.Geocoder();
 
			google.maps.event.addListener(map, 'zoom_changed', function() {
				document.getElementById("zoom_level").innerHTML = map.getZoom();
				document.getElementById("map_zoom").value = map.getZoom();

				zoomLevel = map.getZoom(); 
				if (zoomLevel > 19) { 
					map.setZoom(19); 
				} else if (zoomLevel < 1) { 
					map.setZoom(1); 
				}
			});

			setupEvents();
			centerChanged();
		}
 
		function setupEvents() {
			reverseGeocodedLast = new Date();
			centerChangedLast = new Date();
 
			setInterval(function() {
				if((new Date()).getSeconds() - centerChangedLast.getSeconds() > 1) {
					if(reverseGeocodedLast.getTime() < centerChangedLast.getTime())
					reverseGeocode();
				}
			}, 1000);
 
			google.maps.event.addListener(map, 'center_changed', centerChanged);
 
			google.maps.event.addDomListener(document.getElementById('crosshair'),'dblclick', function() {
				map.setZoom(map.getZoom() + 1);
			});
		}
 
		function getCenterLatLngText() {
 
			var nn = 1000000;
			var tmpLat = Math.round(map.getCenter().lat()*nn)/nn;
			var tmpLng = Math.round(map.getCenter().lng()*nn)/nn;
 
			document.getElementById("map_lat").value = tmpLat;
			document.getElementById("map_lng").value = tmpLng;

			return tmpLat +', '+ tmpLng;
		}
 
		function centerChanged() {
			centerChangedLast = new Date();
			var latlng = getCenterLatLngText();
			var loc = latlng.split(',');	
			geocoder.geocode({latLng:map.getCenter()},reverseGeocodeResult);
			document.getElementById('lat').innerHTML = loc[0];
			document.getElementById('lng').innerHTML = loc[1];
			document.getElementById('formatedAddress').innerHTML = '';
			currentReverseGeocodeResponse = null;
		}
 
		function reverseGeocode() {
			reverseGeocodedLast = new Date();
			geocoder.geocode({latLng:map.getCenter()},reverseGeocodeResult);
		}
 
		function reverseGeocodeResult(results, status) {
			currentReverseGeocodeResponse = results;
			if(status == 'OK') {
				if(results.length == 0) {
					document.getElementById('formatedAddress').innerHTML = '';
				} else {
					document.getElementById('formatedAddress').innerHTML = results[0].formatted_address;
				}
			} else {
				document.getElementById('formatedAddress').innerHTML = '';
			}
		}

	 	function geocode() {
			var address = document.getElementById("address").value;
			geocoder.geocode({'address': address}, geocodeResult);
		}
 
		function geocodeResult(results, status) {
			if (status == 'OK' && results.length > 0) {
				map.fitBounds(results[0].geometry.viewport);
			} else {
				//alert("Info : " + status);
				alert("검색결과가 없습니다.");
			}
		}
	</script>

	<table style="border-top:3px solid #333;">
	<col width="60">
	<col>
	<col width="60">
	<tr>
		<th>위치</th>
		<td>
			<span id="formatedAddress"></span>
			(<span id="lat"></span>, <span id="lng"></span>, <span id="zoom_level"><?php echo $zoom; ?></span>)
			</td>
		<th class="white"></th>
	</tr>
	<tr>
	<th>장소</th>
	<td> 
		<input type="text" id="address" onKeyDown="if(event.keyCode==13){geocode();}" />
		<input type="hidden" id="map_lat" value="<?php echo $lat; ?>">
		<input type="hidden" id="map_lng" value="<?php echo $lng; ?>">
		<input type="hidden" id="map_zoom" value="<?php echo $zoom;?>">
	</td>
	<th class="white">
		<button type="button" onclick="geocode()">찾기</button>
	</th>
	</tr>
	<tr>
		<th>마커</th>
		<td><input type="text" id="map_marker" value="<?php echo $marker; ?>"></td>
		<th class="white"></th>
	</tr>
	<tr>
		<th>코드</th>
		<td><textarea id="map_code" name="map_code" placeholder="<?php echo ($fid) ? '생성하시면 지정하신 폼에 자동으로 지도코드가 입력됩니다.' : '생성된 지도코드를 복사하여 붙여넣어 주세요.';?>"></textarea></td>
		<th class="white"><button type="button" onclick="geocode_submit()">생성</button></th>
	</tr>
	</table>

	<div id="map">
		<div id="map_canvas" style="width:<?php echo $map_width; ?>; height:<?php echo $map_height; ?>;"></div>
		<div id="crosshair"></div>
	</div>

	<script> 
		function geocode_submit() {
			var code_lat = document.getElementById("map_lat").value;
			var code_lng = document.getElementById("map_lng").value;
			var code_zoom = document.getElementById("map_zoom").value;
			var code_marker = document.getElementById("map_marker").value;
			var code_place = document.getElementById("address").value;

			var code_geo = " geo=\"" + code_lat + "," + code_lng + "," + code_zoom + "\"";

			if(code_marker) code_marker = " m=\"" + code_marker + "\"";

			if(code_place) code_place = " p=\"" + code_place + "\"";

			var map_code = "{<?php echo $map_txt;?>:" + code_geo + code_marker + code_place + "}";

			<?php if($fid) { ?>
				parent.document.getElementById("<?php echo $fid;?>").value = map_code;
				self.close();
			<?php } else { ?>
				document.getElementById("map_code").value = map_code;
			<?php } ?>
	    }

		addLoadEvent(function() {
			initialize();
		});
	</script>
<?php } else { ?>
	<div style="padding:25px; line-height:22px; word-break:break-all">
		<b>1. 등록가능 동영상 공유주소형태</b>
		<ul>
			<li><b>유튜브 동영상</b> <br> http://youtu.be/oL2AlXWVbKU 또는 http://www.youtube.com/watch?v=oL2AlXWVbKU</li>
			<li><b>비메오 동영상</b> <br> http://vimeo.com/18923281</li>
			<li><b>다음TV 동영상</b> <br> http://tvpot.daum.net/v/kxxUvNy1ndg$</li>
			<li><b>네이트TV 동영상</b> <br> http://pann.nate.com/video/221313865</li>
			<li><b>판도라TV 동영상</b> <br> http://channel.pandora.tv/channel/video.ptv?ch_userid=sobboso&prgid=47491832</li>
			<li><b>태그스토리 동영상</b> <br> http://www.tagstory.com/video/100470056</li>
			<li><b>테드(TED) 동영상</b> <br> http://www.ted.com/talks/lang/ko/cesar_kuriyama_one_second_every_day.html</li>
			<li><b>데일리모션 동영상</b> <br> http://www.dailymotion.com/video/xzh0jv_iron-man-3-review_shortfilms</li>
			<li><b>페이스북 동영상</b> <br> https://www.facebook.com/photo.php?v=337102899759854&set=vb.470756562961560&type=2&theater</li>
			<li><b>네이버tvcast & 블로그 동영상</b> <br> http://tvcast.naver.com/v/92491</li>
			<li><b>슬라이더쉐어 동영상</b> <br> http://www.slideshare.net/boozcompany/2013-innovation-100-study-v3</li>
		</ul>

		<b>2. 동영상 입력방법</b>
		<ul>
			<li>내용에 <b>{동영상:동영상 공유주소}</b> 형태로 입력합니다. <br> ex) {동영상:http://youtu.be/oL2AlXWVbKU }</li>
			<li>동영상은 갯수제한없이 입력 가능합니다.</li>
			<li>링크에 동영상 공유주소를 등록하시면 내용상단에 해당 동영상이 자동 출력됩니다.</li>
		</ul>

		<div style="border-top:1px solid #ddd; height:15px; margin-top:15px;"></div>

		<b>3. 사운드클라우드 오디오 입력방법</b>
		<ul>
			<li>사운드 클라우드의 <b>Share > Embed > Wordpress code</b> 를 복사하여 내용에 입력합니다. </li>
			<li>[soundcloud url="https://api.soundcloud.com/tracks/150745932" params="auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&visual=true" width="100%" height="450" iframe="true" /]
			<br>
			→ Wordpress code
			</li>
			<li>오디오는 갯수제한없이 입력 가능합니다.</li>
		</ul>

		<div style="border-top:1px solid #ddd; height:15px; margin-top:15px;"></div>

		<b>4. 첨부이미지 내용 삽입 방법</b>
		<ul>
			<li>{이미지:1}, {이미지:2} 와 같이 첨부이미지 번호를 입력하면 내용에 첨부이미지를 출력할 수 있습니다.</li>
		</ul>

		<div style="border-top:1px solid #ddd; height:15px; margin-top:15px;"></div>

		<b>5. PHP 등 코드표시 방법</b>
		<ul>
			<li>보여주고 하는 코드를 [code]와 [/code]로 묶어 주시면 됩니다.</li>
			<li>[code=php] , [code=html], [code=css] 처럼 설정하시면 코드타입별로 보여 줄 수 있습니다.</li>
			<li>코드표시에 갯수제한없이 입력 가능합니다.</li>
			<li>에디터 종류에 따라 줄간격 등 문제가 발생할 수 있습니다.</li>
		</ul>

		<div style="border-top:1px solid #ddd; height:15px; margin-top:15px;"></div>

		<div class="btn_confirm01 btn_confirm">
			<button onclick="self.close();" type="button">닫기</button>
		</div>
	</div>
<?php } ?>
