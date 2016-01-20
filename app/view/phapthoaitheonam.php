<?php //lấy pháp thoại mới theo nam
$arr_nam = $this->model->laylistnamcuaphapthoai();

foreach($arr_nam as $nam){
$kq = $this->model->videotrongnam($loaichude='phapthoai_hn',$nam,$per_page=30,$startrow=0, $totalrows_video3 );
if (count($kq)<=0) continue;
?>
<div id="phapthoaitheonam">
<p class="box_caption">Pháp thoại <?php echo $nam. "<em>(".$totalrows_video3.")</em>" ?></p>
<?php foreach($kq as $row){?>
<div class="motphapthoai"> 
<a href="http://www.youtube.com/embed/<?php echo $row['idyoutube']?>"
	 class="html5lightbox" data-description="<?php echo $row['mota']?>" 
	 title="<?php echo mb_convert_case($row['tenvideo'],MB_CASE_UPPER,'utf-8')."\r\n".$row['mota'];?>" >
	 <?php // hqdefault.jpg mqdefault.jpg hqdefault.jpg sddefault.jpg maxresdefault.jpg ?>
	<img src="http://img.youtube.com/vi/<?php echo $row['idyoutube']?>/mqdefault.jpg" 
	 alt="<?php echo $row['tenvideo']?>"
	 width="120"  height="90" >
</a>
</div>
<?php } //lặp video foreach $kq?>
</div>
<div class="separator"></div>
<?php } //foreach $arr_nam?>


