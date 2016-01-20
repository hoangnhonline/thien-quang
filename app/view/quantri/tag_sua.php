<script>
$(document).ready(function(e) {
	$("#listbaiviettrongtag .xoa").click(function(){  $(this).parent().remove();  })
	$("#listbaiviettrongtag .up").click(function(){ 	
		var p = $(this).parent(); 
		swapWith = p.prev();
		p.after(swapWith.detach()); 
	})
	
});
</script>
<form action="" method="post" id="videoplaylist_them" class="form" >
<h4>SỬA TAG</h4>
<p><span>Tên tag</span><input class=txt type=text name=tentag id=tentag value="<?php echo $row['tentag']?>"></p>

<?php $baivietcuatag=$this->qt->laybaivietcuatag($row['idtag']);?>
<p><span>Các bài viết </span></p>
<ol id="listbaiviettrongtag" style="clear:left">
<?php foreach($baivietcuatag as $b) {?>
<li> &nbsp;
	<a href="#" onclick="var w=window.open('<?php echo BASE_URL?><?php echo $b['aliasLoai']?>/<?php echo $b['alias']?>.html','xemtin','width=950,height=750,top=0,left=0,scrollbars=yes'); w.focus();return false">
	<?php echo $b['idbv']?>
	</a> , 
	<a href="<?php echo BASE_DIR?>quantri/baiviet_sua/<?php echo $b['idbv']?>" >
	<?php echo $b['tieude']?>
	</a>
	<input type="hidden" name="idbv[]" value="<?php echo $b['idbv']?>">
	<input type=button value='&uarr;' class='up'/>
	<input type=button value=x class=xoa title='Nhắp vào để xóa'>
</li>
<?php } ?>
</ol>
<p align=center><input value=" LƯU " type=submit name=btn id=btn ></p>

</form>
