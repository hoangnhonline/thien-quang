<div id="divchangepass">
	<form action="" method=post>
	<h4>ĐỔI MẬT KHẨU</h4>
	<div class=error>
	<?php if (count($loi)>0) foreach ($loi as $e ) echo "<br/>",$e;?>
	</div>
	<table width="100%" cellspacing="0" border=0>
	<tr><th>Tên đăng nhập</th><td><b><?php echo $_SESSION['login_user'];?></b></td></tr>
	<tr><th>Mật khẩu cũ</th><td><input type=password name=passold class="txt"/></td></tr>
	<tr><th>Mật khẩu mới</th><td><input type=password name=passnew1 class="txt"/></td></tr>
	<tr><th>Gõ lại mật khẩu mới</th><td><input type=password name=passnew2 class="txt"/></td></tr>
	<tr><th>&nbsp;</th><td><input type="submit" name="btnChangepass" id="btnChangepass" value="Đổi mật khẩu"/></td></tr>
	</tr>
	</table>
	</form>
</div>