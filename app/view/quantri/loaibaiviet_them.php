<form action="" method="post" id="loaibaiviet_them"  class="form">
<h4>THÊM LOẠI BÀI VIẾT</h4>
<p><span>Tên loại</span><input class=txt type=text name=tenloai id=tenloai></p>
<p><span>Alias</span><input class=txt type=text name="alias" id="alias"></p>
<p><span>Loại cha</span>
<?php $phanloai = $this-> qt->listloai_dequy(0); ?>
<select class=txt type=text name=loaicha id=loaicha>
<option value="0"> Không có </option>
  <?php foreach ($phanloai as $loai) {?>
  	<option value="<?php echo $loai['id']?>"> <?php echo $loai['ten'];?> </option>
  <?php }?>

</select>
</p>
<p><span>Ẩn hiện</span><input type=radio name=anhien id=anhien value=0>Ẩn 
<input type=radio name=anhien id=anhien value=1 checked>Hiện</p>
<p><span>Thứ tự</span><input class=txt type=text name=thutu id=thutu></p>
<p>
<span>Ai được xem</span>
<select name=aiduocxem id=aiduocxem class="txt">
<option value="0">Tất cả mọi người</option>
<option value="1" title="Là loại bài viết lưu các bài viết đặc biệt,cho mục đích riêng như giới thiệu, liên hệ...">Dùng riêng</option>
<option value="2" title="Cho admin" title="Loại này chỉ dùng cho admin">Cho admin</option>
</select>
</p>
<p>
<span>Sắp xếp bv theo</span>
<select name=sapxepbaiviettheo id=sapxepbaiviettheo class="txt">
<option value="0">Ngày và idbv giảm dần</option>
<option value="1">Ngày và idbv tăng dần</option>
<option value="2">Thứ tự tăng dần</option>
<option value="3">Thứ tự giảm dần</option>
</select>
</p>
<p>
<span>Mô tả</span>
<textarea id=mota name=mota class=txt rows=7></textarea>
</p>
<p align=center><input value=" Thêm " type=submit name=btn id=btn ></p>

</form>