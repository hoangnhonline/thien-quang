<?php   
  $currentpage= $this->params[0]; settype($currentpage,"int");  if ($currentpage<=0) $currentpage=1;
  $per_page=PER_PAGE; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  $kq = $this->qt->chudevideo_list($per_page,$start, $totalrows);	
?>
<table id=list width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class=captionrow><td colspan=7>
<span>Quản trị chủ đề video</span>
 <a href="<?php echo BASE_URL?>quantri/chudevideo_them" title="Thêm chủ đề video">Thêm chủ đề</a>
</td></tr>
<tr class="captionrow2">
<td>id</td><td>Tên chủ đề</td>
<td>Alias</td>
<td>Thứ tự</td> 
<td>Ẩn hiện</td> 
<td>Số video</td>
<td>Action</td>
</tr>
<?php foreach($kq as $row){ ?>
<tr>
<td><?php echo $row['idchudevideo']?></td><td><?php echo $row['tenchudevideo']?>
&nbsp;(<?php echo $this->qt->demvideotrongchude($row['idchudevideo'])?> video)
</td>
<td><?php echo $row['alias']?></td>
<td align="center" ><?php echo $row['thutu']?></td> 
<td align="center" ><?php echo ($row['anhien']==0)?"Ẩn":"Hiện"?></td>
<td align=center><?php echo $this->qt->demsovideotrongchude($row['idchudevideo']);?> 
<a href="<?php echo BASE_DIR?>quantri/video_list/<?php echo $row['idchudevideo']?>">xem</a>
</td>
<td align="center"  class="action_button">
<a href="<?php echo BASE_URL?>quantri/chudevideo_sua/<?php echo $row['idchudevideo']?>" >
<img src="<?php echo BASE_URL?>img/edit.png" width=25 height=25>
</a> &nbsp; 
<a href="<?php echo BASE_URL?>quantri/chudevideo_xoa/<?php echo $row['idchudevideo']?>" onclick="return confirm('Xóa hả');">
<img src="<?php echo BASE_URL?>img/delete.png">
</a>
</td>
</tr>
<?php }?>
<tr><th colspan=7>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/chudevideo_list", $totalrows, 3,$per_page, $currentpage);?>
</div>

</th></tr>
</table>