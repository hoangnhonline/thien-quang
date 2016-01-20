<script type="text/javascript" src="<?php echo BASE_ROOT?>js/bxslider/jquery.bxslider.min.js"></script>
<link href="<?php echo BASE_ROOT?>js/bxslider/jquery.bxslider.css" rel="stylesheet" />
<script>
$(document).ready(function(){
	$(document).ready(function(){
	  $('.bxslider').bxSlider({
		auto: true,
		speed: 6000,
		mode: 'fade',
		preloadImages: 'all',
		pager:false,
		controls: false,
	  });
	});
})
</script>
<ul id="loivangngoc" class="bxslider">	
	<li><img src="<?php echo BASE_URL?>img/kinh-phap-cu/kinh-phap-cu-1.png"/></li>
	<li><img src="<?php echo BASE_URL?>img/kinh-phap-cu/kinh-phap-cu-2.png"/></li>
	<li><img src="<?php echo BASE_URL?>img/kinh-phap-cu/kinh-phap-cu-3.png"/></li>
</ul>