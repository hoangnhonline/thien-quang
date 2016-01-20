<?php 
  $orderby=$_COOKIE['orderby']; settype($orderby, "int");
  $idchude= $this->params[0];   settype($idchude,"int"); if ($idchude<=0) $idchude=-1; 
  
  $currentpage= $this->params[1]; settype($currentpage,"int");  
  if ($idchude==-1 AND $currentpage==-1) $_SESSION['tukhoatimvideo']=""; //trường hợp nhắp link "Xem hết"
  if (isset($_POST['tukhoatimvideo'])) {
    $_SESSION['tukhoatimvideo']=$_POST['tukhoatimvideo']; 
    $currentpage=0; //nếu có từ khóa thì chuyển về trang đầu
  }
  if ($currentpage<=0) $currentpage=1;
  $per_page=PER_PAGE; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  
  $kq = $this->qt->video_list($idchude, $per_page,$start, $totalrows,$orderby);
?>
<script src="<?php echo BASE_DIR?>js/jquery.simplemodal-1.4.4.js" type="text/javascript"></script>
<style>
#simplemodal-container a.modalCloseImg {
	background:url(/img/x.png) no-repeat; /* adjust url as required */
	width:25px;
	height:29px;
	display:inline;
	z-index:3200;
	position:absolute;
	top:-15px;
	right:-18px;
	cursor:pointer;
}
.xemvideo {cursor:pointer}
</style>
<script>
$(document).ready(function(){
	$(".xemvideo").click(function(){
		var idyoutube=$(this).attr("idyoutube");
		var src = "https://www.youtube.com/embed/" + idyoutube + "?autoplay=1";	
		$.modal('<iframe src="' + src + '" height="500" width="750" style="border:0" allowfullscreen>', {
			containerCss:{backgroundColor:"#39c",	borderColor:"#fff", 
				height:500,width:750, padding:0	
			},
			overlayClose:true
		});
	});
	$("a.sapxep").click(function(){		
		var sapxep=$(this).attr('orderby');						
		$.cookie('orderby', sapxep, { path: '<?php echo BASE_DIR?>' });
		document.location="<?php echo BASE_URL?>quantri/video_list/";
		return false;
	});
	
	var sapxep= $.cookie('orderby');
	if (sapxep==1) $("[orderby=1]").attr("orderby",2); //sắp theo idvideo
	if (sapxep==3) $("[orderby=3]").attr("orderby",4); //sắp theo tenvideo
	if (sapxep==5) $("[orderby=3]").attr("orderby",6); //sắp theo thutu
	if (sapxep==7) $("[orderby=7]").attr("orderby",8); //sắp theo ngay giảng
});
</script>
<table id=listchude width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class=captionrow><td colspan=8>
<span>Quản trị video</span>
<?php $chudevideo=$this->qt->chudevideo();?>
<div id=search >
<form action="" method="post" style="margin: 0;">
<select name=chudevideo id=chudevideo class="loai" onchange='document.location="<?php echo BASE_DIR?>quantri/video_list/" + this.value;' title='Chọn để chỉ xem video trong chủ đề bạn muốn' />
<option value="-1">Tất cả loại</option>
<?php foreach($chudevideo as $row) {?>
<option value="<?php echo $row['idchudevideo']?>" <?php if ($row['idchudevideo']==$idchude) echo "selected";?>>
<?php echo $row['tenchudevideo']?> (<?php echo $this->qt->demvideotrongchude($row['idchudevideo'])?>)
</option>
<?php } ?>
</select>
<input class=tukhoa type="text" name="tukhoatimvideo" id="tukhoatimvideo" value="<?php echo $_SESSION['tukhoatimvideo']?>" size="14" title="Nhập từ khóa tìm kiếm rồi Enter. Có thể tìm theo tiêu đề hoặc idvideo hoặc idyoutube">
Có <?php echo $totalrows?> video.
<a href="<?php echo BASE_URL?>quantri/video_list/-1/-1">Xem hết</a>
</form>
</div>

<a href="<?php echo BASE_URL?>quantri/video_them" title="Thêm video">Thêm video</a>
</td></tr>
<tr  class="captionrow2">
<td width=40>
<a class="sapxep" orderby="1" href="#" title="Sắp xếp theo idvideo">id</a>
</td>
<td width=200>
<a class="sapxep" orderby="3" href="#" title="Sắp xếp theo tenvideo">Tên</a>
</td>
<td>Chủ đề</th> 
<td width=80>
<a class="sapxep" orderby="7" href="#" title="Sắp xếp theo ngày giảng">Ngày giảng</a>
</td>
<td>Hình ảnh</td>
<td>Mô tả</td>
<td>Tác giả</td>
<td width=70 valign=middle>Action</td>
</tr>
<?php foreach($kq as $row){ ?>
<tr>
<td align=center>
<?php echo $row['idvideo']?><br>
<p class=anhien><?php echo ($row['anhien']==0)?"Ẩn":"Hiện"?></p>
</td>
<td>
<?php echo $row['tenvideo']?>
<p class="idyoutube"><?php echo $row['idyoutube']?></p>
</td>
<td  valign=middle align=center>
<?php $chudev= $this->qt->chitietchudeVIDEO($row['idchudevideo']);
if ($chudev!=false) echo $chudev['tenchudevideo'];else echo "Chưa phân loại";?>
</td>
<td>
<?php echo date('d/m/Y',strtotime($row['ngaygiang']));?>
</td>
<td valign=middle align=center>

<img idyoutube="<?php echo $row['idyoutube']?>" class="xemvideo" src="http://img.youtube.com/vi/<?php echo $row['idyoutube']?>/default.jpg" width=100 height=70>

</td>
<td><?php echo $row['mota']?></td>
<td align=center>
<?php $hotentacgia= $this->qt->laytentacgia($row['idtacgia']); 
if ($hotentacgia!="") echo $hotentacgia; else echo "Không có";
?>
 </td>
<td valign=middle align=center class=action>
<a href="<?php echo BASE_URL?>quantri/video_xoa/<?php echo $row['idvideo']?>" onclick="return confirm('Xóa hả');">&nbsp;Xóa&nbsp;</a><br>
<a href="<?php echo BASE_URL?>quantri/video_sua/<?php echo $row['idvideo']?>" >&nbsp;Sửa&nbsp;</a>
</td>

</tr>
<?php }?>
<tr><th colspan=8>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/video_list/$idchude", $totalrows, 5,$per_page, $currentpage);?>
</div>

</th></tr>
</table>