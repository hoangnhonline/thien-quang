<?php
define("BASE_URL",'http://thienquang.vn/');
define("BASE_URL2",'http://thienquang.vn/khiemthi/');
define("INDEX_CNAME",1); //index trong thanh phan url chua ten controller
//define('DEFAULT_CONTROLLER','baiviet');
//define('CNAME_ARR','quantri'); //chuỗi tên các controller trong website ngoại trừ cái mặc định
//chuỗi tên các action đặc biệt trong default controler mà không cần đặt tên controller trước nó trong url
//define('ACTION_SPECIAL_sebo','listykien|captcha|luuykien|hitcounter'); 
define('ARTICLE_SUFFIX','.html');
define("BASE_DIR", "/");
define("BASE_ROOT", "/"); 
define("HOST", "localhost");
define('DB_NAME',  "thienquang");
define('USER_DB', "root");
define('PASS_DB', "");

define('DEFAULT_ACTION','tc');
define('PER_PAGE',10);
define('ALLOW_ALBUM_IMAGETYPE','image/jpeg;image/png;image/gif');
define('ALLOW_ALBUM_IMAGESIZE',2*1024*1024);
define('TITLE_SITE','Chùa Thiên Quang');
define('TITLE_SITE2','Cho người khiếm thị');
define('SITE_DESCRIPTION','Chùa Thiên Quang hay Thiên Quang Ni tự toạ lạc tại khu phố Tân Hòa, phường Đông Hòa, thị xã Dĩ An, tỉnh Bình Dương. Chùa hiện do ni sư Hương Nhũ trụ trì. Chùa là nơi thường xuyên mở các khoá tu cho người khuyến thị và các bạn trẻ. ');
define('SITE_DESCRIPTION2','Đây là website dành cho người khiếm thị nghe giảng pháp, nghe đọc truyện, nghe nhạc, đọc kinh sách, đọc tin tức chùa Thiên Quang');
define('DIACHICHUA','Số 106/15 khu phố Tân Hòa, phường Đông Hòa, thị xã Dĩ An, tỉnh Bình Dương');
define('DIENTHOAICHUA','065037773438');
define('EMAILCHUA','hopthu@chuathienquang.com.vn');

define('SHARE_IMAGE','img/chua-thien-quang.jpg');
define('DEFAULT_IDTACGIAVIDEO',5); //tác giả video hiện trong pháp thoại mới ở trang chủ
define('DEFAULT_IDCHUDEVIDEO','2,12,13,14,15,16,17'); //các chủ đề video hiện ở trang chủ
define('IDLOAI_PHAPTHOAITEXT',3); //idloai của pháp thoại text ở trang chủ
define('IDMEDIA_PLAYLIST1',8);
define('IDMEDIA_PLAYLIST2',7);
define('IDBAIVIETDUCPHAT',8);
define('IDLOAI_ANVIEN',6); //idloai của loại anvien ở trang chủ
define('TITLE_PAGES_KT_sebo',  serialize( array(
	'hat-giong-tam-hon'=>'Hạt giống tâm hồn', 'giao-ly-phat-giao-can-ban'=>'Giáo lý Phật giáo căn bản', 
	'phapthoai_kt'=>'Trang pháp thoại cho người khiếm thị', 
	'tin-chua-thien-quang'=>'Trang tin tức chùa Thiên Quang',
	'khoa-tu-chua-thien-quang'=>'Khoá tu chùa Thiên Quang'
))); //tiêu đề các trang cho người khiếm thị

define('MAPZOOM_DANHLAM',16);
define('MAPWIDTH_DANHLAM','800px');
define('MAPHEIGHT_DANHLAM','500px');
define('MAPTYPE_DANHLAM','HYPDRID');

?>