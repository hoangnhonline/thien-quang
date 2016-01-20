<?php foreach($listyk as $rowyk ){ ?>
    <div class="motykien">
    <h4><?php echo $rowyk['hoten']?> , &nbsp;<?php echo date('d/m/Y H:i:s',strtotime($rowyk['ngay']))?></h4>
    <p class="noidung"><?php echo str_replace("\\r\\n","<br>",$rowyk['noidung'])?></p>
    </div>
<?php }?>
<?php $prevpage= $currentpage-1; $nextpage= $currentpage+1;?>
<br />
<p id="thanhphantrang">
<?php if ($prevpage>0) {?>
<a href="<?php echo BASE_DIR?>nt/listykien/<?php echo $idbv?>/<?php echo $prevpage?>/" >Trang trước</a>
<?php }?>
<?php if ($nextpage<$totalrows){ ?>
<a href="<?php echo BASE_DIR?>nt/listykien/<?php echo $idbv?>/<?php echo $nextpage?>/">Trang sau</a>
<?php }?>
</p>
<script>
$(document).ready(function(){
    $("#divykien #thanhphantrang a").click(function(){        
        var url =$(this).attr("href");
        $.ajax({
            url:url, cache:false, success:function(d){ $("#listykien").html(d) }
        });
        return false;
    })
})
</script>
