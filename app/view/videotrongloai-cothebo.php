<?php 

$kq = $this->model->videotrongloaichude($loaivideo,$per_page=100,$startrow=0, $totalrows_video3 );
if (count($kq)<=0) continue;
$dem=1;
?>
<div id="videolist">
<h2 class="box_caption">Phim Phật giáo Việt Nam </h2>
<?php foreach($kq as $row){?>
	<p class="motphapthoai"> 
	<a href="http://www.youtube.com/embed/<?php echo $row['idyoutube']?>" title="<?php echo $row['tenvideo']?>"  
	 class="html5lightbox" data-description="<?php echo $row['mota']?>" >
	<?php echo $dem++. " &nbsp;". $row['tenvideo']?>  
	 </a>	 
	</p>
<?php } //lặp video foreach $kq?>
</div>
<div class="separator"></div>
