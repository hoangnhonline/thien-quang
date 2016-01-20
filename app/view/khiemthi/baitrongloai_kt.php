<div id="dsbaiviet" class="baimoitrong1loai">
<h2 class="box_caption"><?php echo $tenloai?></h2>
<?php $dem=0;
foreach ($listbai as $row) { $dem++;?>
<div class="motbai">
<h3>
<a href="<?php echo BASE_URL2.$row['alias']?>.html" class="tieude" thutu="<?php echo $dem;?>"> 
<?php echo $dem. "&nbsp; ". $row['tieude'];?> 
</a>
</h3>
<p><?php echo htmlentities($row['tomtat'],ENT_QUOTES,'utf-8');?></p>
</div>
<?php } ?>
<p id="thanhphantrang">
<?php echo $this->model->pageslist(BASE_URL2."$alias",$totalrows,5,$per_page, $currentpage);?>
</p>
</div>