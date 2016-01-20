<?php 
//khi include file này phải gán giá trị cho biến $idmediaplaylist
$objname="playlist_{$idmediaplaylist}";?>
<style>
#<?php echo $objname?> {background1:#CBF8BD}
#<?php echo $objname?> #caption {margin:0;  }
#<?php echo $objname?> #titlemedia {padding:5px 0 5px 5px; margin:0; 
	background-color:#F9CF5B; color:#00665E; display:none; }
#<?php echo $objname?> audio{width:100%; margin:0;
    background: -webkit-linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
    background: -moz-linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
    background: -o-linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
    background: -ms-linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
    background: linear-gradient(top, #4c4e5a 0%, #2c2d33 100%);
}
#<?php echo $objname?> ul { margin:0; padding:0; }
#<?php echo $objname?> .active span{font-weight:bold}
#<?php echo $objname?> li {list-style:none; border-bottom:solid 1px #999; 
			  background: url(<?php echo BASE_DIR?>js/playnhac/head.png); 
			  background-repeat:no-repeat; 
			  background-position:8px 12px; }
#<?php echo $objname?> li:hover{ }
#<?php echo $objname?> li span{
		color:#006633; margin-left:30px; 
		display:block;
		padding:10px 0 10px 0; 
		cursor:pointer ;
}
#<?php echo $objname?> li span:hover{ text-decoration:underline; }

</style>
<script>
$(document).ready(function(){ 	
	var obj = $('#<?php echo $objname;?>');		
    obj.find('li span').click(function(e){
		$('audio').each(function(){this.pause(); this.currentTime = 0;  }); //dừng các audio khác
        e.preventDefault();
		$(".divnghenhac").html("").hide();
        run($(this) , obj.find("audio")[0]);
    });
    obj.find("audio")[0].addEventListener('ended',function(e){        
		var next = obj.find('li.active').next();		
		if (next.length==1)	link = next.find('span');
		else link = obj.find('span')[0];
        run( $(link) , obj.find("audio")[0] );
    });
}); 
</script>

<?php $playlist = $this->model->layplaylist($idmediaplaylist, $numrows=15);?>
<div id="<?php echo $objname?>" class="showplaylist">	
	<h3 id="caption" class="box_caption center">
	<?php $pl = $this->model->laychitietplaylist($idmediaplaylist);
		  echo $pl['tenmediaplaylist'];
	?>
	</h3>
	<h4 id="titlemedia"></h4>
    <audio id="audio" preload="auto" controls type="audio/mpeg" onplay="if (this.src=='') $(this).parent().find('li span')[0].click()" >       
        Sorry, your browser does not support HTML5 audio.
    </audio>
    <ul id="playlist">
		<?php foreach($playlist as $row_pl) {
			$url = $row_pl['url']; 			
			if (substr($url,0,1)=="/") $url=BASE_URL.substr($row_pl['url'],1);
			else if (substr($url,0,7)=="http://") $a=1;
			else if (substr($url,0,8)=="https://") $a=1;
			else $url=BASE_URL.$row_pl['url'];
		?>
        <li><span href="<?php echo $url;?>"><?php echo $row_pl['tenmedia']?></span></li>
        <?php }?>
    </ul>
</div>