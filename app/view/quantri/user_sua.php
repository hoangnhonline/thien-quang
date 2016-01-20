<?php $row = $this->qt->chitietuser($id);?>
<form action="" method="post" id="userplaylist_them" class="form" >
<h4>SỬA USER</h4>
<div class=loi><?php echo $_SESSION['message_title']. $_SESSION['message_content']; 
unset($_SESSION['message_title']); unset($_SESSION['message_content']); 
?>
</div>
<p><span>Username</span><?php echo $row['username']?></p>
<p><span>Mật khẩu</span><input class=txt type=password name=password id="password"/>
<em class=error><?php echo $loi['password'];?></em>
</p>
<p><span>Gõ lại mật khẩu</span><input class=txt type=password name=repassword id="repassword"/>
</p>

<p><span>Họ tên</span><input class=txt type=text name=hoten id=hoten value="<?php echo (isset($_POST['hoten'])==true)? $_POST['hoten']:$row['hoten'];?>"/>
<em class=error><?php echo $loi['hoten'];?></em>
</p>
<p><span>Email</span><input class=txt type=text name=email id=email value="<?php echo (isset($_POST['email'])==true)? $_POST['email']:$row['email'];?>">
<em class=error><?php echo $loi['email'];?></em>
</p>
<p><span>Địa chỉ</span><input class=txt type=text name=diachi id=diachi value="<?php echo (isset($_POST['diachi'])==true)? $_POST['diachi']:$row['diachi'];?>">
<em class=error><?php echo $loi['diachi'];?></em>
</p>
<p><span>Điện thoại</span><input class=txt type=text name=dienthoai id=dienthoai value="<?php echo (isset($_POST['dienthoai'])==true)? $_POST['dienthoai']:$row['dienthoai'];?>">
<em class=error><?php echo $loi['dienthoai'];?></em>
</p>
<p><span>Ngày sinh</span><input class=txt type=text name=ngaysinh id=ngaysinh value="<?php echo (isset($_POST['ngaysinh'])==true)? $_POST['ngaysinh']:date('d/m/Y',strtotime($row['ngaysinh']));?>">
<em class=error><?php echo $loi['ngaysinh'];?></em>
</p>

<p><span>Giới tính</span><input type=radio name=gioitinh id=gioitinh value=0 <?php echo ($row['gioitinh']==0)?"checked":""?>>Nữ 
<input type=radio name=gioitinh id=gioitinh value=1 <?php echo ($row['gioitinh']==1)?"checked":""?>>Nam</p>
<p><span>Kích hoạt</span><input type=radio name=active id=active value=0 <?php echo ($row['active']==0)?"checked":""?>>Chưa kích hoạt 
<input type=radio name=active id=active value=1 <?php echo ($row['active']==1)?"checked":""?>>Đã kích hoạt</p>
<?php $groupuser=$this->qt->laygroupuser();?>
<p><span>Group</span>
<select name=idgroup id=idgroup class=txt>
<?php foreach($groupuser as $motgroup) {?>
<option value="<?php echo $motgroup['idgroup']?>"  title="<?php echo $motgroup['mota']?>" <?php echo ($row['idgroup']==$motgroup['idgroup'])?"selected":""?>>
<?php echo $motgroup['tengroup']?>
</option>
<?php } ?>
</select></p>
<p align=center><input value=" Lưu " type=submit name=btn id=btn ></p>

</form>