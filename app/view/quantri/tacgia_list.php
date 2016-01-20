<?php   
  $currentpage= $this->params[0]; settype($currentpage,"int");  
  if (isset($_POST['tukhoatk'])) {
    $_SESSION['tukhoatk']=$_POST['tukhoatk']; 
    $currentpage=0; //nếu có từ khóa thì chuyển về trang đầu
  }
  
  if ($currentpage<=0) $currentpage=1;
  $per_page=10; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  $kq = $this->qt->tacgia_list($per_page,$start, $totalrows);	
?>
<script>
$(document).ready(function(){
$("#hinhsave").click(function(){
	var dulieu = $("#formlist").serialize();
	$.ajax({
		url:"<?php echo BASE_DIR?>quantri/capnhatthututacgia/", cache:false, data:dulieu, type:'post',
		success:function(d){ alert(d);}
	})	
})

})
</script>
<form id="formlist" method=post>
<table id=listtacgia width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class="captionrow"><td colspan=7>
<span>Quản trị tác giả</span>
<input type=text name=tukhoatk id=tukhoatk  value="<?php echo $_SESSION['tukhoatk']?>"/>
<input type=submit id=btnloc value="TÌM"/>
<a href="<?php echo BASE_URL?>quantri/tacgia_them" title="Thêm tác giả">Thêm tác giả</a>
</td></tr>
<tr  class="captionrow2">
<td>id</td><td>Tiêu đề</td><td>Họ tên</td><td>Bài viết</td><td>Ẩn hiện</td>
<td>Thứ tự <img id=hinhsave src="<?php echo BASE_DIR?>img/save.png" title="Cập nhật thứ tự"/></td> 
<td>Action</td>
</tr>
<?php foreach($kq as $row){ ?>
<tr>
<td><?php echo $row['idtacgia']?></td><td><?php echo $row['tieude']?>&nbsp;</td>
<td><?php echo $row['tentacgia']?></td>
<td>
<a href="<?php echo BASE_DIR?>quantri/baiviet_list/-1/<?php echo $row['idtacgia']?>/">Xem bài viết</a> 
(<?php echo $this->qt->demsobaivietcuatacgia($row['idtacgia'])?>)</td>
<td align=center><?php echo ($row['anhien']==1)? "Đang hiện":"Đang ẩn";?></td>
<td align=center><input class=thutu type=text name="thutu[]" id=thutu value="<?php echo $row['thutu']?>"/>
<input type="hidden" name="idtacgia[]" value="<?php echo $row['idtacgia']?>"/>
</td>
<td  valign=middle align=center class="action_button">
<a href="<?php echo BASE_URL?>quantri/tacgia_sua/<?php echo $row['idtacgia']?>" >
<img src="<?php echo BASE_URL?>img/edit.png" width=25 height=25>
</a>
<a href="<?php echo BASE_URL?>quantri/tacgia_xoa/<?php echo $row['idtacgia']?>" onclick="return confirm('Xóa hả');">
<img src="<?php echo BASE_URL?>img/delete.png" width=25 height=25>
</a>
</td>
</tr>
<?php }?>
<tr><th colspan=7>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/tacgia_list", $totalrows, 5,$per_page, $currentpage);?>
</div>

</th></tr>
</table>
</form>