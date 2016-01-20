<?php   
  $currentpage= $this->params[0]; settype($currentpage,"int");  
  if ($currentpage==-1) $_SESSION['tukhoatimtag']=""; //trường hợp nhắp link "Xem hết"
  if (isset($_POST['tukhoatimtag'])) {
    $_SESSION['tukhoatimtag']=$_POST['tukhoatimtag']; 
    $currentpage=0; //nếu có từ khóa thì chuyển về trang đầu
  }
  if ($currentpage<=0) $currentpage=1;
  $per_page=40; $totalrows=0; 
  $start = ($currentpage-1)*$per_page;
  $kq = $this->qt->tag_list($per_page,$start, $totalrows);	
?>
<div id=listtagContainer class="list">
	<p class=captionrow><span>Quản trị tag </span></p>
	<div id=search >
	<form action="" method="post" style="margin: 0;">
	<input class=tukhoa type="text" name="tukhoatimtag" id="tukhoatimtag" value="<?php echo $_SESSION['tukhoatimtag']?>" size="14">
	Có <?php echo $totalrows?> tags.
	<a href="<?php echo BASE_URL?>quantri/tag_list/-1">Xem hết</a>
	</form>
	</div>
	<div id="listtag">
	<?php foreach($kq as $row){ ?>
	<p>
	<a href="<?php echo BASE_DIR?>quantri/tag_xoa/<?php echo $row['idtag']?>" onclick="return confirm('Xóa hả')"><img src="<?php echo BASE_DIR?>img/delete.png"></a>
	<a href="<?php echo BASE_DIR?>quantri/tag_sua/<?php echo $row['idtag']?>"><?php echo $row['tentag']?></a> (<span><?php echo $this->qt->dembaitrongtag($row['idtag'])?></span>)</p>	
	<?php }?>
	</div>
	<?php if ($totalrows>$per_page) {?>
	<div id="thanhphantrang" style="text-align:center">
	<?php echo $this->qt->pageslist(BASE_DIR."quantri/tag_list", $totalrows, 5,$per_page, $currentpage);?>
	</div>
	<?php }?>
</div>

