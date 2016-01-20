<?php
  $idbv= $this->params[0];   settype($idbv,"int"); if ($idbv<=0) $idbv=-1;  
  $anhien= $this->params[1];   settype($anhien,"int");
  
  $currentpage= $this->params[2]; settype($currentpage,"int");
  if ($idbv==-1 AND $currentpage==-1) $_SESSION['tukhoatimyk']=""; //trường hợp nhắp link "Xem hết"
  if (isset($_POST['tukhoatimyk'])) {
    $_SESSION['tukhoatimyk']=$_POST['tukhoatimyk']; 
    $currentpage=0; //nếu có từ khóa thì chuyển về trang đầu
  }
  if ($currentpage<=0) $currentpage=1;
  $per_page=PER_PAGE; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
   
  $kq = $this->qt->ykien_list($idbv,$per_page,$start, $totalrows,$anhien);	
?>
<script>
$(document).ready(function(){
    $("#formykien").submit(function(){
        var idbv=$("#idbv").val();
        var anhien =$("#anhien").val();
        this.action="<?php echo BASE_DIR?>quantri/ykien_list/"+ idbv + "/" + anhien+"/";
    });    
	$("img.anhien").click(function(){
		var idykien = $(this).attr("idykien");
		var url="<?php BASE_DIR?>quantri/ykien_daoanhien/" + idykien +"/";
		
		var obj=this;
		$.get(url,null, function(d){ 
			obj.src=d;
			if (d.substr(-5)=="0.jpg") obj.title="Ý kiến này đang ẩn, nhắp vào để hiện";  
			else obj.title="Ý kiến này đang hiện, nhắp vào để ẩn";  
		})
	})
});
</script>
<table id=list width=100% border=1 cellpadding=4 cellspacing=0 align=center class="list">
<tr class=captionrow><td><span>Quản trị ý kiến</span></td></tr>
<tr><td align=midden height=50>
<?php $phanloai = $this-> qt->listloai_dequy(0); ?>
<div style="float:left; margin-top:10px; ">
<form action="" method="post" style="margin: 0;" id="formykien">
<input class="txt" type="text" name="idbv" id="idbv" value="<?php echo $idbv;?>" title="Chọn idbv để xem ý kiến trong đó" /> 
<input class="txt" type="text" name="tukhoatimyk" id="tukhoatimyk" value="<?php echo $_SESSION['tukhoatimyk']?>" size="18" title="Nhập từ khóa tìm kiếm rồi Enter. Có thể tìm theo họ tên, nội dung ý kiến hoặc idykien">

<select name="anhien" id="anhien" title="Chọn trạng thái ẩn hiện của ý kiến">
<option value="-1" <?php if ($anhien==-1) echo "selected"?>>Ẩn hiện</option>
<option value="0" <?php if ($anhien==0) echo "selected"?>>Đang ẩn</option>
<option value="1" <?php if ($anhien==1) echo "selected"?>>Đang hiện</option>
</select>
<input type="submit" value="Xem" name="btnxem" />
Có <?php echo $totalrows?> ý kiến.
<a href="<?php echo BASE_URL?>quantri/ykien_list/-1/-1">Xem hết</a>
</form>
</div>
<div style="float:right;" id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/ykien_list/$idbv/$anhien", $totalrows, 3,$per_page, $currentpage);?>
</div>
</td></tr>
<?php foreach($kq as $row){ ?>
<tr class=motykien>
<td valign=top>
<span class="idykien" title="idykien"><?php echo $row['idykien']?></span>&nbsp;
<span class="hoten"><b title="Họ tên người đưa ý kiến"><?php echo $row['hoten']?></b>&nbsp; 
<i title="Email người đưa ý kiến"><?php echo $row['email']?></i> </span> &nbsp;-&nbsp; 
<span class="anhien"><?php echo ($row['anhien']==0)? "Đang ẩn":"Đang hiện"?></span>.&nbsp; 
<span class="ngay">Ngày: <?php echo date('d/m/Y H:i:s',strtotime($row['ngay']))?></span>.&nbsp; 
<span class="bv"> Bài viết: 
<a href="<?php echo BASE_DIR?>quantri/ykien_list/<?php echo $row['idbv']?>/"> 
<?php 
$bv = $this->qt->chitietbaiviet($row['idbv']);
echo $row['idbv']." : ".$bv['tieude'];
?>
</a>&nbsp; 

<?php $loai_bv=$this->qt->chitietloaibaiviet($bv['idloai']);?> 
<a href="<?php echo BASE_URL?><?php echo $bv['alias']?>.html" target="_blank">
Xem
</a>
</span>
<p><?php echo $row['noidung']?></p>
<span class=suaxoa>
 <a href="<?php echo BASE_URL?>quantri/ykien_sua/<?php echo $row['idykien']?>" >Sửa</a> - 
 <a href="<?php echo BASE_URL?>quantri/ykien_xoa/<?php echo $row['idykien']?>" onclick="return confirm('Xóa hả');">Xóa
 </a>
 <?php if ($row['anhien']==0) {?>
  <img class="anhien" idykien="<?php echo $row['idykien']?>" src="<?php echo BASE_DIR?>img/AnHien_0.jpg" title="Ý kiến này đang ấn. Nhắp vào để hiện" />
 <?php } else {?>
  <img class="anhien" idykien="<?php echo $row['idykien']?>" src="<?php echo BASE_DIR?>img/AnHien_1.jpg" title="Ý kiến  này đang hiện. Nhắp vào để ẩn" />
 <?php }?>
</span>

</td>
</tr>
<?php }?>
<tr><th>
<div id="thanhphantrang">
<?php echo $this->qt->pageslist(BASE_DIR."quantri/ykien_list/$idbv/$anhien", $totalrows, 5,$per_page, $currentpage);?>
</div>

</th></tr>
</table>