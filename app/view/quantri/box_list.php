<?php   
  $currentpage= $this->params[0]; settype($currentpage,"int");  
  if ($currentpage==-1) $_SESSION['tukhoatimbox']=""; //trường hợp nhắp link "Xem hết"
  if (isset($_POST['tukhoatimbox'])) {
    $_SESSION['tukhoatimbox']=$_POST['tukhoatimbox']; 
    $currentpage=0; //nếu có từ khóa thì chuyển về trang đầu
  }
  if ($currentpage<=0) $currentpage=1;
  $per_page=30; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  $kq = $this->qt->box_list($per_page,$start, $totalrows);	
?>
<script>
$(document).ready(function(){
	$("#listbox a.tenbox").click(function(){
		var idbox = $(this).attr("idbox");
		var url="<?php echo BASE_URL?>quantri/thongtin1box/" + idbox;			
		$.get(url, "", function(data){
			b= $.parseJSON(data);	
			tenbox = b.tenbox; 			tenboxkhongdau = b.tenboxkhongdau;
			listid = b.listid; 			sobai = b.sobai;
			hienthibai = b.hienthibai;	mota = b.mota;
			loaibox = b.loaibox;		noibat = b.noibat;
			sapxep = b.sapxep;			anhien = b.anhien; 	hientenbox = b.hientenbox;
			$("#tenbox").val(tenbox);		 $("#tenboxkhongdau").val(tenboxkhongdau);
			$("#listid").val(listid);		 $("#sobai").val(sobai);				
			$("#hienthibai").val(hienthibai);$("#mota").val(mota);			
			$("#loaibox").val(loaibox);		 $("#noibat").val(noibat);
			$("#sapxep").val(sapxep);		 $("#idbox").val(idbox);
			if (anhien==0) { $("#anbox").prop("checked",true);	$("#hienbox").prop("checked",false);}
			else {	$("#anbox").prop("checked",false); 	$("#hienbox").prop("checked",true);	}
			
			if (hientenbox==0) {$("#antenbox").prop("checked",true);$("#hientenbox").prop("checked",false);	}
			else { $("#antenbox").prop("checked",false); $("#hientenbox").prop("checked",true);	}		
		});
		return false;
	})
});
</script>
<div id="listboxContainer">
	<p class=captionrow><span>Quản trị box </span>	
	<a href="<?php echo BASE_URL?>quantri/box_them" title="Thêm box">Thêm box</a>
	</p>
	<div id="listboxContainer_left">	
		<?php include "box_detail.php";?>
	</div>
	<div id="listboxContainer_right">	
		<div id=search >
		<form action="" method="post" style="margin: 0 0 0 10px;">
		<input class=tukhoa type="text" name="tukhoatimbox" id="tukhoatimbox" value="<?php echo $_SESSION['tukhoatimbox']?>" size="14">
		Có <?php echo $totalrows?> boxs.
		<a href="<?php echo BASE_URL?>quantri/box_list/-1">Xem hết</a>
		</form>
		</div>
		<div id="listbox">
		<?php foreach($kq as $row){ ?>
		<p>
		<a href="<?php echo BASE_DIR?>quantri/box_xoa/<?php echo $row['idbox']?>" onclick="return confirm('Xóa hả')"><img src="<?php echo BASE_DIR?>img/delete.png"></a>
		<a idbox="<?php echo $row['idbox']?>" href="#" class="tenbox">
		<?php echo $row['idbox']. ". ". $row['tenbox']?>
		</a></p>	
		<?php }?>
		</div>
		<?php if ($totalrows>$per_page) {?>
		<div id="thanhphantrang" style="text-align:center">
		<?php echo $this->qt->pageslist(BASE_DIR."quantri/box_list", $totalrows, 5,$per_page, $currentpage);?>
		</div>
	<?php }?>
	</div>
</div>

