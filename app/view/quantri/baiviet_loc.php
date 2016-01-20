<script>
$(document).ready(function(){
	$(".bvloc").click(function(){
		var url = this.href;
		var w = window.open(url, 'bv', 'top=0, left=0,width=700, height=650')
		return false;
	})
	$(".chonbai").click(function(){
		var bai= $(this).parent().prev();		
		var code = $('<div>').append(bai.clone()).html();
		CKEDITOR.instances.noidung.insertHtml(code);
	});
	$(".makelink").click(function(){
		var url= $(this).parent().prev().find("a").attr("href");		
		CKEDITOR.instances.noidung.insertHtml('<a href=\x22' + url +'\x22>' + CKEDITOR.instances.noidung.getSelection().getNative() + '</a>');
	});
	
})
</script>
<?php if (count($dsbaiviet)==0) echo "Không có bài viết nào"; else foreach ($dsbaiviet as $bai){?>	
	<div class="bailienquan">
	<h4>
	<a class="bvloc" href="<?php echo BASE_DIR.$bai['aliasLoai']."/".$bai['aliasBV']?>.html"><?php echo $bai['tieude']?></a>
	</h4>
	<p class=tomtat>
	<?php if ($bai['urlhinh']!="") {?>
	<img align=right width=75 height=60 src="<?php echo $bai['urlhinh']?>">
	<?php }?>
	<?php echo $bai['tomtat']?>
	</p>
	</div>
	<p class="act">
	(<span class=ngay title="Ngày đăng"><?php echo $bai['ngay']?> </span> , <span class=idbv title="idbv"><?php echo $bai['idbv']?> </span>)  &nbsp;- 
	 &nbsp; 
	<img src="<?php echo BASE_DIR?>img/arrow-right.jpg" class="chonbai"> &nbsp; 
	<img src="<?php echo BASE_DIR?>img/makelink.jpg" class="makelink">
	</p>
	
<?php }?>