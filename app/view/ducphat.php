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
<div id="bvducphat">
<h1 class="tieude"><?php echo $bai['tieude']?></h1>
<h2 class="tomtat"><?php echo $bai['tomtat']?></h2> 
<hr>
<div id="noidung"><?php echo $this->model->ThayTheCodeDacBiet($bai['content'])?></div>
</div>


