<?php 
  $idchude= $this->params[0];   settype($idchude,"int"); if ($idchude<=0) $idchude=-1; 
  $currentpage= $this->params[1]; settype($currentpage,"int");  if ($currentpage<=0) $currentpage=1;
  $per_page=20; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  $kq = $this->qt->mediaplaylist_list($idchude, $per_page,$start, $totalrows);	
?>
<table id=listchude width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class=captionrow><td colspan=7>
<span>Quản trị media playlist</span>
<a href="<?php echo BASE_URL?>quantri/mediaplaylist_them" title="Thêm playlist">Thêm PL</a>
</td></tr>
<tr class="captionrow2">
<td>id</td><td>Tên</td><td>Tác giả</td><td>Chủ đề</td><td>Xem</td><td>Ẩn hiện</td>
<td width=70 valign=middle>Action</td>
</tr>
<?php foreach($kq as $row){ ?>
<tr>
<td valign=middle align=center><?php echo $row['idmediaplaylist']?></td>
<td><?php echo $row['tenmediaplaylist']?></td>
<td valign=middle align=center>
<?php
$hotentacgia= $this->qt->laytentacgia($row['idtacgia']); 
if ($hotentacgia!="") echo $hotentacgia; else echo "Không có";
?>
 </td>
<td  valign=middle align=center><?php $cd= $this->qt->chitietchudemedia($row['idchudemedia']); echo $cd['tenchudemedia']?></td>
<td valign=middle align=center><?php echo $row['solanxem']?></td><td><?php echo ($row['anhien']==0)?"Ẩn":"Hiện"?></td>
<td valign=middle align=center class="action_button">
<a href="<?php echo BASE_URL?>quantri/mediaplaylist_sua/<?php echo $row['idmediaplaylist']?>" >
<img src="<?php echo BASE_URL?>img/edit.png" width=25 height=25>
</a>
<a href="<?php echo BASE_URL?>quantri/mediaplaylist_xoa/<?php echo $row['idmediaplaylist']?>" onclick="return confirm('Xóa hả');">
<img src="<?php echo BASE_URL?>img/delete.png" width=25 height=25>
</a>
</td>
</tr>
<?php }?>
<tr><th colspan=7>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/mediaplaylist_list/$idchude", $totalrows, 5,$per_page, $currentpage);?>
</div>

</th></tr>
</table>