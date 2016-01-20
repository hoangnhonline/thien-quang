  <div id="part2">
	  <div id="content1"> <?php  include "app/view/baimoi.php";?> </div>
	  <div id="content2"><?php  include"menu.php"; ?></div>  
	  <div id="content3"> <?php include "loivangngoc.php"?>  </div>
  </div> <!-- part2 -->
 <?php include "thanhmenu2.php";?>
  <div class="separator"></div>
  <div id="part3">
	  <div id="content4">
		<?php include "phapthoaimoi.php";?>
		<?php include "phapthoaitheochude.php";?>
	  </div>
	  <div class="sep_col"></div>
	  <div id="content5">		
		<?php $idmediaplaylist = IDMEDIA_PLAYLIST2;include "playlist1.php";?>
		<?php $idmediaplaylist = IDMEDIA_PLAYLIST1;include "playlist1.php";?>
		<?php $idloaiCanHien= IDLOAI_PHAPTHOAITEXT; include "baimoitrong1loai.php";?>
		<?php $idloaiCanHien= IDLOAI_ANVIEN; include "baimoitrong1loai.php";?>
		<?php include "lich.php"?>
	  </div>
	  <div class="sep_col"></div>
	  <div id="content6">
		<?php include "phapthoaitheonam.php"?>
	  </div>
	  <div style="clear:both"></div>
  </div> <!-- part3 -->