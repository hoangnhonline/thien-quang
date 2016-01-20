<div id="part2bis">
	  <div id="cot1">
		<?php 
			switch ($this->current_action){
			case "detail": include "app/view/detail.php"; break;
			case "cat": include "app/view/baitrongloai.php";break;		
			case "lienhe": include "app/view/lienhe.php"; break;
			case "bando": include "app/view/bando.php"; break;
			case "gioithieu": include "app/view/gioithieu.php"; break;
			case "phapthoai": include "app/view/phapthoaitheochude.php"; break;						
			case "media":  include "app/view/playlisttrongchude.php"; break;	
			case "ducphat": include "app/view/ducphat.php"; break;
			case "videotrongchude": include "app/view/videotrongchude.php"; break;			
			case "videotrongcacchude": include "app/view/videotrongcacchude.php"; break;
			}
		?>
	  </div>	  
	  <div id="cot2">
		<?php include "menu.php";?>
		<div class="separator"></div>
		<?php //include "linkshot.php";?>
		<?php $idloaiCanHien= IDLOAI_PHAPTHOAITEXT; include "baimoitrong1loai.php";?>
		<?php $idloaiCanHien= IDLOAI_ANVIEN; include "baimoitrong1loai.php";?>
		<?php include "phapthoaitheonam.php"?>
		<?php include "lich.php"?>		
	  </div>	 	  
	  <div style="clear:both"></div>
  </div> <!-- part2bis -->