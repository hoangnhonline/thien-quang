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
<h4>SỬA VIDEO</h4>
<p><span>Tên video</span><input class=txt type=text name=tenvideo id=tenvideo value="<?php echo $row['tenvideo']?>"></p>
<p><span>Id youtube</span><input class=txt type=text name=idyoutube id=idyoutube value="<?php echo $row['idyoutube']?>"></p>

<p><span>Type </span>
<input type=radio name="type" id="type" value=0 <?php echo ($row['type']==0)?"checked":""?>>Video 
<input type=radio name="type" id="type" value=1 <?php echo ($row['type']==1)?"checked":""?>>Playlist</p>
<p><span>Ngày giảng</span><input name=ngaygiang id=ngaygiang class=txt value="<?php echo date('d/m/Y',strtotime($row['ngaygiang']))?>" title="Nhập theo dạng ngày/tháng/năm" ></p>
<?php $chudevideo=$this->qt->chudevideo();?>
<p><span>Loại </span> 
<select name=chudevideo id=chudevideo class=txt>
<option value="0">Không phân loại</option> 
<?php foreach($chudevideo as $cd) {?>
<option value="<?php echo $cd['idchudevideo']?>" <?php echo ($cd['idchudevideo']==$row['idchudevideo'])?"selected":""?> >
<?php echo $cd['tenchudevideo']?>
</option>
<?php } ?>
</select></p>
<p><span>Tác giả </span>
<?php $tacgia = $this-> qt->tacgia(); ?>
<select name=idtacgia id=idtacgia class=txt>
    <option value="0">Chưa rõ tác giả</option>
	<?php foreach ($tacgia as $tg) {?>	
  	<option value="<?php echo $tg['idtacgia']?>" <?php echo ($row['idtacgia']==$tg['idtacgia'])?"selected":""?> > 
      <?php echo $tg['tieude']. " ". $tg['tentacgia'];?> 
    </option>
	<?php }?>
</select>
<input type=button id=btnchontacgia value="..." title="Nhắp để chọn tác giả">
</p>
<p><span>Mô tả</span><textarea class=txt name=mota id=mota rows=5><?php echo $row['mota']?></textarea></p>
<p><span>Ẩn hiện </span>
<input type=radio name=anhien id=anhien value=0 <?php echo ($row['anhien']==0)?"checked":""?>>Ẩn 
<input type=radio name=anhien id=anhien value=1 <?php echo ($row['anhien']==1)?"checked":""?>>Hiện</p>
<p align=center><input value=" Cập nhật " type=submit name=btn id=btn ></p>

</form>
<div id="divche"></div>
<div id="divpopup"></div>