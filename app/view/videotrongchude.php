<div id="videolist">
<h2 class="box_caption"><?php echo $tenchudevideo?></h2>
<?php $dem=1; foreach($listvideo as $row){?>
	<div class="motchude"> 
	<a href="http://www.youtube.com/embed/<?php echo $row['idyoutube']?>" title="<?php echo $row['tenvideo']?>"  
	 class="html5lightbox" data-description="<?php echo $row['mota']?>" >
	<?php echo $dem++. " &nbsp;". $row['tenvideo']?>  
	 </a>	
	<p class="mota"><?php echo $row['mota']?></p>	 
	</div>
<?php } //lặp video foreach $kq?>
</div>

<div class="separator"></div>
