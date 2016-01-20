<?php $baimd = $this->model ->baimoi(20);?>
<link rel="stylesheet" href="<?php echo BASE_URL?>js/custom-scrollbar/jquery.mCustomScrollbar.css">
<script src="<?php echo BASE_URL?>js/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
		$(function($){
			$(window).load(function(){				
				$("#baimoi_content").mCustomScrollbar({
					scrollButtons:{enable:true,scrollType:"stepped"},
					keyboard:{scrollType:"stepped"},
					mouseWheel:{scrollAmount:188},
					theme:"rounded-dark",
					autoExpandScrollbar:true,
					snapAmount:188,
					snapOffset:65
				});
				
			});
		})
</script>
<div id="baimoi" >
<p class="caption">Tin tức chùa Thiên Quang</p>
<div id="baimoi_content">
<?php foreach ($baimd as $rowmd) {?>
<div class="motbai">
<img src="<?php echo BASE_URL.$rowmd['urlhinh']?>" align="left" class="hinh">
<p>
<a href="<?php echo BASE_URL.$rowmd['alias']?>.html"> <?php echo $rowmd['tieude'];?> </a>
<?php echo htmlentities($rowmd['tomtat'],ENT_QUOTES,'utf-8');?>
</p>
</div>
<?php } ?>
<p class="xemtiep"><a href="#">Xem tiếp...</a></p>
</div>
</div>