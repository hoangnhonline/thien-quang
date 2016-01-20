<?php
class quantri {
	public $qt;
	public $params;
	public $current_action;
	public $lang;
	function __construct($url){
		$arr = explode("/", $url);  //Array ( [0] => [1] => quantri [2]=>baiviet_list [3]=>1 ) 		
		if (count($arr)<=INDEX_CNAME+1) $action="";
		else $action = $arr[INDEX_CNAME+1];  		
		$params=array(); 
		if (count($arr)>=INDEX_CNAME+2) for($i=INDEX_CNAME+2 ; $i<count($arr); $i++) $params[]=$arr[$i]; 
		$this->params=$params; //dãy tham số phía sau
		
		$this->qt = new model_quantri;
		if ($action=="") $action="index";
		
		$this->current_action=$action;
		//$this->params = $params;
		
		$groupEnable=array(3,4);
		
		if ($action!="dangnhap" && $action!="thoat") $this -> qt->checklogin($groupEnable); //chỉ có nhóm 3 và 4 được vào quảntrị		
		
		if (method_exists($this,$action)==true) 
			$this->$action();
		else 
			echo "Nam mô A Di Đà Phật";
	}

	//function taoaliascholoai(){	$this->qt->taoaliascholoai();	}
	//function taoaliaschobaiviet(){	$this->qt->taoaliaschobaiviet();	}
	function capnhaturlhinhshare(){
		$this->qt->capnhaturlhinhshare();
	}
	function index(){		
		require_once "app/view/quantri/home.php";
	}

	function tacgia_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$kq = $this->qt->tacgia_them();
			header('location:'. BASE_DIR.'quantri/tacgia_list');
		}
	}
	function tacgia_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$row = $this->qt->chitiettacgia($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->tacgia_sua($id);
			header('location:'. BASE_DIR.'quantri/tacgia_list');
		}
	}
	function tacgia_list(){		
		require_once "app/view/quantri/home.php";
	}
	function tacgia_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->tacgia_xoa($id);		
		header('location:'. $_SERVER['HTTP_REFERER']);
	}
	function capnhatthututacgia(){
		$this->qt->capnhatthututacgia();
	}
	function capnhatthutubaiviet(){
		$this->qt->capnhatthutubaiviet();
	}
	function baiviet_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else if (isset($_POST['btnThemVaXem'])==true){
			$idbv= $this->qt->baiviet_them();
			header('location:'. BASE_DIR."quantri/baiviet_sua/{$idbv}/1/");
		}else{
			$kq = $this->qt->baiviet_them();
			$loaicha=$_POST['loaicha']; settype($loaicha, "int");
			setcookie("loaicha",$loaicha,time()+3600*24*30,BASE_DIR."quantri");
			if (isset($_POST['themtiep'])==true) header('location:'. BASE_DIR.'quantri/baiviet_them');
			else header('location:'. BASE_DIR.'quantri/baiviet_list');
		}
	}
	function baiviet_sua(){
		$id= $this->params[0]; settype($id,"int");
		$xemtruocbv= $this->params[1]; settype($xemtruocbv,"int");//nếu 1 là tự động bật trang xem chi tiết
		if (isset($_POST['btn'])==true){
			$kq = $this->qt->baiviet_sua($id);			
			if (strlen($_SESSION['back'])>0){
				$b = $_SESSION['back']; unset($_SESSION['back']);
				if (strpos($b,"baiviet_them")>0) header('location:'. BASE_DIR.'quantri/baiviet_list');	 
				else header('location:'. $b);
			}else header('location:'. BASE_DIR.'quantri/baiviet_list1');	 
			exit();
		}else if (isset($_POST['btnCopy'])==true){
			$idmoi = $this->qt->baiviet_them();	
			unset($_SESSION['back']);
			header('location:'. BASE_DIR.'quantri/baiviet_list');
			exit();
		} else {
			$row = $this->qt->chitietbaiviet($id);			
			$_SESSION['back']= $_SERVER['HTTP_REFERER']; 
			require_once "app/view/quantri/home.php";
		} 
	}
	function baiviet_list(){		
		require_once "app/view/quantri/home.php";
	}
	function baiviet_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->baiviet_xoa($id);		
		header("location:". $_SERVER['HTTP_REFERER']);
	}
	function baiviet_daoanhien(){
		$id=$this->params[0]; settype($id, "int");
		echo $this->qt->baiviet_daoanhien($id);		
	}
	function baiviet_daonoibat(){
		$id=$this->params[0]; settype($id, "int");
		echo $this->qt->baiviet_daonoibat($id);		
	}
	function baiviet_dangbai(){
		$id=$this->params[0]; settype($id, "int");
		echo $this->qt->baiviet_dangbai($id);		
	}	
	function baiviet_loc(){ //phục vụ cho lọc bv ở cột trái trong trang baiviet_them, baviet_sua
		$idloai=$this->params[0]; settype($idloai, "int");
		$tukhoa=$this->params[1]; 
		$taglocbv = $this->params[2];
		$dsbaiviet = $this->qt->baiviet_loc($idloai, $tukhoa, $taglocbv);
		
		require_once "app/view/quantri/baiviet_loc.php";	
		
	}
	
	function loaibaiviet_list(){		
		require_once "app/view/quantri/home.php";
	}
	
	function loaibaiviet_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$kq = $this->qt->loaibaiviet_them();
			header('location:'. BASE_DIR.'quantri/loaibaiviet_list');
		}
	}
	function loaibaiviet_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$row = $this->qt->chitietloaibaiviet($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->loaibaiviet_sua($id);
			header('location:'. BASE_DIR.'quantri/loaibaiviet_list');
		}
	}
	function loaibaiviet_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$ten = $this->qt ->laytenloaibaiviet($id);
		$demloaicon = $this->qt->demloaicon($id);
		$dembaiviet = $this->qt->demsobaiviettrongloai($id);
		if ($demloaicon>0) {			
			$_SESSION['thongbao'] = "<h3 align=center>Loại $ten có $demloaicon loại con nên bạn không xóa được</h3>";
			$_SESSION['thongbao'] .= "<p align=center><a href=". $_SERVER['HTTP_REFERER'] . ">Về trang trước</a>";
		}else if ($dembaiviet>0) {
			$ten = $this->qt ->laytenloaibaiviet($id);
			$_SESSION['thongbao'] = "<h3 align=center>Loại $ten có $dembaiviet bài viết nên bạn không xóa được</h3>";
			$_SESSION['thongbao'] .= "<p align=center><a href=". $_SERVER['HTTP_REFERER'] . ">Về trang trước</a>";
		}else { 
			$this->qt->loaibaiviet_xoa($id);	
			$_SESSION['thongbao']= "<h3 align=center>Đã xóa loại bài viết $ten</h3>";
			$_SESSION['thongbao'] .= "<p align=center><a href=". $_SERVER['HTTP_REFERER'] . ">Về trang trước</a>";
		}
		require_once "app/view/quantri/home.php";
	}
	function tacgia_listdechon(){
		require_once "app/view/quantri/tacgia_listdechon.php";
	}
	function tag_list(){
		require_once "app/view/quantri/home.php";
	}
	function tag_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->tag_xoa($id);
		header('location:'. $_SERVER['HTTP_REFERER']);
	}
	function tag_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$_SESSION['backtag']=$_SERVER['HTTP_REFERER'];
			$row = $this->qt->chitiettag($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->tag_sua($id);
			if (isset($_SESSION['backtag'])==true){
				$backtag= $_SESSION['backtag'];
				unset($_SESSION['backtag']);
			}else $backtag= BASE_DIR. "quantri/tag_list";			
			header('location:'. $backtag);
		}
	}

	function box_list(){
		require_once "app/view/quantri/home.php";
	}
	function box_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->box_xoa($id);
		header('location:'. $_SERVER['HTTP_REFERER']);
	}
	function thongtin1box(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {		
			$row = $this->qt->chitietbox($id);
			echo json_encode($row,JSON_UNESCAPED_UNICODE);
		}else{
			$kq = $this->qt->box_luu();
			echo $kq;
		}		
	}
	function layboxlist(){
		require_once "app/view/quantri/box_listbox.php";
	}
	function youtubeplaylist_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$kq = $this->qt->youtubeplaylist_them();
			header('location:'. BASE_DIR.'quantri/youtubeplaylist_list');
		}
	}

    function video_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$kq = $this->qt->video_them();
			header('location:'. BASE_DIR.'quantri/video_list');
		}
	}
	function video_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$row = $this->qt->chitietvideo($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->video_sua($id);
			header('location:'. BASE_DIR.'quantri/video_list');
		}
	}
	function video_list(){		
		require_once "app/view/quantri/home.php";
	}
	function video_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->video_xoa($id);
		header('location:'. $_SERVER['HTTP_REFERER']);
	}

    function chudevideo_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$kq = $this->qt->chudevideo_them();
			header('location:'. BASE_DIR.'quantri/chudevideo_list');
		}
	}
	function chudevideo_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$row = $this->qt->chitietchudevideo($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->chudevideo_sua($id);
			header('location:'. BASE_DIR.'quantri/chudevideo_list');
		}
	}
	function chudevideo_list(){		
		require_once "app/view/quantri/home.php";
	}
	function chudevideo_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->chudevideo_xoa($id);
		header('location:'. $_SERVER['HTTP_REFERER']);
	}
	
	function media_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$kq = $this->qt->media_them();
			header('location:'. BASE_DIR.'quantri/media_list');
		}
	}
	function media_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$row = $this->qt->chitietmedia($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->media_sua($id);
			header('location:'. BASE_DIR.'quantri/media_list');
		}
	}
	function media_list(){		
		require_once "app/view/quantri/home.php";
	}
	function media_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->media_xoa($id);
		header('location:'. $_SERVER['HTTP_REFERER']);
	}
	
	function mediaplaylist_them(){
		ini_set('display_errors', 1); 
		error_reporting(E_ALL);
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$kq = $this->qt->mediaplaylist_them();
			header('location:'. BASE_DIR.'quantri/mediaplaylist_list');
		}
	}
	function mediaplaylist_sua(){
		ini_set('display_errors', 1); 
		error_reporting(E_ALL);
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$row = $this->qt->chitietmediaplaylist($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->mediaplaylist_sua($id);
			header('location:'. BASE_DIR.'quantri/mediaplaylist_list');
		}
	}
	function mediaplaylist_list(){		
		require_once "app/view/quantri/home.php";
	}
	function mediaplaylist_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->mediaplaylist_xoa($id);
		header('location:'. $_SERVER['HTTP_REFERER']);
	}

	function chudemedia_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$kq = $this->qt->chudemedia_them();
			header('location:'. BASE_DIR.'quantri/chudemedia_list');
		}
	}
	function chudemedia_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$row = $this->qt->chitietchudemedia($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->chudemedia_sua($id);
			header('location:'. BASE_DIR.'quantri/chudemedia_list');
		}
	}
	function chudemedia_list(){		
		require_once "app/view/quantri/home.php";
	}
	function chudemedia_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->chudemedia_xoa($id);
		header('location:'. $_SERVER['HTTP_REFERER']);
	}
		
	function album_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$kq = $this->qt->album_them();
			header('location:'. BASE_DIR.'quantri/album_list');			
		}
	}
	function album_list(){		
		require_once "app/view/quantri/home.php";
	}
	function album_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$row = $this->qt->chitietalbum($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->album_sua($id);
			header('location:'. BASE_DIR.'quantri/album_list');
		}
	}
	function album_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->album_xoa($id);		
		header('location:'. $_SERVER['HTTP_REFERER']);
	}
	
    function ykien_list(){		
		require_once "app/view/quantri/home.php";
	}
    function ykien_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->ykien_xoa($id);		
		header('location:'. $_SERVER['HTTP_REFERER']);
	}
	function ykien_daoanhien(){
		$id=$this->params[0]; settype($id, "int");
		echo $this->qt->ykien_daoanhien($id);		
	}
    function ykien_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {			
			$row = $this->qt->chitietykien($id);
			require_once "app/view/quantri/home.php";
		} else{			
			$kq = $this->qt->ykien_sua($id);
			header('location:'. BASE_DIR.'quantri/ykien_list');
		}
	}
    
    function tag_Autocomlete(){		
		$tag= $_GET['term'];
		echo $this->qt->tag_Autocomlete($tag);
	}
    function cauhinh(){
   	    if ($_POST ==NULL) {
   	        $cauhinh =$this->qt->cauhinh_layra();
            require_once "app/view/quantri/home.php";
   	    }else{
			$this->qt->cauhinh_luu();
			header('location:'. BASE_DIR.'quantri/');			
		}
    }
	function dangnhap(){
		if ($_POST ==NULL) {require_once "app/view/quantri/dangnhap.php";}
		else {
			$u = strip_tags($_POST['u']); $p = strip_tags($_POST['p']);	
			$kq = $this->qt->login($u, $p);
			if ($kq==1) {
				$_SESSION['error'] = "Username không tồn tại";
				header('location:'. BASE_DIR.'quantri/dangnhap');
			}
			elseif ($kq==2) {
				$_SESSION['error'] = "Mật khẩu không đúng";
				header('location:'. BASE_DIR.'quantri/dangnhap');
			}
			elseif ($kq==3){ //OK
				if (isset($_SESSION['back'])) {
					$b = $_SESSION['back']; unset($_SESSION['back']); header("location:$b"); 
				}
				else header('location:'. BASE_DIR.'quantri');
			}
			else {
				$_SESSION['error'] = "Lỗi đăng nhập";
				header('location:'. BASE_DIR.'quantri/dangnhap');
			}
		}
	}//dangnhap
	function thoat(){
		session_destroy();
		header('location:'.BASE_DIR.'quantri/dangnhap');
	}
	function changepass(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$loi=array();
			$kq = $this->qt->changepass($loi);
			if ($kq) {
				$_SESSION['thongbao']="<p>Đổi mật khẩu thành công</p>";
				$_SESSION['thongbao'].="<a href=" . BASE_DIR. "quantri/>Về trang chủ</a>";
				header('location:'. BASE_DIR.'quantri/thongbao/');
			}
			else require_once "app/view/quantri/home.php";
		}
	}
	function thongbao(){
		require_once "app/view/quantri/home.php";
	}
	function user_them(){
		if ($_POST ==NULL) require_once "app/view/quantri/home.php";
		else{
			$loi=array();
			$kq = $this->qt->user_them($loi);
			if ($kq) header('location:'. BASE_DIR.'quantri/user_list');
			else require_once "app/view/quantri/home.php";
		}
	}
	function user_sua(){
		$id= $this->params[0]; settype($id,"int");
		if ($_POST ==NULL) {						
			require_once "app/view/quantri/home.php";
		} else{			
			$loi=array();
			$kq = $this->qt->user_sua($id,$loi);
			if ($kq)header('location:'. BASE_DIR.'quantri/user_list');
			else require_once "app/view/quantri/home.php";
		}
	}
	function user_list(){		
		require_once "app/view/quantri/home.php";
	}
	function user_xoa(){
		$id=$this->params[0]; settype($id, "int");
		$this->qt->user_xoa($id);
		header('location:'. $_SERVER['HTTP_REFERER']);
	}
}//class
?>