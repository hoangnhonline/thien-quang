<style>
body {background:url(<?php echo BASE_DIR?>css/img/bg.png); font-size:18px; font-family:Times New Roman }
#formlogin1  { border:solid 3px #2F9A48; color:#036; font-weight:bold;
		width:500px; margin:100px auto; text-align:center; border-radius:10px; box-shadow:4px 4px 2px #106020 }
#formlogin1  span { width: 120px; float:left; text-align:left; margin-left:20px}
#formlogin1 h4 {margin:0px; background:#2F9A48; height:35px; line-height:35px; 
		border-top-left-radius:6px;border-top-right-radius:6px; color:yellow; text-transform:uppercase;
}
#formlogin1  #u, #formlogin1 #p {background-color:#FF6600; color:#6FF; 
	padding:4px;	border:solid 1px #990; width:280px;}
#formlogin1 #btnLog{ background-color:#036; color:#6FF; width:140px; height:40px; border-radius:20px;
		  padding:3px; border:solid 1px #6FF; text-transform:uppercase; font-weight:bold}
#formlogin1 #error {color:#FF3300; font-size:20px}

</style><?php //print_r($_SESSION)?>
<title>Đăng nhập <?=TITLE_SITE?></title>
<body>
<form id="formlogin1" name="formlogin1" method="post" action="">
<h4>ÐĂNG NHẬP HỆ THỐNG - <?=TITLE_SITE?></h4>
<div id="error"><?php echo $_SESSION['error']; unset($_SESSION['error']);?> </div>
<p><span>Tên đăng nhập</span><input type=text name="u" id="u" autofocus></span></p>
<p><span>Mật khẩu</span><input type=password name="p" id="p" ></span></p>
<p><span> </span><input type="checkbox" name="nho" id="nho">Ghi nhớ</span></p>
<p><input type="submit" name="btnLog" id="btnLog" value="Đăng nhập"/></p>
</form>
</body>