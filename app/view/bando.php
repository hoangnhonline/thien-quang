<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=vi"> </script>
<div id="duongdenchuathienquang">
<h1>Đường đến chùa Thiên Quang</h1>

<div id="divbando"> </div>
<script>
function hienbandochua() {
    var opt = {
      center: new google.maps.LatLng(10.883987, 106.784759), zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP //ROADMAP/SATELLITE/HYBRID/TERRAIN
    };
    var bd1 = new google.maps.Map(document.getElementById("divbando"), opt);
    //tạo maker, infowindow
	var m1 = new google.maps.Marker({
			position: new google.maps.LatLng(10.883987 ,106.784759),
			map: bd1, title:'Chùa Thiên Quang'
	});
	var info = new google.maps.InfoWindow(
	{ content: "Chùa Thiên Quang (Thiên Quang Ni Tự).<br>Địa chỉ: Số 106/15 khu phố Đông Hòa, phường Dĩ An, huyện Dĩ An, tỉnh Bình Dương",
	  height:"200px"
	});
	google.maps.event.addListener(m1,'click',function(){info.open(bd1,m1)});
	info.open(bd1,m1);
}
google.maps.event.addDomListener(window, 'load', hienbandochua);
</script>

<p id="tc"><a href="<?php echo BASE_URL?>">Trang Chủ Chùa Thiên Quang</a></p>
</div>