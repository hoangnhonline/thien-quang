<script>
$(document).ready(function(e) {
	$("#btnchontacgia").click(function(){
		$("#divche").show().fadeTo(0,0.7,hienpopup); 	
	});
});
function hienpopup(){		
	var url = "<?php echo BASE_DIR?>quantri/tacgia_listdechon/";
    $("#divpopup").load(url, null, function(a){ 
		var L= (screen.width-$("#divpopup").width())/2;
		$("#divpopup").css("left", L + "px");
		$(this).show(); 
	})	
}//hienpopup
</script>
<form action="" method="post" id="videoplaylist_them" class="form" >
<h4>Thêm video</h4>
<p><span>Tên video</span><input class=txt type=text name=tenvideo id=tenvideo></p>
<p><span>Id youtube</span><input class=txt type=text name=idyoutube id=idyoutube></p>
<p><span>Type </span><input type=radio name="type" id="type" value="0" checked />Video
<input type=radio name="type" id="type" value=1 >Playlist</p>

<p><span>Ngày giảng</span><input name=ngaygiang id=ngaygiang class=txt value="dd/mm/yyyy" title="Nhập theo dạng ngày/tháng/năm" onfocus="if (this.value=='dd/mm/yyyy')this.value=''"></p>
<?php $chudevideo=$this->qt->chudevideo();?>
<p><span>Chủ đề </span>
<select name=chudevideo id=chudevideo class=txt>
<option value="0">Không phân loại</option>
<?php foreach($chudevideo as $row) {?>
<option value="<?php echo $row['idchudevideo']?>"><?php echo $row['tenchudevideo']?></option>
<?php } ?>
</select></p>
<p><span>Tác giả </span>
<?php $tacgia = $this-> qt->tacgia(); ?>
<select name=idtacgia id=idtacgia class=txt>
    <option value="0">Chưa rõ tác giả</option>
	<?php foreach ($tacgia as $tg) {?>	
  	<option value="<?php echo $tg['idtacgia']?>"> <?php echo $tg['tieude']. " ". $tg['tentacgia'];?> </option>
	<?php }?>
</select>
<input type=button id=btnchontacgia value="..." title="Nhắp để chọn tác giả">
</p>
<p><span>Mô tả</span><textarea class=txt name=mota id=mota rows=5></textarea></p>
<p><span>Ẩn hiện </span><input type=radio name=anhien id=anhien value=0>Ẩn 
<input type=radio name=anhien id=anhien value=1 checked>Hiện</p>
<p align=center><input value=" Thêm " type=submit name=btn id=btn ></p>

</form>
<div id="divche"></div>
<div id="divpopup"></div>