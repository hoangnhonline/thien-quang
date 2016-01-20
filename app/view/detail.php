<script>
function chinhdocao(){ 
    var h1=$("#cot1").height();
    var h2=$("#cot2").height();    
	if (h1>h2) $("#cot2").height(h1);  
	else $("#cot1").height(h2);	
}
$(document).ready(function(){
    setTimeout("chinhdocao()",500);
});
</script>
<div id="baiviet_ct">
<div id="tc"><a href="<?php echo BASE_URL?>">Trang chủ</a></div>
<h1 class="tieude"><?php echo $bai['tieude']?></h1>
<h2 class="tomtat"><?php echo $bai['tomtat']?></h2> 
<hr>
<div id="noidung"><?php echo $this->model->ThayTheCodeDacBiet($bai['content'])?></div>
<div class="xem">
Lượt xem: <?php echo $bai['solanxem']?>  . Ngày đăng: <?php echo date('d/m/Y',strtotime($bai['ngay']))?>
</div>
</div>

<div id=divfacebook>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
		<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
<?php $baitt = $this->model ->baitieptheo($id, 10);?>
<?php if (count($baitt)>0) {?>
<div id="baitieptheo">
	<h4 class="box_caption">BÀI LIÊN QUAN</h4>
	<?php foreach($baitt as $rowtt ){ ?>
	<p><a href="<?php echo BASE_URL.$rowtt['alias']?>.html"><?php echo $rowtt['tieude']?></a></p>
	<?php }?>
</div>
<?php }?>
<?php if ($bai['themykien']==1) {?>
    <script>
    $(document).ready(function(){
        $.ajax({
            url:"<?php echo BASE_DIR?>listykien/<?php echo $id?>/",cache:false,
            success:function(d){ 
                if (d=="") $("#listykien").hide();
                else {
                    $("#listykien").html(d).show();
                    var t1 = $("#listykien").position().top+ $("#listykien").height();
                    var t2 = $("#traiduoi").position().top+ $("#traiduoi").height();
                    if (t1>t2){
                        var khoangcachlech = t1-t2;
                        var h =$("#traiduoi").height() + khoangcachlech;
                        $("#traiduoi").height(h);
                    }
                } 
            }
        })
        
        $("#guibinhluan").click(function(){
            var d = $("#formykien").serialize();
            $.ajax({
                url:"<?php echo BASE_URL?>luuykien/<?php echo $id?>/",
                data:d, type:"POST", cache:false,
                success:function(d){
                    if(d=="OK") {            
                        var dc="<?php echo BASE_URL?>listykien/<?php echo $id?>/";
                        $("#formykien").html("<div id=divcamon>Cảm ơn bạn! Ý kiến đã được ghi nhận</div>");
                        $.ajax({url:dc,cache:false,success:function(dsyk){$("#listykien").html(dsyk);}
                        })
                    } else alert("Lỗi:" +d);         
                }   
            })            
        })
    })
    </script>
    <div id="divykien">
        <h4 class="box_caption">Ý kiến bạn đọc</h4>
        <form  id="formykien" name="formykien" action="" method="post">
            <p><textarea title="Ý kiến của bạn" name="noidungyk" id="noidungyk" onclick="if(this.value=='Ý kiến của bạn') this.value='';"  onblur="if (this.value=='') this.value='Ý kiến của bạn';">Ý kiến của bạn</textarea></p>
            <p>
            <input class="txt" title="Họ tên của bạn" type="text" name="hoten" id="hoten" value="Họ tên của bạn" onfocus="if(this.value=='Họ tên của bạn') this.value='';"  onblur="if (this.value=='') this.value='Họ tên của bạn';"/>
            <input class="txt" title="Địa chỉ mail của bạn" type="text" name="email" id="email" value="Email" onfocus="if(this.value=='Email') this.value='';"  onblur="if (this.value=='') this.value='Email';"/>
            </p>           
            <table id="tblcapcha"> <tr>
            <td><img src="<?php echo BASE_DIR?>captcha/" width="140" height="35" id="hinhcaptcha" /></td>
            <td><input type="text" name="cap" id="cap" value="Nhập chữ trong hinh" onclick="this.value=''" /></td>
            <td valign="top"><input type="button" value="GỬI Ý KIẾN" name="guibinhluan" id="guibinhluan" /><input type="hidden" name="idbv" value="<?php echo $id?>" /></td>
            </tr>
            </table>
        </form> 
        <hr />
        <div id="listykien"></div>
        
    </div>
<?php }?>


