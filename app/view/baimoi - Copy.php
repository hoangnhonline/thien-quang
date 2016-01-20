<?php $baimd = $this->model ->baimoi(4);?>
<div id="baimoi">
<p class="box_caption">Tin tức chùa Thiên Quang</p>
<?php foreach ($baimd as $rowmd) {?>
<div class="motbai">
<img src="<?php echo BASE_URL.$rowmd['urlhinh']?>" align="left" class="hinh">
<p>
<a href="<?php echo BASE_URL.$rowmd['alias']?>.html"> <?php echo $rowmd['tieude'];?> </a>
<?php echo htmlentities($rowmd['tomtat'],ENT_QUOTES,'utf-8');?>
</p>
</div>
<?php } ?>
<p class="xemtiep"><a href="#">Xem tiếp...</a></p>
</div>