<div id="videolist">
<h2 class="box_caption"><?php echo $tenchudevideo?></h2>
<?php $dem=1; foreach($listvideo as $row){?>
	<p class="motphapthoai"> 
	<a href="http://www.youtube.com/embed/<?php echo $row['idyoutube']?>" title="<?php echo $row['tenvideo']?>"  
	 class="html5lightbox" data-description="<?php echo $row['mota']?>" >
	<?php echo $dem++. " &nbsp;". $row['tenvideo']?>  
	 </a>	 
	</p>
<?php } //lặp video foreach $kq?>
</div>

<div class="separator"></div>
