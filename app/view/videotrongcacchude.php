<?php foreach ($array_alias as $alias) { ?>
<?php 
$chudevideo = $this->model->laychitietchudevideo($alias); //l?y idloai t??ng ?ng v?i alias
$idloai=$chudevideo['idchudevideo'];	
$listvideo = $this->model->videotrongchude($idloai,$per_page=50,$start=0, $totalrows );
$tenchudevideo = $chudevideo['tenchudevideo'];
$alias = $chudevideo['alias'];
?>
<div id="videolist">
	<h2 class="box_caption">
	<a href="<?php echo BASE_URL . $alias."/"?>"><?php echo $tenchudevideo?></a>
	</h2>
	<div class="onecolumn">
	<?php $dem=1; foreach($listvideo as $row){?>
		<div class="motchude"> 
		<a href="http://www.youtube.com/embed/<?php echo $row['idyoutube']?>" title="<?php echo $row['tenvideo']?>"  
		 class="html5lightbox" data-description="<?php echo $row['mota']?>" >
		<?php echo $dem++. " &nbsp;". $row['tenvideo']?>  
		 </a>
		<p class="mota"><?php echo $row['mota']?></p>
		</div>
	<?php } //video foreach $kq?>
	</div>
</div>
<div class="separator"></div>
<?php }//foreach array_alias?>