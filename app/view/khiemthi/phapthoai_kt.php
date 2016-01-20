<?php //lấy pháp thoại mới theo nam
$arr_nam = $this->model->laylistnamcuaphapthoai();
foreach($arr_nam as $nam){
$kq = $this->model->videotrongnam("phapthoai_hn",$nam,$per_page=6,$startrow=0, $totalrows_video3 );
if (count($kq)<=0) continue;
$dem=1;
?>
<div id="phapthoaitheonam">
<h2 class="box_caption">Pháp thoại Sư Cô Hương Nhũ năm <?php echo $nam. "<em>(Có ".$totalrows_video3." pháp thoại)</em>" ?></h2>
<div class="nam">
	<?php foreach($kq as $row){?>
	<p class="motphapthoai"> 
	<a href="http://www.youtube.com/embed/<?php echo $row['idyoutube']?>" title="<?php echo $row['tenvideo']?>"  
	 class="html5lightbox" data-description="<?php echo $row['mota']?>" >
	<?php echo $dem++. " &nbsp;". $row['tenvideo']?>  
	 </a>	 
	</p>
	<?php } //lặp video foreach $kq?>
</div>
</div>
<div class="separator"></div>
<?php } //foreach $arr_nam?>
