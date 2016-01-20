<?php //lấy pháp thoại mới của SC Hương Nhũ DEFAULT_IDTACGIAVIDEO=5
$kq = $this->model->listvideotheotacgia(DEFAULT_IDTACGIAVIDEO,$per_page=9,$startrow=0, $totalrows_video1 );
?>
<div id="phapthoaimoi">
<p class="box_caption">Pháp thoại mới</p>
<?php foreach($kq as $row){?>
<div class="motphapthoai">
<a href="http://www.youtube.com/embed/<?php echo $row['idyoutube']?>"
	 class="html5lightbox" data-description="<?php echo $row['mota']?>" 
	 title="<?php echo mb_convert_case($row['tenvideo'],MB_CASE_UPPER,'utf-8')."\r\n".$row['mota'];?>" >
<?php // hqdefault.jpg mqdefault.jpg hqdefault.jpg sddefault.jpg maxresdefault.jpg ?>
<img src="http://img.youtube.com/vi/<?php echo $row['idyoutube']?>/mqdefault.jpg" 
	 title="<?php echo mb_convert_case($row['tenvideo'],MB_CASE_UPPER,'utf-8'). "\r\n".$row['mota']?>" alt="<?php echo $row['tenvideo']?>"
	 width="120"  height="90">
<p><?php echo $row['tenvideo']?></p>
</a>
</div>
<?php }?>
</div>
<div class="separator"></div>