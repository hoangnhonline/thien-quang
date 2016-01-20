<form action="" method="post" id="userplaylist_them" class="form" >
<h4>THÊM USER</h4>
<div class=loi><?php echo $_SESSION['message_title']. $_SESSION['message_content']; 
unset($_SESSION['message_title']); unset($_SESSION['message_content']); 
?>
</div>
<p><span>Username</span><input class=txt type=text name=username id=username value="<?php echo $_POST['username']?>">
<em class=error><?php echo $loi['username'];?></em>
</p>
<p><span>Mật khẩu</span><input class=txt type=password name=password id=password value="<?php echo $_POST['password']?>">
<em class=error><?php echo $loi['password'];?></em>
</p>
<p><span>Gõ lại mật khẩu</span><input class=txt type=password name=repassword id=repassword value="<?php echo $_POST['repassword']?>">
</p>

<p><span>Họ tên</span><input class=txt type=text name=hoten id=hoten value="<?php echo $_POST['hoten']?>">
<em class=error><?php echo $loi['hoten'];?></em>
</p>
<p><span>Email</span><input class=txt type=text name=email id=email value="<?php echo $_POST['email']?>">
<em class=error><?php echo $loi['email'];?></em>
</p>
<p><span>Địa chỉ</span><input class=txt type=text name=diachi id=diachi value="<?php echo $_POST['diachi']?>">
<em class=error><?php echo $loi['diachi'];?></em>
</p>
<p><span>Điện thoại</span><input class=txt type=text name=dienthoai id=dienthoai value="<?php echo $_POST['dienthoai']?>">
<em class=error><?php echo $loi['dienthoai'];?></em>
</p>
<p><span>Ngày sinh</span><input class=txt type=text name=ngaysinh id=ngaysinh value="<?php echo $_POST['ngaysinh']?>">
<em class=error><?php echo $loi['ngaysinh'];?></em>
</p>

<p><span>Giới tính</span><input type=radio name=gioitinh id=gioitinh value=0 >Nữ 
<input type=radio name=gioitinh id=gioitinh value=1 checked>Nam</p>
<p><span>Kích hoạt</span><input type=radio name=active id=active value=0>Không 
<input type=radio name=active id=active value=1 checked>Có</p>
<?php $groupuser=$this->qt->laygroupuser();?>
<p><span>Group</span>
<select name=idgroup id=idgroup class=txt>
<?php foreach($groupuser as $motgroup) {?>
<option value="<?php echo $motgroup['idgroup']?>" title="<?php echo $motgroup['mota']?>"><?php echo $motgroup['tengroup']?></option>
<?php } ?>
</select></p>
<p align=center><input value=" Thêm " type=submit name=btn id=btn ></p>

</form>