<?php 
$idmediaplaylist= $this->params[0]; settype($idmediaplaylist,"int"); if ($idmediaplaylist<=0) return; 
$media = $this->model->laymediatrongplaylist($idmediaplaylist);
//echo "a"; print_r($media); echo "b";

$objname="playnhac_{$idmediaplaylist}";?>
<style>
.playnhac {width:450px; margin-left:80px; }
.playnhac #caption {margin:0; }
.playnhac #titlemedia {padding:5px 0 5px 5px; margin:0; background-color:#F9CF5B; color:#00665E; display:none; }
.playnhac audio{ margin:0;width:100%;
    background: -webkit-linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
    background: -moz-linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
    background: -o-linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
    background: -ms-linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
    background: linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
}
.playnhac ul { margin:0; padding:0; max-height:300px; overflow:scroll; background-color:#ccc }
.playnhac .active a{font-weight:bold}
.playnhac li {list-style:none; border-bottom:solid 1px #999; 
			  background: url(<?php echo BASE_DIR?>js/playnhac/head.png); background-repeat:no-repeat; background-position:2px 10px; }
.playnhac li:hover{background:url(<?php echo BASE_DIR?>js/playnhac/head.png); background-repeat:no-repeat; background-position:2px 10px; }
.playnhac li a{color:#006633; margin-left:22px; display:block;padding:8px 0 8px 0;  }
.playnhac li a:hover{font-weight:bold }

</style>
<script>
$(document).ready(function(){ 	
	var obj = $('#<?php echo $objname;?>'); 	
    obj.find('li a').click(function(e){
        e.preventDefault();             
        run($(this) , obj.find("audio")[0]);
    });
    obj.find("audio")[0].addEventListener('ended',function(e){        
		var next = obj.find('li.active').next();		
		if (next.length==1)	link = next.find('a');
		else link = obj.find('a')[0];
        run( $(link) , obj.find("audio")[0] );
    });
	var linkdau=obj.find('a')[0];
	run( $(linkdau) , obj.find("audio")[0] ); //chạy file đầu tiên tự động
}); 
</script>
<script>
function run(link, player){
        player.src = link.attr('href');
		var tenbh=link.text();
		$(player).prev().html(tenbh).show(300);
        var par = link.parent();
        par.addClass('active').siblings().removeClass('active');
        player.load();  player.play();
}
</script>
<div id="<?php echo $objname?>" class="playnhac">	
	<h4 id="titlemedia"></h4>
    <audio preload="auto" controls type="audio/mpeg" onplay="if (this.src=='') $(this).parent().find('li a')[0].click()" >       
        Sorry, your browser does not support HTML5 audio.
    </audio>
    <ul id="playlist">
		<?php foreach($media as $row_media) {
			$url = $row_media['url']; 			
			if (substr($url,0,1)=="/") $url=BASE_URL.substr($row_media['url'],1);
			else if (substr($url,0,7)!="http://") $url=BASE_URL.$row_media['url'];
		?>
        <li><a href="<?php echo $url?>"><?php echo $row_media['tenmedia']?></a></li>
        <?php }?>
    </ul>
</div>