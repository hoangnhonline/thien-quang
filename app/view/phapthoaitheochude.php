<?php //lấy pháp thoại mới theo chu de
$arr_chudevideo = explode(",",DEFAULT_IDCHUDEVIDEO);
foreach($arr_chudevideo as $idchudevideo){
$kq = $this->model->videotrongchude($idchudevideo,$per_page=12,$startrow=0, $totalrows_video2 );
if (count($kq)<=0) continue;
$tenchude = $this->model->laytenchudevideo($idchudevideo);
?>
<div id="phapthoaitheochude">
<p class="box_caption">Pháp thoại <?php echo $tenchude?></p>
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
<?php } //lặp video foreach $kq?>
</div>
<div class="separator"></div>
<?php } //foreach $arr_chudevideo?>