<?php 
$idchude= $this->params[0]; settype($idchude,"int"); 
if ($idchude<=0) return; 
$currentpage= $this->params[1]; settype($currentpage,"int");
if ($currentpage<=0) $currentpage=1;
$per_page=PER_PAGE*2; $totalrows=0;  $start = ($currentpage-1)*$per_page;   
$playlist =  $this->model->playlisttheochude($idchude,$per_page, $start,$totalrows);
?>
<?php if (count($playlist)>0) { ?>
<div id="playlisttrongchude" class="playlists">
    <h4 class=box_caption><?php echo $this->model->laytenchudemedia($idchude);?></h4>	
    <?php foreach($playlist as $row_playlist ){ ?>
    <p class="motplaylist">
    <a href="#" idpmedialaylist="<?php echo $row_playlist['idmediaplaylist']?>" class="nghenhac" >
	<?php echo $row_playlist['tenmediaplaylist']?>
	</a>
    <img src="<?php echo BASE_DIR;?>js/playnhac/head.png" class="nghenhac" idpmedialaylist="<?php echo $row_playlist['idmediaplaylist']?>" style="cursor:pointer" />
    </p>
	<div id="divnghenhac" class="divnghenhac" style="display:none"></div>
    <?php } ?>
</div>

<?php }?>
<script>
$(document).ready(function(){
	$(".nghenhac").click(function(){	
		//document.getElementById("audio_cotphai").pause();
		//alert('a');
		$(".divnghenhac").html("").hide();
		
		var obj = $(this).parent().next(); //divnghenhac
		var idpmedialaylist= $(this).attr("idpmedialaylist");
		
		var url = "<?php echo BASE_DIR?>playlist_1/" + idpmedialaylist + "/";	
		obj.load(url, null, function(d){$(this).toggle(500); });
		
		return false;
	})
})
</script>