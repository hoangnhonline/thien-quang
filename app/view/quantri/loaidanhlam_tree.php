<h4>Loại danh lam</h4>
<?php $loaidanhlam = $this->qt->layloaidanhlam();?>    
<ul id="tree">
    <?php foreach($loaidanhlam as $motloaidl) { ?>
	<li>
	<a href="<?php echo $baseUrlForTree."?idloai=".$motloaidl['idloai']?>"><strong><?php echo $motloaidl['tenloai']?></strong></a>
	</li>
	<?php }?>

</ul>
