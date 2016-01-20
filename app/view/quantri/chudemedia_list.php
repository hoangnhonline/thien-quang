<?php   
  $currentpage= $this->params[0]; settype($currentpage,"int");  if ($currentpage<=0) $currentpage=1;
  $per_page=PER_PAGE; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  $kq = $this->qt->chudemedia_list($per_page,$start, $totalrows);	
?>
<table id=list width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class=captionrow><td colspan=7>
<span>Quản trị chủ đề media</span>
 <a href="<?php echo BASE_URL?>quantri/chudemedia_them" title="Thêm chủ đề media">Thêm Chủ Đề</a>
</td></tr>
<tr  class="captionrow2">
<td>id</td><td>Tên chủ đề</td><td>Thứ tự</td> <td>Ẩn hiện</td> <td>Số media</td><td>Action</td>
</tr>
<?php foreach($kq as $row){ ?>
<tr>
<td><?php echo $row['idchudemedia']?></td><td><?php echo $row['tenchudemedia']?></td>
<td><?php echo $row['thutu']?></td> <td><?php echo ($row['anhien']==0)?"Ẩn":"Hiện"?></td>
<td align=center><?php echo $this->qt->demsomediatrongchude($row['idchudemedia']);?> 
<a href="<?php echo BASE_DIR?>quantri/media_list/<?php echo $row['idchudemedia']?>">xem</a>
</td>
<td  valign=middle align=center class="action_button">
<a href="<?php echo BASE_URL?>quantri/chudemedia_sua/<?php echo $row['idchudemedia']?>" >
<img src="<?php echo BASE_URL?>img/edit.png" width=25 height=25>
</a>
<a href="<?php echo BASE_URL?>quantri/chudemedia_xoa/<?php echo $row['idchudemedia']?>" onclick="return confirm('Xóa hả');">
<img src="<?php echo BASE_URL?>img/delete.png" width=25 height=25>
</a>
</td>
</tr>
<?php }?>
<tr><th colspan=6>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/chudemedia_list", $totalrows, 5,$per_page, $currentpage);?>
</div>

</th></tr>
</table>