<?php
  $idloai=-1; if (isset($this->params[0])==true) $idloai= $this->params[0];     
  settype($idloai,"int"); if ($idloai<=0) $idloai=-1;  
  
  $idtacgia=-1;  if (isset($this->params[1])==true) $idtacgia= $this->params[1];     
  settype($idtacgia,"int"); if ($idtacgia<=0) $idtacgia=-1;   
  
  $noibat=-1; if (isset($this->params[2])==true) $noibat= $this->params[2]; settype($noibat,"int");  
  $anhien=-1; if (isset($this->params[3])==true) $anhien= $this->params[3]; settype($anhien,"int");
	
  $sapxepbaiviettheo = $this->params[4];  settype($sapxepbaiviettheo,"int"); 
  
  $currentpage= 1; if (isset($this->params[5])==true)  $currentpage = $this->params[5]; settype($currentpage,"int");
  
  if ($idloai==-1 AND $idtacgia==-1 AND $currentpage==-1) $_SESSION['tukhoatimbv']=""; //trường hợp nhắp link "Xem hết"
  if (isset($_POST['tukhoatimbv'])) {
    $_SESSION['tukhoatimbv']=$_POST['tukhoatimbv']; 
    $currentpage=0; //nếu có từ khóa thì chuyển về trang đầu
  }
  if ($currentpage<=0) $currentpage=1;
  $per_page=PER_PAGE; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
   
  $kq = $this->qt->baiviet_list($idloai,$idtacgia,$noibat, $anhien,$sapxepbaiviettheo,$per_page,$start, $totalrows);	
  
  $hienthutu=false;
  if ($idloai>0){
	$loaibv= $this->qt->chitietloaibaiviet($idloai);
	if ($loaibv['sapxepbaiviettheo']>=2) $hienthutu=true;
  }
?>
<script>
$(document).ready(function(){
	$(".anhien").click(function(){
		var idbv = $(this).attr("idbv");
		var url="<?php BASE_DIR?>quantri/baiviet_daoanhien/" + idbv +"/";
		var obj=this;
		$.get(url,null, function(d){ 
			obj.src=d; 
			if (d=="AnHien_0.jpg") obj.title="Bài viết này đang ẩn, nhắp vào để hiện";  
			else obj.title="Bài viết này đang hiện, nhắp vào để ẩn";  
		})
	})
	$(".noibat").click(function(){
		var idbv = $(this).attr("idbv");
		var url="<?php BASE_DIR?>quantri/baiviet_daonoibat/" + idbv +"/";
		var obj=this;
		$.get(url,null, function(d){ 
			obj.src=d; 
			if (d=="NoiBat_0.jpg") obj.title="Bài viết này bình thường, nhắp vào để cho nổi bật";  
			else obj.title="Bài viết này đang nổi bật, nhắp vào để tắt";  
		})
	})
	$(".dangbai").click(function(){
		var idbv = $(this).attr("idbv");
		var url="<?php echo BASE_DIR?>quantri/baiviet_dangbai/" + idbv +"/";
		var obj=$(this);
		$.get(url,null, function(d){ 
			if (d=="OK") {
				if (obj.parent().text().indexOf("Bài đã đăng")<0)// nếu user nhắp lần 2,3 thì không phải thông báo 
				obj.parent().append("<b id='thongbao'>Bài đã đăng</b>");
				obj.parent().find(".anhien").attr("src","<?php echo BASE_DIR?>img/AnHien_1.jpg");
			}
			else alert(d);
		})
	});
	$("#sapxepbaiviettheo").change(function(){
		var url="<?php echo BASE_DIR?>quantri/baiviet_list/<?php echo $idloai?>/<?php echo $idtacgia?>/<?php echo $noibat?>/<?php echo $anhien?>/" + this.value;
		document.location=url;
	});
	$("#hinhsave").click(function(){
		var dulieu = $("#formlist").serialize();	
		$.ajax({
			url:"<?php echo BASE_DIR?>quantri/capnhatthutubaiviet/", cache:false, data:dulieu, type:'post',
			success:function(d){ alert(d);}
		})	
	})
})
</script>
<table width=100%>
<tr>
<td class="colleft" valign=top id="listbv_cottrai">
<div id="loaibaivietTree">
<?php 
$baseUrlForTree=BASE_URL."quantri/baiviet_list/";
include "loaibaiviet_tree.php"?>
</div>
</td>
<td valign=top id="listbv_cotgiua">
<table id=list width=100% border=0 cellpadding=4 cellspacing=0 align=center class="list">
<tr class="captionrow">
<td>
	<table>
	<tr>	<td width=230><span >Quản trị bài viết</span></td>
			<td align=left id="xembai">				
				<a href="<?php echo BASE_URL?>quantri/baiviet_list/-1/-1/1/-1" id="xembainoibat">Bài nổi bật</a>
				<a href="<?php echo BASE_URL?>quantri/baiviet_list/-1/-1/-1/0" id="xembaidangan">Bài đang ẩn</a>
				<a href="<?php echo BASE_URL?>quantri/baiviet_list/-1/-1/-1">Xem hết</a>
			</td>
	</tr>
	</table>
</td>
<td>
<a href="<?php echo BASE_URL?>quantri/baiviet_them" title="Thêm bài viết" id="thembv">THÊM BV</a>
</td>
</tr>
<tr><td colspan=2 align=midden height=50>
<?php $phanloai = $this-> qt->listloai_dequy(0); ?>
<div style="float:left; margin-top:10px; ">
<form action="" method="post" style="margin: 0;">
<select name=loaicha id=loaicha class=txt1 onchange='document.location="<?php echo BASE_DIR?>quantri/baiviet_list/" + this.value;' title='Chọn để chỉ xem bài trong loại bạn muốn'>
	<option value=-1>Tất cả loại</option>
	<?php foreach ($phanloai as $loai) {?>
  	<option value="<?php echo $loai['id']?>" <?php echo ($idloai==$loai['id'])?"selected":""?> > 
	<?php echo $loai['ten'];?> 
	</option>
	<?php }?>
</select>
<input type="text" name="tukhoatimbv" id="tukhoatimbv" value="<?php echo $_SESSION['tukhoatimbv']?>" size="18" title="Nhập từ khóa tìm kiếm rồi Enter. Có thể tìm theo tiêu đề, mô tả hoặc idbv">
Có <?php echo $totalrows?> bài viết.
<select name="sapxepbaiviettheo" id="sapxepbaiviettheo">
	<option value="0" <?php echo ($sapxepbaiviettheo==0)?"selected":""?> >
	Sắp idbv giảm dần
	</option>
	<option value="1" <?php echo ($sapxepbaiviettheo==1)?"selected":""?>>
	Sắp idbv tăng dần
	</option>
	<option value="2" <?php echo ($sapxepbaiviettheo==2)?"selected":""?>>
	Sắp thứ tự tăng dần
	</option>
	<option value="3" <?php echo ($sapxepbaiviettheo==3)?"selected":""?>>
	Sắp thứ tự giảm dần
	</option>
</select>
</form>
</div>
<div style="float:right;" id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/baiviet_list/$idloai/$idtacgia/$noibat/$anhien/$sapxepbaiviettheo", $totalrows, 3,$per_page, $currentpage);?>
</div>
</td></tr>
<tr>
<th>Thông tin bài viết</th>
<th>Action
<?php if ($hienthutu) {?>
&nbsp; <img id=hinhsave src="<?php echo BASE_DIR?>img/save.png" title="Cập nhật thứ tự"/>
<?php }?>
</th>
</tr>
<form id="formlist">
<?php foreach($kq as $row){ 
$loaibv= $this->qt->chitietloaibaiviet($row['idloai']);
?>
<tr class=motbaiviet>
<td valign=top>
 <a class="xembv" href="#" onclick="var w=window.open('<?php echo BASE_URL?><?php echo $loaibv['alias']?>/<?php echo $row['alias']?>.html','xemtin','width=950,height=750,top=0,left=0,scrollbars=yes'); w.focus();return false" title="Xem bài viết"> 
 <img class="xembv" src="<?php echo $row['urlhinh']?>" align="right" title="Xem bài viết" >
 </a>
<h4 class="tieude"><?php echo $row['tieude']?>
 &nbsp (<span class="idbv" title="idbv"><?php echo $row['idbv']?></span>, 
<span class="tenloai" title="Bài viết hiện đang được đặt trong loại này">
<a href="<?php echo BASE_DIR?>quantri/baiviet_list/<?php echo $row['idloai']?>/-1/"> <?php echo $loaibv['tenloai'];?></a>
</span>, <span class="xem" title="Số lần xem"><?php echo $row['solanxem']?>)</span>&nbsp; 
<span class="ngaydang" title="Ngày đăng"><?php echo date('d/m/Y',strtotime($row['ngay']))?>. </span>
<?php $tagcuabv=$this->qt->laytagcuabaiviet($row['idbv']); if ($tagcuabv!=""){?>
<br><span class="tagcuabv">Tag: <?php echo $tagcuabv?></span>
<?php }?>
</h4>
<p><?php echo $row['tomtat']?></p>
</td>
<td valign=middle align=center width=100 class=action_button >
<p style="margin-bottom:10px">
    <img class="dangbai" idbv="<?php echo $row['idbv']?>" src="<?php echo BASE_DIR?>img/dangbai.png" title="Nhắp vào để đăng bài" />
	<?php if ($row['anhien']==0) {?>
	<img class="anhien" idbv="<?php echo $row['idbv']?>" src="<?php echo BASE_DIR?>img/AnHien_0.jpg" title="Bài này đang ấn. Nhắp vào để hiện" />
	<?php } else {?>
	<img class="anhien" idbv="<?php echo $row['idbv']?>" src="<?php echo BASE_DIR?>img/AnHien_1.jpg" title="Bài này đang hiện. Nhắp vào để ẩn" />
	<?php }?>
	<?php if ($row['noibat']==0) {?>
	<img class="noibat" idbv="<?php echo $row['idbv']?>" src="<?php echo BASE_DIR?>img/NoiBat_0.jpg" title="Bài này bình thường. Nhắp vào để cho nổi bật" />
	<?php } else {?>
	<img class="noibat" idbv="<?php echo $row['idbv']?>" src="<?php echo BASE_DIR?>img/NoiBat_1.jpg" title="Bài này đang nổi bật. Nhắp vào để tắt " />
	<?php }?>
</p>
<p>
<a href="<?php echo BASE_URL?>quantri/baiviet_sua/<?php echo $row['idbv']?>" >
 <img class="edit" src="<?php echo BASE_URL?>img/edit.png" title="Chỉnh sửa bài viết">
</a>
 <a class="xoabv" href="<?php echo BASE_URL?>quantri/baiviet_xoa/<?php echo $row['idbv']?>" onclick="return confirm('Xóa hả');" title="Xóa bài viết">
 <img src="<?php echo BASE_URL?>img/delete.png" >
 </a> 
 </p>
 <?php if ($hienthutu) {?>
<p style="margin-bottom:5px"><input type="number" class="thutubv" onfocus="this.select()" name="thutu[]" id="thutu" value=<?php echo $row['thutu']?> title="Thứ tự">
<input type=hidden  name="idbv[]" value="<?php echo $row['idbv']?>">
</p>
<?php } //if?>
</td>
</tr>
<?php }//foreach?>
</form>
<tr><th colspan=3>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/baiviet_list/$idloai/$idtacgia/$noibat/$anhien/$sapxepbaiviettheo", $totalrows, 5,$per_page, $currentpage);?>
</div>

</th></tr>
</table>
</td>

</tr>
</table>