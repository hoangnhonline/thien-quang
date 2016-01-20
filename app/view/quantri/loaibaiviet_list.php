<?php   
  $currentpage= $this->params[0]; settype($currentpage,"int");  if ($currentpage<=0) $currentpage=1;
  $orderby=0; //mặc định idcha desc, idloai desc
  if (isset($_GET['sapxep'])==true){
	  $sx = $_GET['sapxep'];
	  if ($sx=="idloai") {//sap theo idloai
		if ($_COOKIE['orderby_loaibv']==1) $orderby=2; else $orderby=1; //1 or 2 sắp theo idloai
	  }
	  elseif ($sx=="tenloai") {//sap theo tenloai
		if ($_COOKIE['orderby_loaibv']==3) $orderby=4; else $orderby=3; // 3 or 4  sắp theo tênloai
	  }	  
	  elseif ($sx=="thutu") {//sap theo thutu
		if ($_COOKIE['orderby_loaibv']==5) $orderby=6; else $orderby=5; //5 or 6 sắp theo thutu
	  }
  }
  setcookie('orderby_loaibv',$orderby,null,  BASE_DIR );    
  $per_page=PER_PAGE*2; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  
  $kq = $this->qt->loaibaiviet_list($per_page,$start, $totalrows,$orderby);	
?>
<table width=100%>
<tr>
<td  class="colleft" valign=top>
<div id="loaibaivietTree">
<?php 
$baseUrlForTree=BASE_URL."quantri/loaibaiviet_sua/";
include "loaibaiviet_tree.php"?>
</div>
</td>
<td valign=top class=colright>
<table id=listloaibaiviet width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class=captionrow><td colspan=9>
<span>Quản trị loại bài viết</span>
 <a href="<?php echo BASE_URL?>quantri/loaibaiviet_them" title="Thêm loại bài viết">Thêm loại</a>
</td></tr>
<tr  class="captionrow2">
<td width=50>
<a href="<?php echo BASE_URL?>quantri/loaibaiviet_list/?sapxep=idloai" title="Sắp xếp theo idloai">
id
</a>
</td>
<td>
<a href="<?php echo BASE_URL?>quantri/loaibaiviet_list/?sapxep=tenloai" title="Sắp xếp theo tênloai">
Tên loại
</a>
</td>
<td>
<a href="<?php echo BASE_URL?>quantri/loaibaiviet_list/?sapxep=thutu" title="Sắp xếp theo thutu">
Thứ tự
</a>
</td>
<td>Dùng riêng</td>
<td>Alias</td>
<td>Ẩn hiện</td>
<td>
<a href="<?php echo BASE_URL?>quantri/loaibaiviet_list/" title="Sắp xếp theo mặc định: idcha giảm dần và idloai giảm dần">
Loại cha
</a>
</td> 
<td>Mô tả</td>
<td>Action</td>
</tr>
<?php foreach($kq as $row){ ?>
<tr>
<td><?php echo $row['idloai']?></td>
<td>
<?php echo $row['tenloai']?>
&nbsp;(<a href="<?php echo BASE_DIR?>quantri/baiviet_list/<?php echo $row['idloai']?>"><?php echo $this->qt->demsobaiviettrongloai($row['idloai']);?> bv</a>)
</td>
<td  align=center><?php echo $row['thutu']?></td>
<td align=center>
<?php if ($row['aiduocxem']==0) echo "Mọi người";
elseif($row['aiduocxem']==1)echo "Dùng riêng"; 
else echo "Admin"?>
</td>
<td  align=center><?php echo $row['alias']?></td>
<td  align=center><?php echo ($row['anhien']==1)? "Hiện":"Ẩn"?></td>
<td  align=center><?php echo $this->qt->laytenloaibaiviet($row['idcha']);?></td>
<td align=left><?php echo $row['mota']?>&nbsp;</td>
<td  valign=middle align=center class="action_button" width="80px">
<a href="<?php echo BASE_URL?>quantri/loaibaiviet_sua/<?php echo $row['idloai']?>" >
<img src="<?php echo BASE_URL?>img/edit.png" width=25 height=25>
</a>
<a href="<?php echo BASE_URL?>quantri/loaibaiviet_xoa/<?php echo $row['idloai']?>" onclick="return confirm('Xóa hả');">
<img src="<?php echo BASE_URL?>img/delete.png" width=25 height=25>
</a>
</td>
</tr>
<?php }?>
<tr><th colspan=9>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/loaibaiviet_list", $totalrows, 3,$per_page, $currentpage);?>
</div>

</th></tr>
</table>
</td>
</tr>
</table>
