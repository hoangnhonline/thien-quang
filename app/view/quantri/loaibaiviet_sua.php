<table width=100%>
<tr>
<td  class="colleft" valign=top>
<div id="loaibaivietTree">
<?php 
$baseUrlForTree=BASE_URL."quantri/loaibaiviet_sua/";
include "loaibaiviet_tree.php"?>
</div>
</td>
<td valign=top width=750>
<form action="" method="post" id="loaibaiviet_sua"  class="form">
<h4>SỬA LOẠI BÀI VIẾT</h4>
<p><span>Tên loại</span><input class=txt type=text name=tenloai id=tenloai value="<?php echo $row['tenloai']?>"></p>
<p><span>Alias</span><input class=txt type=text name="alias" id="alias" value="<?php echo $row['alias']?>"></p>
<p><span>Loại cha</span>
<?php $phanloai = $this-> qt->listloai_dequy(0); ?>
<select class=txt type=text name=loaicha id=loaicha>
<option value="0"> Không có </option>
  <?php foreach ($phanloai as $loai) {?>
  	<option value="<?php echo $loai['id']?>" <?php echo ($row['idcha']==$loai['id'])?"selected":""?> > 
	<?php echo $loai['ten'];?> 
	</option>
  <?php }?>

</select>
</p>
<p><span>Ẩn hiện</span><input type=radio name=anhien id=anhien value=0 <?php echo ($row['anhien']==0)?"checked":""?>>Ẩn 
<input type=radio name=anhien id=anhien value=1 <?php echo ($row['anhien']==1)?"checked":""?>>Hiện</p>
<p><span>Thứ tự</span><input class=txt type=text name=thutu id=thutu value="<?php echo $row['thutu']?>"></p>


<p>
<span>Ai được xem</span>
<select name=aiduocxem id=aiduocxem class="txt">
<option value="0" <?php echo ($row['aiduocxem']==0)?"selected":""?>>Tất cả mọi người</option>
<option value="1" <?php echo ($row['aiduocxem']==1)?"selected":""?> title="Là loại bài viết lưu các bài viết đặc biệt,cho mục đích riêng như giới thiệu, liên hệ...">Dùng riêng</option>
<option value="2" <?php echo ($row['aiduocxem']==2)?"selected":""?> title="Cho admin" title="Loại này chỉ dùng cho admin">Cho admin</option>
</select>
</p>
<p>
<span>Sắp xếp bv theo</span>
<select name=sapxepbaiviettheo id=sapxepbaiviettheo class="txt">
<option value="0" <?php echo ($row['sapxepbaiviettheo']==0)?"selected":""?>>Ngày và idbv giảm dần</option>
<option value="1" <?php echo ($row['sapxepbaiviettheo']==1)?"selected":""?>>Ngày và idbv tăng dần</option>
<option value="2" <?php echo ($row['sapxepbaiviettheo']==2)?"selected":""?>>Thứ tự tăng dần</option>
<option value="3" <?php echo ($row['sapxepbaiviettheo']==3)?"selected":""?>>Thứ tự giảm dần</option>
</select>
</p>
<p>
<span>Mô tả</span>
<textarea id=mota name=mota class=txt rows=7><?php echo $row['mota']?></textarea>
</p>
<p align=center><input value=" SỬA " type=submit name=btn id=btn ></p>

</form>
</td>
</tr>
</table>
