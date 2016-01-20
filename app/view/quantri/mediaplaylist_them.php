<script>
$(document).ready(function(e) {
	$("#mediaplaylist_them").submit(function(){
		if ($("#tenmediaplaylist").val()=="") {
			alert("Chưa nhập tên playlist");
			return false;
		}
	})
	$("#btnchontacgia").click(function(){
		$("#divche").show().fadeTo(0,0.7,hienpopup); 	
	});
	$("#add_items").click(function(){
		var soluong=$("#items_num").val();
		if (soluong<=0 || soluong=="") soluong=5;
		for (i=0; i<soluong;i++){			
            c= "<li><input name='medianame[]' class='medianame' title='Tiêu đề file '>";
			c+="<input name='mediaurl[]' title='Địa chỉ file'>";
			c+="<input type=button value='&uarr;' class='up'/> ";
			c+="<input type=button value=x class=xoa title='Nhắp vào để xóa'></li>";
            $("#mediacontainer").append(c);
		}
		$("#mediacontainer .xoa").click(function(){  $(this).parent().remove();  })
		$("#mediacontainer .up").click(function(){ var p = $(this).parent();  swapWith = p.prev();  p.after(swapWith.detach()); })
	})
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
<script type="text/javascript">
var api;
function BrowseServer( startupPath, functionData ){
	var finder = new CKFinder();
	finder.basePath = '<?php echo BASE_DIR?>js/ckfinde_r/'; //Đường path nơi đặt ckfinder
	finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
	finder.selectActionFunction = SetFileField;//hàm được gọi khi chọn 1 file 
	finder.selectActionData = functionData; //id của textfield hiện địa chỉ hình
	api = finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer
function SetFileField( fileUrl, data ){
        var arr=api.getSelectedFiles();  
		var tenfile,c;
        for (i = 0; i< arr.length; i++) {           
			tenfile =String(arr[i]).replace(/.mp3/gi,"");
            c= "<li><input name='medianame[]' class=medianame value='" + tenfile+ "'>";
			c+="<input type=hidden name='mediaurl[]' value='"+ arr[i].getUrl()+ "'>";
			c+="<span class=mediafilename>" + arr[i] + "</span><input type=button value='&uarr;' class='up'/> ";
			c+="<input type=button value=x class=xoa title='Nhắp vào để xóa'></li>";
            $("#mediacontainer").append(c);
        }
        $("#mediacontainer .xoa").click(function(){  $(this).parent().remove();  })
		$("#mediacontainer .up").click(function(){ var p = $(this).parent();  swapWith = p.prev();  p.after(swapWith.detach()); })
}
</script>

<form action="" method="post" id="mediaplaylist_them" class="form" >
<h4>Thêm media playlist</h4>
<p><span>Tên playlist</span><input class=txt type=text name=tenmediaplaylist id=tenmediaplaylist></p>
<p><span>Ẩn hiện </span><input type=radio name=anhien id=anhien value=0>Ẩn 
<input type=radio name=anhien id=anhien value=1 checked>Hiện</p>
<?php $chudemedia=$this->qt->chudemedia();?>
<p><span>Chủ đề </span>
<select name=chudemedia id=chudemedia class=txt>
<option value="0">Không phân loại</option>
<?php foreach($chudemedia as $row) {?>
<option value="<?php echo $row['idchudemedia']?>"><?php echo $row['tenchudemedia']?></option>
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
<p align=center><input value=" THÊM " type=submit name=btn id=btn ></p>
<ol id="mediacontainer"></ol>
<div style="clear: left;"></div>
<input  type=button id="chonfilemp3" onclick="BrowseServer('mp3://','')" value="Chọn file MP3"/>
<div id="additems">
	<input id="items_num" value="5"> <input type="button" value="+" id="add_items">
</div>
</form>
<div id="divche"></div>
<div id="divpopup"></div>