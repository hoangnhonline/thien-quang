<form action="" method="post" id="tacgia_sua" class="form" >
<h4>SỬA TÁC GIẢ</h4>
<p><span>Tiêu đề</span>
<input class=txt type=text name=tieude id=tieude value="<?php echo $row['tieude']?>"></p>
<p><span>Tên tác giả</span>
<input  class=txt type=text name=tentacgia id=tentacgia value="<?php echo $row['tentacgia']?>"></p>
<p><span>Mô tả</span><textarea class=txt name=mota id=mota><?php echo $row['mota']?></textarea></p>
<p><span>Ẩn hiện</span>
<input type=radio name=anhien id=anhien value=0 <?php echo ($row['anhien']==0)?"checked":""?> >Ẩn 
<input type=radio name=anhien id=anhien value=1  <?php echo ($row['anhien']==1)?"checked":""?>>Hiện</p>
<p><span>Thứ tự</span><input class=txt type=text name=thutu id=thutu value="<?php echo $row['thutu']?>"></p>
<p align=center><input value=" SỬA " type=submit name=btn id=btn ></p>
</form>