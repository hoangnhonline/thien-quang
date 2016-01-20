<?php   
  $idgroup= $this->params[0];   settype($idgroup,"int"); if ($idgroup<=0) $idgroup=-1; 
  $tukhoatimuser = trim(strip_tags($this->params[1]));  if ($tukhoatimuser=="") $tukhoatimuser="all";
  $tukhoatimuser = urldecode($tukhoatimuser); //trường hợp từ khóa có dấu, sẽ bị mã hóa urlencode, cần decode lại
  $currentpage= $this->params[2]; settype($currentpage,"int");  if ($currentpage<=0) $currentpage=1;
  $per_page=2; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  $kq = $this->qt->user_list($idgroup, $tukhoatimuser, $per_page,$start, $totalrows);	
?>
<script>
function set_action(obj){
var url="<?php echo BASE_DIR?>quantri/user_list/" + $("#idgroup").val()+ "/" + $("#tukhoatimuser").val() +"/";
obj.action=url;
}
</script>
<table id=list width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class=captionrow><td colspan=9>
<form id=formLocUser method=post onsubmit="set_action(this)">
<span>Quản trị users</span>
<?php $listgroupuser= $this->qt->laygroupuser(); ?>
<select name="idgroup" id="idgroup"  class="sel sel3" title="{Search_GroupUser}" >
		<option value="0">Chọn nhóm user</option>
		<?php foreach($listgroupuser as $row_groupuser){?>
		<option value="<?php echo $row_groupuser['idgroup'];?>"><?php echo $row_groupuser['tengroup'];?></option>
		<?php }?>
</select>
<input name="tukhoatimuser" id="tukhoatimuser" class="txt" value="<?php echo $tukhoatimuser?>" onfocus="this.value=''"  title="Từ khóa tìm user">
<input type=submit value=" Tìm " id="btnLocUser" >
</form>
<a href="<?php echo BASE_DIR?>quantri/user_them" title="Thêm user">Thêm user</a>
</td></tr>
<tr  class="captionrow2">
<td>id</td><td>Họ Tên</td><td>Username</td><td>Email</td>
<td>Điện thoại</td><td>Địa chỉ</td><td>Group</td><td>Actice</td>
<td width=80 valign=middle align=center>Action</td>
</tr>
<?php foreach($kq as $row){ ?>
<tr>
<td valign=middle align=center><?php echo $row['iduser']?></td>
<td><?php echo $row['hoten']?></td><td><?php echo $row['username']?>&nbsp;</td>
<td valign=middle align=center><?php echo $row['email']?>&nbsp;</td>
<td  valign=middle align=center><?php echo $row['dienthoai']?>&nbsp;</td>
<td><?php echo $row['diachi']?>&nbsp;</td>
<td><?php echo $this->qt->laytengroupuser($row['idgroup']);?></td>
<td><?php echo ($row['active']==0)?"Chưa":"Rồi"?></td>
<td valign=middle align=center class=action>
<a href="<?php echo BASE_DIR?>quantri/user_sua/<?php echo $row['iduser']?>" >Sửa</a>
<a href="<?php echo BASE_DIR?>quantri/user_xoa/<?php echo $row['iduser']?>" onclick="return confirm('Xóa hả');">Xóa</a>
</td>
</tr>
<?php }?>
<tr><th colspan=9>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/user_list/$idgroup/$tukhoatimuser", $totalrows, 10,$per_page, $currentpage);?>
</div>

</th></tr>
</table>