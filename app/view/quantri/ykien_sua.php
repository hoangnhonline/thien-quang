<form action="" method="post" id="formsuaykien" class=form >
	<h4>SỬA Ý KIẾN</h4>
	<p><span>Họ tên</span><input class=txt type=text name=hoten id=hoten value="<?php echo $row['hoten']?>"></p>
	<p><span>Email</span><input type="text"class=txt name=email id=email value="<?php echo $row['email']?>"/></p>
	<p><span>Ẩn hiện</span>
    <input type=radio name=anhien id=anhien value=0 <?php echo ($row['anhien']==0)?"checked":""?>>Ẩn 
	<input type=radio name=anhien id=anhien value=1 <?php echo ($row['anhien']==1)?"checked":""?>>Hiện</p>
    
    <textarea class=txt name=noidung id=noidung><?php echo str_replace("\\r\\n","\r\n",$row['noidung'])?></textarea>    
	<p align=center><input value=" LƯU " type=submit name=btn id=btn ></p>
</form>