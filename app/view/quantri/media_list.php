<?php 
  $idchude= $this->params[0];   settype($idchude,"int"); if ($idchude<=0) $idchude=-1; 
  $currentpage= $this->params[1]; settype($currentpage,"int");    
  
  if ($idchude==-1 AND $currentpage==-1) $_SESSION['tukhoatimmedia']=""; //trường hợp nhắp link "Xem hết"
  if (isset($_POST['tukhoatimmedia'])) {
    $_SESSION['tukhoatimmedia']=$_POST['tukhoatimmedia']; $currentpage=0; //nếu có từ khóa thì chuyển về trang đầu
  }
  if ($currentpage<=0) $currentpage=1;
  
  $per_page=PER_PAGE*3; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;  
  $start = ($currentpage-1)*$per_page;
  $kq = $this->qt->media_list($idchude, $per_page,$start, $totalrows);	
?>
<table id=listchude width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class=captionrow><td colspan=7>
<span>Quản trị media</span>
<?php $chudemedia=$this->qt->chudemedia();?>
<div id=search >
<form action="" method="post" style="margin: 0;">
<select name=chudemedia id=chudemedia class="loai" onchange='document.location="<?php echo BASE_DIR?>quantri/media_list/" + this.value;' title='Chọn để chỉ xem media trong chủ đề bạn muốn' />
<option value="-1">Tất cả loại</option>
<?php foreach($chudemedia as $row) {?>
<option value="<?php echo $row['idchudemedia']?>" <?php if ($row['idchudemedia']==$idchude) echo "selected";?> >
<?php echo $row['tenchudemedia']?> (<?php echo $this->qt->demsomediatrongchude($row['idchudemedia'])?>)
</option>
<?php } ?>
</select>
<input class=tukhoa type="text" name="tukhoatimmedia" id="tukhoatimmedia" value="<?php echo $_SESSION['tukhoatimmedia']?>" size="14" title="Nhập từ khóa tìm kiếm rồi Enter. Có thể tìm theo tiêu đề hoặc idmedia">
Có <?php echo $totalrows?> media.
<a href="<?php echo BASE_URL?>quantri/media_list/-1/-1">Xem hết</a>
</form>
</div>

<a href="<?php echo BASE_URL?>quantri/media_them" title="Thêm media">Thêm Media</a>
</td></tr>
<tr  class="captionrow2">
<td>id</th><td>Tên</td><td>Tác giả</td><td>Chủ đề</td><td>Xem</td><td>Ẩn hiện</td>
<td width=70 valign=middle>Action</td>
</tr>
<?php foreach($kq as $row){ ?>
<tr>
<td valign=middle align=center><?php echo $row['idmedia']?></td>
<td title="<?php echo $row['url']?>"><?php echo $row['tenmedia']?></td>
<td valign=middle align=center>
<?php
$hotentacgia= $this->qt->laytentacgia($row['idtacgia']); 
if ($hotentacgia!="") echo $hotentacgia; else echo "Không có";
?>
 </td>
<td  valign=middle align=center>
<a href="<?php echo BASE_URL?>quantri/media_list/<?php echo $row['idchudemedia']?>/">
<?php echo $row['tenchudemedia']?>
</a>
</td>
<td valign=middle align=center><?php echo $row['solanxem']?></td><td><?php echo ($row['anhien']==0)?"Ẩn":"Hiện"?></td>
<td  valign=middle align=center class="action_button">
<a href="<?php echo BASE_URL?>quantri/media_sua/<?php echo $row['idmedia']?>" >
<img src="<?php echo BASE_URL?>img/edit.png" width=25 height=25>
</a>
<a href="<?php echo BASE_URL?>quantri/media_xoa/<?php echo $row['idmedia']?>" onclick="return confirm('Xóa hả');">
<img src="<?php echo BASE_URL?>img/delete.png" width=25 height=25>
</a>
</td>
</tr>
<?php }?>
<tr><th colspan=7>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/media_list/$idchude", $totalrows, 5,$per_page, $currentpage);?>
</div>

</th></tr>
</table>