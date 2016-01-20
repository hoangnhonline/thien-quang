<div id="locbaiviet">
<script>
$(document).ready(function(e) {
	$("#btnlocbv").click(function(){		
		var tukhoa=$("#tukhoalocbv").val(); if (tukhoa=="Từ khóa") tukhoa="";
		var taglocbv=$("#taglocbv").val(); if (taglocbv=="Tag") taglocbv="";		
		var idloaibv= $("#selLoaiBV").val();
		
		if (idloaibv==-1 && tukhoa=="" && taglocbv=="") {alert("Hãy chọn loại hoặc từ khoá hoặc tag"); return;}
		url="<?php echo BASE_DIR?>quantri/baiviet_loc/" + idloaibv +"/" + tukhoa +"/" + taglocbv +"/";
		
		$("#listBV_filtered").html("");
		//alert(url);
		$("#listBV_filtered").load(url);
	})
	$("#btnclear").click(function(){
		$("#tukhoalocbv").val("Từ khóa");
		$("#taglocbv").val("Tag");
		$("#selLoaiBV").val("-1");
		$("#listBV_filtered").html("");
	})
	$("#formlocbv").keypress(function(e){
		if (e.which==13) $("#btnlocbv").click();
	})
})
</script>

<form id="formlocbv">
<p>Chọn bài viết</p>
<?php $listloaiBV = $this->qt->listloai_dequy();
?>
<p><select id="selLoaiBV">
<option value=-1>Chọn loại</option>
<?php foreach ($listloaiBV as $loai) {?>
<option value="<?=$loai['id']?>"> <?=$loai['ten']?></option>
<?php }?>
</select>
<input name="taglocbv" id="taglocbv" title="Lọc bài viết theo tag" onclick="if (this.value=='Tag') this.value='';" onblur="if (this.value=='') this.value='Tag'" value="Tag">

</p>
<p>
<input name="tukhoalocbv" id="tukhoalocbv" title="Tìm theo tiêu đề, tóm tắt và idbv" onclick="if (this.value=='Từ khóa') this.value='';" onblur="if (this.value=='') this.value='Từ khóa'" value="Từ khóa">
<input type=button id="btnlocbv" value="  LỌC  "/>
<input type=button id="btnclear" value="XOÁ"/>
</p>
</form>
<div id="listBV_filtered"></div>
</div>