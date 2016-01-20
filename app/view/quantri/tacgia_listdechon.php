<?php   
  $currentpage= $this->params[0]; settype($currentpage,"int");  
  if ($currentpage==-1) $_SESSION['tukhoatk']=""; //nhắp link xem hết
  if ($currentpage<=0) $currentpage=1;
  $per_page=40; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;  
  $kq = $this->qt->tacgia_list($per_page,$start, $totalrows);	
?>
<script>
$(document).ready(function(){
	$("#baiviet_chontacgia #iconclose").click(function(){
		$("#divche").hide();
		$("#divpopup").slideUp(200);
	});
	$("#baiviet_chontacgia #list_tacgia p").click(function(){
		var idtacgia = $(this).attr("idtacgia");
		$("#divche").hide();
		$("#divpopup").slideUp(200);
		$("#tacgia").val(idtacgia);
		$("#idtacgia").val(idtacgia);
	});
	$("#baiviet_chontacgia #thanhphantrang a").click(function(){
		var url= $(this).attr("href"); 
		$("#divpopup").load(url);
		return false;
	});
	$("#btnloctacgia").click(function(){
		var url="<?php echo $_SERVER['REQUEST_URI']?>";
		var data = 'tukhoatk=' + $("#loctacgia").val();
		$.post(url, data, function(d){$("#divpopup").html(d)}   )
		
	});
	$("#loctacgia").keypress(function(e){	
		if (e.which==13) {			
			$("#btnloctacgia").click();	
			return false;
		}
	});
	$("#xemhettacgia").click(function(){
		var url= $(this).attr("href"); 
		$("#divpopup").load(url);
		return false;
	})
})
</script>
<div id="baiviet_chontacgia">
	<h4>Chọn tác giả
	<input type=text id="loctacgia" value="<?php echo $_SESSION['tukhoatk']?>"/>
	<input type=button value="LỌC" id="btnloctacgia">
	<a href="<?php echo BASE_DIR?>quantri/tacgia_listdechon/-1/" id="xemhettacgia">Xem hết</a>
	<img id="iconclose" src="<?php echo BASE_DIR?>img/close.png">
	</h4>
	<div id="list_tacgia">
	<?php foreach($kq as $row){ ?>
	<p idtacgia="<?php echo $row['idtacgia']?>"><?php echo $row['tentacgia']?></p>
	<?php }?>
	</div>
	<div id="thanhphantrang">
	<?php echo $this->qt->pageslist(BASE_DIR."quantri/tacgia_listdechon", $totalrows, 5,$per_page, $currentpage);?>
	</div>
	
</div>
