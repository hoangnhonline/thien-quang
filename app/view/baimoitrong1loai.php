<?php 
//khi nhúng file này phải gán giá trị cho biến $idloaiCanHien
$kq = $this->model ->baimoitrongloai($idloaiCanHien,15);?>
<div id="baimoitrong1loai" class="baimoitrong1loai">
<h4 class="box_caption center"><?php echo $this->model->laytenloaibaiviet($idloaiCanHien)?></h4>
<?php foreach ($kq as $row) {?>
<p> 
<a class="tTip" href="<?php echo BASE_URL.$row['alias']?>.html"
title="
<h4><?php echo htmlentities($row['tieude'],ENT_QUOTES,'utf-8');?></h4>
<p class=ngay> <?php echo date('d/m/Y h:i:s',strtotime($row['ngay']));?></p>
<p><img src=<?php echo $row['urlhinh']?> align='left'>
<?php echo htmlentities($row['tomtat'],ENT_QUOTES,'utf-8');?>
</p>
"
> 
<?php echo $row['tieude'];?> </a> 
</p>
<?php } ?>
</div>