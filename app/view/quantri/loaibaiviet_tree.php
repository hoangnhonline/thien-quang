<h4>Loại bài viết</h4>
<?php $cacloaibv = $this->qt->cacloai(0);?>    
<ul id="tree">
    <?php foreach($cacloaibv as $loaibv) { ?>
	<li><a href="<?php echo $baseUrlForTree.$loaibv['idloai']?>"><?php echo $loaibv['tenloai']?></a>
    <?php $listloaicon = $this->qt->cacloai($loaibv['idloai']);?>
	<?php if (count($listloaicon)>0) { ?>
	<ul>
        <?php foreach($listloaicon as $motlc) {?> 
		<li><a href="<?php echo $baseUrlForTree.$motlc['idloai']?>"><?php echo $motlc['tenloai']?> </a></li>
        <?php }?>
	</ul>
    <?php }?>
	</li>
	<?php }?>

</ul>
