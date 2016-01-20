<div id="baitrongloai">
<h2 class="box_caption"><?php echo $tenloai?></h2>
<?php foreach ($listbai as $row) {?>
<div class="motbai">
<h3 class="tieude">
<a href="<?php echo BASE_URL.$row['alias']?>.html"> <?php echo $row['tieude'];?> </a>
</h3>
<div class="ngay">  
  <?php echo "Xem: ". $row['solanxem']?> . 
  Ngày đăng: <?php echo date('d/m/Y',strtotime($row['ngay']))?>
</div>
<p class="tomtat">
<img class="hinh" src="<?php echo $row['urlhinh']?>" align="left" />
<?php echo htmlentities($row['tomtat'],ENT_QUOTES,'utf-8');?>
</p>
<div class="xemchitiet">
<a href="<?php echo BASE_URL.$row['alias']?>.html">Xem chi tiết</a>
</div>
</div>
<?php } ?>
<p id="thanhphantrang">
<?php echo $this->model->pageslist(BASE_DIR."$alias",$totalrows,5,$per_page, $currentpage);?>
</p>
</div>