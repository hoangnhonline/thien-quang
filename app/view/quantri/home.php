<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo BASE_DIR?>"/>
<link href="<?php echo BASE_URL?>css/quantri.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo BASE_URL?>js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL?>js/jquery.cookie.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo BASE_URL?>js/menu_quantri/menu_jquery.js"></script>
<link type="text/css" href="<?php echo BASE_URL?>js/menu_quantri/styles.css" rel="stylesheet" />

<script src="<?php echo BASE_URL?>js/jquery.treeview/lib/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL?>js/jquery.treeview/jquery.treeview.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo BASE_URL?>js/jquery.treeview/jquery.treeview.css" />
<script src="<?php echo BASE_DIR?>js/ckeditor/ckeditor.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo BASE_DIR?>js/ckfinder/ckfinder.js" type="text/javascript"></script>
<script>
    $(function() {
		$("#tree").treeview({collapsed: true, animated: "medium",control:"#sidetreecontrol", persist: "location"});
    })
</script>
<script type="text/javascript">
var api;
function BrowseServer1( startupPath, functionData ){
	var finder = new CKFinder();
	finder.basePath = '<?php echo BASE_DIR?>js/ckfinder/'; //Đường path nơi đặt ckfinder
	finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
	finder.selectActionFunction = SetFileField;//hàm được gọi khi chọn 1 file 
	finder.selectActionData = functionData; //id của textfield hiện địa chỉ hình
	api = finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer
function SetFileField( fileUrl, data ){
    //alert(fileUrl);
}
</script>
<title>Quản trị <?php echo TITLE_SITE?></title>
</head>
<body>
<div id="wrapper"> 
	<div id="header"> 
		<h1>Quản trị website <?php echo TITLE_SITE?> </h1>  
		<div id="chao"> 
			<p>
            <a href="<?php echo BASE_DIR?>" target=_blank>Phần Public</a> &nbsp;| &nbsp;
			<a href="<?php echo BASE_DIR?>quantri/thoat">Thoát</a> &nbsp;| &nbsp;
			Kính chào <?php echo $_SESSION['login_hoten'];?> 
			</p>			
		</div>  
	</div>
   <div id="menu"> 
 
   <div id='cssmenu'>
    <ul>
       <li><a href="<?php echo BASE_DIR?>quantri"><span>Trang chủ</span></a></li>
       <li class='has-sub'><a href='#'><span>Quản lý</span></a>
          <ul>             
			 <li><a href="<?php echo BASE_DIR?>quantri/tag_list"><span>Quản lý tag</span></a></li>			
             <li><a href="<?php echo BASE_DIR?>quantri/loaibaiviet_list"><span>Quản lý loại</span></a></li>			 
             <li><a href="<?php echo BASE_DIR?>quantri/tacgia_list"><span>Quản lý tác giả</span></a></li>
			 <li><a href="#" onclick="BrowseServer1('hinh://',''); return false;" title="Có thể upload file zip lên rồi giải nén trên server"><span>Upload hình</span></a></li>
			 <li><a href="#" onclick="BrowseServer1('Mp3://',''); return false;" title="Có thể upload file zip lên rồi giải nén trên server"><span>Upload MP3</span></a></li>
			 <?php if ($_SESSION['login_level']==4){?>
			 <li><a href="<?php echo BASE_DIR?>quantri/box_list"><span>Quản lý box</span></a></li>             
			 <li><a href="<?php echo BASE_DIR?>quantri/user_list/">Quản lý user</a></li>
			 <li><a href="<?php echo BASE_DIR?>quantri/cauhinh"><span>Cấu hình</span></a></li>
			<?php }?>
			<li><a href="<?php echo BASE_DIR?>quantri/changepass/">Đổi mật khẩu</a></li>			
			<li><a href="<?php echo BASE_DIR?>quantri/thoat/">Thoát</a></li>
          </ul>
       </li>
	  <li><a href="<?php echo BASE_DIR?>quantri/baiviet_them"><span>Thêm bài viết</span></a></li>
	  <li><a href="<?php echo BASE_DIR?>quantri/baiviet_list"><span>Quản lý bài viết</span></a></li>
	   <li><a href="<?php echo BASE_DIR?>quantri/loaibaiviet_list"><span>Quản lý loại</span></a></li>	
       <li><a href="<?php echo BASE_DIR?>quantri/ykien_list"><span>Ý kiến</span></a></li>
       <li class='has-sub'><a href='#'><span>Album hình</span></a>
          <ul>
             <li><a href="<?php echo BASE_DIR?>quantri/album_them"><span>Thêm album</span></a></li>
             <li><a href="<?php echo BASE_DIR?>quantri/album_list"><span>Quản lý album</span></a></li>
          </ul>
       </li>	   
        <li class='has-sub'><a href='#'><span>Video</span></a>
          <ul>
             <li><a href="<?php echo BASE_DIR?>quantri/video_them"><span>Thêm video</span></a></li>
             <li><a href="<?php echo BASE_DIR?>quantri/video_list"><span>Danh sách video</span></a></li>
             <li><a href="<?php echo BASE_DIR?>quantri/chudevideo_them"><span>Thêm chủ đề video</span></a></li>
             <li><a href="<?php echo BASE_DIR?>quantri/chudevideo_list"><span>Danh sách chủ đề video</span></a></li>
             
          </ul>
       </li>
	   <li class='has-sub'><a href='#'><span>MP3</span></a>
          <ul>             
	   <li><a href="<?php echo BASE_DIR?>quantri/mediaplaylist_them"><span>Thêm playlist</span></a></li>
	   <li><a href="<?php echo BASE_DIR?>quantri/mediaplaylist_list"><span>Danh sách playlist</span></a></li>
             <li><a href="<?php echo BASE_DIR?>quantri/chudemedia_them"><span>Thêm chủ đề media</span></a></li>
             <li><a href="<?php echo BASE_DIR?>quantri/chudemedia_list"><span>Danh sách chủ đề media</span></a></li>
             <li><a href="<?php echo BASE_DIR?>quantri/media_them"><span>Thêm media</span></a></li>
             <li><a href="<?php echo BASE_DIR?>quantri/media_list"><span>Danh sách media</span></a></li>
          </ul>
       </li>      
	</li>
	   
	   
	   
	   
	   
    </ul>
    </div>
   </div>
   
   <div id="content"> 
	<?php
	if ($this->current_action=="index") include "thongke.php";
	
	if ($this->current_action=="youtubeplaylist_them") include "youtubeplaylist_them.php";
	if ($this->current_action=="youtubeplaylist_list") include "youtubeplaylist_list.php";
	if ($this->current_action=="youtubeplaylist_sua") include "youtubeplaylist_sua.php";
	
	if ($this->current_action=="tacgia_them") include "tacgia_them.php";
	if ($this->current_action=="tacgia_list") include "tacgia_list.php";
	if ($this->current_action=="tacgia_sua") include "tacgia_sua.php";
	
	if ($this->current_action=="baiviet_them") include "baiviet_them.php";
	if ($this->current_action=="baiviet_list") include "baiviet_list.php";
	if ($this->current_action=="baiviet_sua") include "baiviet_sua.php";
	if ($this->current_action=="baiviet_xoa") include "thongbao.php";
	
	
	if ($this->current_action=="loaibaiviet_them") include "loaibaiviet_them.php";
	if ($this->current_action=="loaibaiviet_list") include "loaibaiviet_list.php";
	if ($this->current_action=="loaibaiviet_sua") include "loaibaiviet_sua.php";
	if ($this->current_action=="loaibaiviet_xoa") include "thongbao.php";
	
	
	if ($this->current_action=="album_them") include "album_them.php";
	if ($this->current_action=="album_list") include "album_list.php";
	if ($this->current_action=="album_sua") include "album_sua.php";
	if ($this->current_action=="album_xoa") include "thongbao.php";
	
	if ($this->current_action=="video_them") include "video_them.php";
	if ($this->current_action=="video_list") include "video_list.php";
	if ($this->current_action=="video_sua") include "video_sua.php";
	if ($this->current_action=="video_xoa") include "thongbao.php";
    
    if ($this->current_action=="chudevideo_them") include "chudevideo_them.php";
	if ($this->current_action=="chudevideo_list") include "chudevideo_list.php";
	if ($this->current_action=="chudevideo_sua") include "chudevideo_sua.php";
	if ($this->current_action=="chudevideo_xoa") include "thongbao.php";
    
	if ($this->current_action=="chudemedia_them") include "chudemedia_them.php";
	if ($this->current_action=="chudemedia_list") include "chudemedia_list.php";
	if ($this->current_action=="chudemedia_sua") include "chudemedia_sua.php";
	if ($this->current_action=="chudemedia_xoa") include "thongbao.php";
	
	if ($this->current_action=="media_them") include "media_them.php";
	if ($this->current_action=="media_list") include "media_list.php";
	if ($this->current_action=="media_sua") include "media_sua.php";
	if ($this->current_action=="media_xoa") include "thongbao.php";
	
	if ($this->current_action=="mediaplaylist_them") include "mediaplaylist_them.php";
	if ($this->current_action=="mediaplaylist_list") include "mediaplaylist_list.php";
	if ($this->current_action=="mediaplaylist_sua") include "mediaplaylist_sua.php";
	if ($this->current_action=="mediaplaylist_xoa") include "thongbao.php";
	
    if ($this->current_action=="cauhinh") include "cauhinh.php";
    
    if ($this->current_action=="ykien_list") include "ykien_list.php";
	if ($this->current_action=="ykien_sua") include "ykien_sua.php";
	if ($this->current_action=="ykien_xoa") include "thongbao.php";
	
	if ($this->current_action=="tag_list") include "tag_list.php";
	if ($this->current_action=="tag_sua") include "tag_sua.php";
	
	if ($this->current_action=="box_them") include "box_them.php";
	if ($this->current_action=="box_list") include "box_list.php";
	if ($this->current_action=="box_sua") include "box_sua.php";
	
	if ($this->current_action=="changepass") include "changepass.php";
	if ($this->current_action=="thongbao") include "thongbao.php";
	
	if ($this->current_action=="user_list") include "user_list.php";
	if ($this->current_action=="user_them") include "user_them.php";
	if ($this->current_action=="user_sua") include "user_sua.php";

	?>
    <div style="clear: both;"></div>
   </div>
   
</div>
</body>
</html>