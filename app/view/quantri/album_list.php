<?php   
  $currentpage= $this->params[0]; settype($currentpage,"int");  if ($currentpage<=0) $currentpage=1;
  $per_page=PER_PAGE; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  $kq = $this->qt->album_list($per_page,$start, $totalrows);	
?>
<table id=list width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class=captionrow><td colspan=7>
<span>Quản trị Album</span>
<a href="<?php echo BASE_URL?>quantri/album_them" title="Thêm Album">Thêm Album</a>
</td></tr>
<tr class="captionrow2">
<td>id</td><td>Tên</td><td>Thứ tự</td><td>Ẩn hiện</td>
<td>Ngày tạo</td><td>Hình</td><td width=70 valign=middle>Action</td>
</tr>
<?php foreach($kq as $row){ ?>
<tr>
<td valign=middle align=center><?php echo $row['idalbum']?></td><td><?php echo $row['tenalbum']?></td>
<td valign=middle align=center><?php echo $row['thutu']?></td><td><?php echo ($row['anhien']==0)?"Ẩn":"Hiện"?></td>
<td  valign=middle align=center><?php echo date('d/m/Y',strtotime($row['ngay']))?></td>
<td><img src="<?php echo $row['hinhdaidien']?>" width="60" height="40"</td>
<td valign=middle align=center class="action_button">
<a href="<?php echo BASE_URL?>quantri/album_sua/<?php echo $row['idalbum']?>" >
<img src="<?php echo BASE_URL?>img/edit.png" width="25" height="25" title="Chỉnh sửa album">
</a>
<a href="<?php echo BASE_URL?>quantri/album_xoa/<?php echo $row['idalbum']?>" onclick="return confirm('Xóa hả');">
<img src="<?php echo BASE_URL?>img/delete.png"  title="Xóa album">
</a>
</td>
</tr>
<?php }?>
<tr><th colspan=7>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/album_list", $totalrows, 5,$per_page, $currentpage);?>
</div>

</th></tr>
</table>