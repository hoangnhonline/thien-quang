<form action="" method="post" id="chudevideo_them" class="form">
<h4>SỬA CHỦ ĐỀ VIDEO</h4>
<p><span>Tên chủ đề</span><input class=txt type=text name=tenchudevideo id=tenchudevideo value="<?php echo $row['tenchudevideo']?>"></p>
<p><span>Mô tả</span><textarea class=txt name=mota id=mota><?php echo $row['mota']?></textarea></p>
<p><span>Ẩn hiện</span>
<input type=radio name=anhien id=anhien value=0 <?php echo ($row['anhien']==0)?"checked":""?>>Ẩn 
<input type=radio name=anhien id=anhien value=1 <?php echo ($row['anhien']==1)?"checked":""?>>Hiện</p>
<p><span>Thứ tự</span><input class=txt type=text name=thutu id=thutu value="<?php echo $row['thutu']?>"></p>
<p align=center><input value=" LƯU " type=submit name=btn id=btn ></p>

</form>