<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> 
<?php echo ($this->titleofpage!="")? $this->titleofpage:$this->model->getTitle($this->current_action, $this->params[0]);?>
</title>
<meta name="description" content="<?php echo ($this->descriptionofpage!='')? $this->descriptionofpage:$this->model->getDescription($this->current_action, $this->params[0]);?>"/>
<link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700&subset=latin,vietnamese' rel='stylesheet' type='text/css'>

<base href="<?php echo BASE_ROOT?>"/>
<script src="<?php echo BASE_ROOT?>js/jquery-1.11.0.min.js" type="text/javascript"></script>
<link href="<?php echo BASE_ROOT?>css/khiemthi.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_ROOT?>img/icon-do.png" rel="shortcut icon">

<script src="<?php echo BASE_URL?>js/carouselengine/amazingcarousel.js"></script>
<!-- link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>js/carouselengine/thuyetgiang.css"-->
<script src="<?php echo BASE_URL?>js/carouselengine/initcarousel-7.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_ROOT?>css/tinyTips.css" />
<script type="text/javascript" src="<?php echo BASE_ROOT?>js/jquery.tinyTips.js"></script>
<meta property="fb:app_id" content="568024223328832">
<meta property="og:site_name" content="<?php echo TITLE_SITE?>"/>
<meta property="og:type" content="website"/>
<script>

$(document).ready(function(){
	var kt1="", kt2="";
	$("body").keydown(function(e){				
		var kt = String.fromCharCode(e.which).toLowerCase(); 
		if ('0'<=kt && kt<='9'){ 
			kt1="";kt2="";
			var thutu=e.which-48;
			$("[thutu=" + thutu+"]").focus().select();
			//var url= $("[thutu=" + thutu+"]").attr("href");
			//document.location=url;
		}
		else if ('a'<=kt && kt<='z') {
			if (kt1=="") { kt1=kt; kt2="";}
			else {
				kt2=kt;
				str= kt1.concat(kt2);				
				kt1="";kt2="";			
				var ss="[hotkey="+ str + "]";
				$(ss).focus().select();
				//$(ss).trigger('mouseleave');
				//alert(ss);
			}
		}
		
		
	})
});

</script>
<?php if ($this->current_action=="detail") {?> <!-- ?? like facebook -->
	<meta property="og:title" content="<?php echo $bai['tieude'];?>"/>	
	<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>"/>	
	<?php if ($bai['urlhinh_sharefacebook']!="") {?>
		<?php if (substr( $bai['urlhinh_sharefacebook'], 0, 4 ) === "http") { ?>
			<meta property="og:image" content="<?php echo $bai['urlhinh_sharefacebook'];?>"/>
		<?php } else {?>
			<meta property="og:image" content="http://<?php echo $_SERVER['HTTP_HOST'];?><?php echo $bai['urlhinh_sharefacebook'];?>"/>
		<?php }?>
	<?php } else  { ?>
	<meta property="og:image" content="http://<?php echo $_SERVER['HTTP_HOST'];?>/img/chua-thien-quang.jpg"/>
	<?php }?>
	<meta name="description" content="<?php echo $bai['tomtat'];?>">
	<meta property="og:description" content="<?php echo $bai['tomtat'];?>"/>
<?php }?>

<script>
$(document).ready(function(){
	$('a.tTip').tinyTips('yellow', 'title');
	$('a.bTip').tinyTips('yellow', 'title');
    $.ajax({
        url:"<?php echo BASE_DIR?>hitcounter/",
        cache:false,
        success:function(d){$("#thongke_content").html(d)}        
    })    
	
});
</script>


<?php if ($this->current_action=="detail") {?> <!-- để like facebook -->
    <?php if ($bai['urlhinh']!="") {?>    
    <meta property="og:image" content="http://<?php echo $_SERVER['HTTP_HOST'].$bai['urlhinh'];?>"/>
    <?php }?>
    <meta property="og:description" content="<?php echo $bai['tomtat'];?>"/>    
<?php }?>
</head>

<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '568024223328832',
      xfbml      : true,
      version    : 'v2.1'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<script>
//để playlist nhạc trong file playlist1.php
function run(link, player){
        player.src = link.attr('href');
		var tenbh=link.text();
		$(player).prev().html(tenbh).show(300);
        var par = link.parent();
        par.addClass('active').siblings().removeClass('active');
        player.load();  
		player.play();
}
</script>
<?php include_once("analyticstracking.php") ?>
<div id="all">
<div id="wrap"> <a name="top"></a>
  <div id="part2">
	  <div id="part2_1">
		<?php  
			switch ($this->current_action){
			case "detail": include "app/view/khiemthi/detail_kt.php"; break;					
			case "media":  include "app/view/playlisttrongchude.php"; break;							
			case "cat": include "app/view/khiemthi/baitrongloai_kt.php"; break; //giong action cat
			case "phapthoai": include "app/view/khiemthi/phapthoai_kt.php"; break;						
			case "videotrongcacchude": include "app/view/videotrongcacchude.php"; break;
			case "videotrongchude": include "app/view/videotrongchude.php"; break;				
			case "ducphat": include "app/view/khiemthi/ducphat_kt.php"; break;						
			default:  include "app/view/khiemthi/icons_kt.php";
			}
		?>
	  </div>
	  <div id="part2_2"><?php  include"menu_kt.php"; ?></div>
	  <div style="clear:both"></div>
  </div> <!-- part2 -->
</div>

</div>
</body>
</html>


