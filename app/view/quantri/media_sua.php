<script src="<?php echo BASE_DIR?>js/ckfinder/ckfinder.js" type="text/javascript"></script>
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


function BrowseServer( startupPath, functionData ){
	var finder = new CKFinder();
	finder.basePath = 'ckfinder/'; //Đường path nơi đặt ckfinder
	finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
	finder.selectActionFunction = SetFileField;//hàm được gọi khi chọn 1 file 
	finder.selectActionData = functionData; //id của textfield hiện địa chỉ hình
	finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer
function SetFileField( fileUrl, data ){	 document.getElementById( data["selectActionData"] ).value = fileUrl;  }

</script>
<form action="" method="post" id="mediaplaylist_them" class="form" >
<h4>Sửa media</h4>
<p><span>Tên media</span><input class=txt type=text name=tenmedia id="tenmedia" value="<?php echo $row['tenmedia']?>"></p>
<p><span>url</span><input class=txt type=text name=url id=url value="<?php echo $row['url']?>">
<input class=btn type=button name=chonfile id=chonfile value="..." onclick="BrowseServer('Mp3:/','url')" >
</p>
<p><span>Ẩn hiện </span>
<input type=radio name=anhien id=anhien value=0 <?php echo ($row['anhien']==0)?"checked":""?>>Ẩn 
<input type=radio name=anhien id=anhien value=1 <?php echo ($row['anhien']==1)?"checked":""?>>Hiện</p>
<?php $chudemedia=$this->qt->chudemedia();?>
<p><span>Chủ đề </span>
<select name=chudemedia id=chudemedia class=txt>
<option value="0">Không phân loại</option>
<?php foreach($chudemedia as $cd) {?>
<option value="<?php echo $cd['idchudemedia']?>" <?php echo ($cd['idchudemedia']==$row['idchudemedia'])?"selected":""?>>
<?php echo $cd['tenchudemedia']?>
</option>
<?php } ?>
</select></p>
<p><span>Tác giả </span>
<?php $tacgia = $this-> qt->tacgia(); ?>
<select name=idtacgia id=idtacgia class=txt>
    <option value="0">Chưa rõ tác giả</option>
	<?php foreach ($tacgia as $tg) {?>	
  	<option value="<?php echo $tg['idtacgia']?>" <?php echo ($row['idtacgia']==$tg['idtacgia'])?"selected":""?>> 
	<?php echo $tg['tieude']. " ". $tg['tentacgia'];?> 
	</option>
	<?php }?>
</select>
<input type=button id=btnchontacgia value="..." title="Nhắp để chọn tác giả">
</p>
<p><span>Mô tả</span><textarea class=txt name=mota id=mota rows=5><?php echo $row['mota']?></textarea></p>
<p align=center><input value=" Lưu " type=submit name=btn id=btn ></p>

</form>
<div id="divche"></div>
<div id="divpopup"></div>