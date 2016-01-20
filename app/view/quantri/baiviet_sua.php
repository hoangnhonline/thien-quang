<link rel="stylesheet" href="<?php echo BASE_DIR?>js/jquery-ui-1.11.1.css">
<script src="<?php echo BASE_DIR?>js/jquery-ui-1.11.1.js"></script>
<style>
.ui-autocomplete-loading {
	background: white url("<?php echo BASE_DIR?>img/ui-anim_basic_16x16.gif") right center no-repeat;
}
</style>

<script type="text/javascript">
var CoHinhShareRoi=false;
function BrowseServer( startupPath, functionData ){
	var finder = new CKFinder();
	finder.basePath = '<?php echo BASE_DIR?>js/ckfinder/'; //Đường path nơi đặt ckfinder
	finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
	finder.selectActionFunction = SetFileField;//hàm được gọi khi chọn 1 file 
	finder.selectActionData = functionData; //id của textfield hiện địa chỉ hình
	CKFinder.config.language = 'vi';
	finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer
function SetFileField( fileUrl, data ){
	document.getElementById( data["selectActionData"] ).value = fileUrl;
	var w=0, h=0;
	$("#hinhdaidien").attr("src",fileUrl);
	$("<img/>").attr("src",fileUrl).load(function() { 
		w = this.width; h = this.height; 
		if (w>=200 && h>=200) {
			$("#urlhinh_sharefacebook").val(fileUrl);
			$("#hinhsharefacebook").attr("src",fileUrl);
			CoHinhShareRoi=true;
		}
		else {
			//alert('Hình bạn chọn không đủ lớn để dùng share facebook! Hình mặc định sẽ được chọn');
			$("#hinhsharefacebook").attr("src","<?php echo BASE_URL;?>img/chua-thien-quang.jpg");
		}
    });
}

$(document).ready(function(){

	$("#hinhsharefacebook").click(function(){
		var oEditor = CKEDITOR.instances.noidung;			
		var codehtml = oEditor.getData();
		var obj =$(codehtml);
		var listhinh = obj.find('img');
		//if (listhinh.length==0) {alert("Chưa có hình nào trong nội dung tin"); return;}		
		var dunglai=false;
		listhinh.each(function(){
			diachihinh =this.src; 
			rong = this.width; cao = this.height; 
			if (rong>=200 && cao>=200 && dunglai==false) {
				$("#urlhinh_sharefacebook").val(diachihinh);
				$("#hinhsharefacebook").attr("src",diachihinh);
				CoHinhShareRoi=true;
				dunglai=true;
			}
		});
		//if (dunglai==false) { alert("Các hình trong nội dung tin nhỏ quá, không thể dùng để share. Nhắp đúp để chọn hình khác"); return;}
	})
	$("#hinhsharefacebook").dblclick(function(){
		CoHinhShareRoi=false;
		$("#hinhsharefacebook").attr("src",""); //bỏ hình hiện tại, nếu có
		
		var finder = new CKFinder();
		finder.basePath = '<?php echo BASE_DIR?>js/ckfinder/'; 
		finder.startupPath = 'hinh-bai-viet:/'; 
		finder.selectActionFunction = function(fileUrl, data ){
			$("<img/>").attr("src",fileUrl).load(function() { 
				w = this.width; h = this.height; 
				if (w>=200 && h>=200) {
					$("#urlhinh_sharefacebook").val(fileUrl);
					$("#hinhsharefacebook").attr("src",fileUrl);
					CoHinhShareRoi=true;
				}
				else {
					alert('Hình bạn chọn không đủ lớn để dùng share facebook! (>=200x200)');
					var urlHinhShare= "<?php echo BASE_URL.SHARE_IMAGE;?>";
					$("#urlhinh_sharefacebook").val(urlHinhShare);
					$("#hinhsharefacebook").attr("src",urlHinhShare);
				}
			});
		};
		finder.selectActionData = 'urlhinh_sharefacebook'; 
		CKFinder.config.language = 'vi';
		finder.popup(); 
		
	})
})


$(document).ready(function(e) {
	$("#btnchontacgia").click(function(){
		$("#divche").show().fadeTo(0,0.7,hienpopup); 	
	});
});
function hienpopup(){		
	var url = "<?php echo BASE_DIR?>quantri/tacgia_listdechon/-1/";
    $("#divpopup").load(url, null, function(a){ 
		var L= (screen.width-$("#divpopup").width())/2;
		$("#divpopup").css("left", L + "px");
		$(this).show(); 
	})	
}//hienpopup

</script>
<div id="richContent">
<div id="richContent_left">
<?php include "form_locbaiviet.php";?>
</div>
<div id="richContent_right">
<form action="" method="post" id="baiviet_them" class="formbv" accept-charset="UTF-8">
<table width=100% border=0 cellpadding=0>
<tr><td><h4>SỬA BÀI VIẾT</h4></td>
<td> &nbsp; </td>
</tr>
<tr class=info>
<td valign=top align=left >
<p><input class=txt type=text name=tieude id="tieude" value="<?php echo htmlentities($row['tieude'],ENT_QUOTES,'utf-8');?>" title="Tiêu đề tin" /></p>
<p><textarea class=txt type=text name=tomtat id=tomtat title="Nhập mô tả cho tin" /><?php echo $row['tomtat']?></textarea></p>
<p>
<input type="hidden" value="<?php echo $row['urlhinh_sharefacebook']?>" name="urlhinh_sharefacebook" id="urlhinh_sharefacebook" />
<img id="hinhsharefacebook" src="<?php echo $row['urlhinh_sharefacebook']?>" title="Hình share facebook. Nhắp để chọn hình trong nội dung, nhắp đúp để chọn hình khác" />
<img id="hinhdaidien" onclick="BrowseServer('hinh-bai-viet:/','urlhinh')" src="<?php echo $row['urlhinh']?>" title="Đây là hình đại diện của tin" />

<input class=txt type=hidden name=urlhinh id="urlhinh" value="<?php echo $row['urlhinh']?>" title="Nhập địa chỉ hình đại diện cho tin" />
</p>
<p>
<div class="ui-widget">
<textarea type=text name=tag id=tag title="Nhập tag cho tin"><?php echo $this->qt->laytagcuabaiviet($row['idbv'])?></textarea>
</div>
</p>
</td>
<td valign=top>
<p>
<?php $tacgia = $this-> qt->tacgia(); ?>
<select name=tacgia id=tacgia>
    <option value="0">Chọn tác giả</option>
	<?php foreach ($tacgia as $tg) {?>	
  	<option value="<?php echo $tg['idtacgia']?>" <?php echo ($row['idtacgia']==$tg['idtacgia'])?"selected":""?> > 
	<?php echo $tg['tentacgia'];?> 
	</option>
	<?php }?>
</select>
<input type=button id=btnchontacgia value="..." title="Nhắp để chọn tác giả">
</p>
<p style="margin:10px 0 10px 0">
<input type=checkbox name=anhien id=anhien value=1  <?php echo ($row['anhien']==1)?"checked":""?> >Hiện &nbsp; 
<input type=checkbox name=noibat id=noibat value=1 <?php echo ($row['noibat']==1)?"checked":""?> >Nổi bật &nbsp; 
<input type=checkbox name=themykien id=themykien value=1  <?php echo ($row['themykien']==1)?"checked":""?>>Nhập YK</p>

<p>
<?php $phanloai = $this-> qt->listloai_dequy(0); ?>
<select name=loaicha id=loaicha class=txt1>
	<?php foreach ($phanloai as $loai) {?>
  	<option value="<?php echo $loai['id']?>" <?php echo ($row['idloai']==$loai['id'])?"selected":""?> > 
	<?php echo $loai['ten'];?> 
	</option>
	<?php }?>
</select>
</p>
<p style="margin-top:10px;"><input value="SAO CHÉP" type=submit name="btnCopy" class="btnsubmit" ></p>
<p><input value=" LƯU " type=submit name=btn id=btn >&nbsp; <input type=checkbox  name=capnhatngay>Lưu ngày</p>
</td>
</tr>
<tr>
<td colspan=2>
<textarea name=noidung id=noidung class="ckeditor"><?php echo $row['content']?></textarea>
<script>
CKEDITOR.replace( 'noidung',{		
		filebrowserImageBrowseUrl : '<?php echo BASE_DIR?>js/ckfinder/ckfinder.html?Type=hinh',
		filebrowserFlashBrowseUrl : '<?php echo BASE_DIR?>js/ckfinder/ckfinder.html?Type=Flash',
		filebrowserImageUploadUrl : '<?php echo BASE_DIR?>js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
		filebrowserFlashUploadUrl : '<?php echo BASE_DIR?>js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
		filebrowserBrowseUrl : '<?php echo BASE_DIR?>js/ckfinder/ckfinder.html',
}
);
</script>
</td>
</tr>
</form>
</div>
</div> <!-- richContent-->
<div id="divche"></div>
<div id="divpopup"></div>