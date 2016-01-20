<form action="" method="post" id="formcauhinh"  class="form">
<h4>CẤU HÌNH WEBSITE</h4>
<?php $dem=0;?>
<?php foreach($cauhinh as $param) { $dem++;?>
    <p>&nbsp;<?php echo str_pad($dem,2,"0",0);?>.
        <input class=txt type=text name="idobj[]" id="idobj[]" value="<?php echo $param["idobj"]?>"  >
        <input class=txt type=hidden name="id[]" id="id[]" value="<?php echo $param["id"]?>"  >
       <em><?php echo $param["mota"]?></em>
    </p>
<?php }?>
<p align=center><input value=" LƯU " type=submit name=btn id=btn ></p>

</form>
<br />