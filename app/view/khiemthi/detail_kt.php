<script>
function chinhdocao(){ 
    var h1=$("#part2_1").height();
    var h2=$("#part2_2").height();    
	if (h1>h2) $("#part2_2").height(h1);  
	else $("#part2_1").height(h2);	
}
$(document).ready(function(){
    setTimeout("chinhdocao()",500);
});
</script>
<div id="detail_kt">
<h1 class="tieude"><?php echo $bai['tieude']?></h1>
<h2 class="tomtat"><?php echo $bai['tomtat']?></h2> 
<hr>
<div id="noidung"><?php echo $this->model->ThayTheCodeDacBiet($bai['content'])?></div>
<?php $baitt = $this->model ->baitieptheo($idbv, 10);?>
<?php if (count($baitt)>0) {?>
<div id="baitieptheo">
	<h4 class="box_caption">Bài tiếp theo</h4>
	<?php foreach($baitt as $rowtt ){ ?>
	<p><a href="<?php echo BASE_URL2.$rowtt['alias']?>.html"> <?php echo $rowtt['tieude']?></a></p>
	<?php }?>
</div>
<?php }?>

</div>


