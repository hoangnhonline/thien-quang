<?php
class controller {
	public $model;
	public $params;
	public $current_action;
	
	public $alias="";
	public $titleofpage="";
	function __construct($url){		
		$arr = explode("/", $url);   
		// phần tử 1 của $arr là rất quan trọng, nó có thể là 0.Tên controller 1. danhlam 2.video 3.album 4.tên loại 5.tiêu đề bài viết
		$what = $arr[INDEX_CNAME]; 		
		
		if ($what=="quantri") { $c = new quantri($url); return;	}			
		if ($what=="khiemthi") { $c = new khiemthi($url);	return;	}
		if (isset($_SESSION['login_level'])==false || $_SESSION['login_level']!=4) exit();
		$this->model = new model();		
		$params=array(); for($i=INDEX_CNAME+1 ; $i<count($arr); $i++) $params[]=$arr[$i]; $this->params=$params; //dãy tham số phía sau
		
		if ($what==""){//nếu request không có gì sau domain thì là trang chủ
			$this->current_action=DEFAULT_ACTION; 
			$this->model->luuthongtin($this->current_action, $this->params);
			$this ->tc(); 
			return;
		}		
		if (method_exists($this,$what)) {//nếu sau domain là tên 1 action, ví dụ như danhlam, video
			$this->current_action=$what; 
			if ( $this->current_action=="cat" || $this->current_action=="detail")  { //cấm khách request trực tiếp các action này , thêm tính bảo mật
				header('HTTP/1.0 403 Forbidden');
				die("Không xem trang này được");
			}
			$this->model->luuthongtin($this->current_action, $this->params);
			$this ->$what(); 						
			return;
		}
		
		//sau domain có thể là 1 tên đặc biệt như:gioi-thieu-chua-thien-quang_kt, lich-su-chua-thien-quang_kt
		 
		switch ($what){
			case "gioi-thieu-chua-thien-quang_kt.html": 
				$this->current_action="gioithieu_kt";  				
				$this->gioithieu_kt(); return;	break;
			case "lich-su-chua-thien-quang_kt.html": 
				$this->current_action="lichsu_kt"; 				
				$this->lichsu_kt(); return;	break;
			case "duc-phat-thich-ca_kt.html": 
				$this->current_action="ducphat_kt";				
				$this->ducphat_kt(); return; break;
			case "duc-phat-thich-ca.html": 
				$this->current_action="ducphat";				
				$this->ducphat(); return; break;
			case "lien-he-chua-thien-quang.html": 
				$this->current_action="lienhe";					
				$this->lienhe(); return; break;
			case "duong-den-chua-thien-quang.html": 
				$this->current_action="bando";					
				$this->bando(); return; break;
			case "nhac-phat-giao": 
				$this->current_action="media";		
				$this->params=array(2);
				$this->titleofpage="Nhạc Phật giáo";
				$this->media(); return; break;
			case "sach-doc-phat-giao": 
				$this->current_action="media";
				$this->params=array(7);
				$this->titleofpage="Sách đọc Phật giáo";
				$this->media(); return; break;
			case "tung-niem": 
				$this->current_action="media";
				$this->params=array(3);
				$this->titleofpage="Tụng kinh - Niệm Phật";
				$this->media(); return; break;
			case "kinh-doc": 
				$this->current_action="media";
				$this->params=array(11);
				$this->titleofpage="Kinh đọc";
				$this->media(); return; break;	
			case "ca-co-phat-giao": 
				$this->current_action="media";
				$this->params=array(12);
				$this->titleofpage="Ca cổ Phật giáo";
				$this->media(); return; break;	
				
			case "phim-phat-giao-viet-nam": 
				$this->current_action="videotrongchude";
				$this->params=array("phim-phat-giao-viet-nam");
				$this->titleofpage="Phim Phật giáo Việt Nam";
				$this->videotrongchude(); 
				return; break;	
			case "phim-phat-giao-nuoc-ngoai": 
				$this->current_action="videotrongchude";
				$this->params=array("phim-phat-giao-nuoc-ngoai");
				$this->titleofpage="Phim Phật giáo nước ngoài";
				$this->videotrongchude(); 
				return; break;	
			case "phim-hoat-hinh-phat-giao": 
				$this->current_action="videotrongchude";
				$this->params=array("phim-hoat-hinh-phat-giao");
				$this->titleofpage="Phim hoạt hình Phật giáo";
				$this->videotrongchude(); 
				return; break;	
			case "cai-luong-phat-giao": 
				$this->current_action="videotrongchude";
				$this->params=array("cai-luong-phat-giao");
				$this->titleofpage="Cải lương Phật giáo";
				$this->videotrongchude(); 
				return; break;	
			case "phim-phat-giao": 
				$this->current_action="videotrongcacchude"; 
				$this->params=array("phim-phat-giao-viet-nam","phim-phat-giao-nuoc-ngoai","phim-hoat-hinh-phat-giao");
				$this->titleofpage="Phim Phật giáo";
				$this->videotrongcacchude(); 
				return; break;	
		}
		
		//tới đây thì sau domain có thể là tên loại hoặc tiêu đề bài viết
		$idloai = $this->model->layidLoai($what); //lấy idloai tương ứng với what		
		if ($idloai>0) { //tên loại bài viết
			if ($params[0]=="" || $params[0]=="/" ){// đây là trang 1 của  1 loai bv
				$this->current_action="cat";  
				$this->params=array($idloai,$pageNum=1);
				$this->model->luuthongtin($this->current_action, $params);				
				$this->cat();
				return;
			}
			else {//đây là trang 2,3,4...  của 1 loai bv
				$pageNum= $params[0];  settype($pageNum,"int"); if ($pageNum<=0) $pageNum=1;
				$this->current_action="cat";  
				$this->params=array($idloai,$pageNum); 
				$this->model->luuthongtin($this->current_action, $params);
				$this->cat();
				return;
			}
		}		
		//tới đây thì sau domain có thể là tiêu đề bài viết
		$idbv= $this->model->layidbaiviet($what);
		if ($idbv>0) {
			$this->current_action="detail"; 
			$this->params=array($idbv);	
			$this->model->luuthongtin($this->current_action, $this->params);
			$this->detail();
			return;
		}
		
		
		//luồng xử lý đến đây nghĩa là có sự cố vớ vẩn gì đó
		echo "Chào mừng bạn đến với <a href='". BASE_URL."'>". TITLE_SITE ."</a>";
	}
	function tc(){
		$bainb = $this->model ->bainoibat(4);
		$cacloai = $this->model ->cacloai();
		$this->titleofpage=TITLE_SITE;
		require_once "app/view/home.php";
	}
	function khuyemthi_sebo(){
		$bainb = $this->model ->bainoibat(4);
		$cacloai = $this->model ->cacloai();
		$this->titleofpage=TITLE_SITE;
		require_once "app/view/khuyemthi.php";
	}
	function detail(){		
		$id= $this->params[0];
		settype($id,"int");
		if ($id<=0) return;
		$bai = $this->model->detail($id);
		require_once "app/view/home.php";
	}
	function cat(){				
		$idloai= $this->params[0];
		$currentpage= $this->params[1];
		settype($idloai,"int"); settype($currentpage,"int");
		if ($idloai<=0) return; if ($currentpage<=0) $currentpage=1;
		$per_page=PER_PAGE; $totalrows=0; 
        
		$start = ($currentpage-1)*$per_page;
		$loai = $this->model->lay1loaibv($idloai);
		
		$tenloai=$loai['tenloai'];
		$alias=$loai['alias'];
		$listbai = $this->model->baitrongloai($idloai,$per_page, $start,$totalrows);
		
		require_once "app/view/home.php";
	}
	function phapthoai(){
		require_once "app/view/home.php"; 
	}
	function bando(){ 
		$this->titleofpage="Đường đến ". TITLE_SITE;
		require_once "app/view/home.php";
	}
	function lienhe(){ 
		$this->titleofpage=TITLE_SITE . " - Liên hệ ban quản trị";
		require_once "app/view/home.php";
	}
	function lienhe_kt(){ 
		$this->titleofpage=TITLE_SITE . " - Liên hệ ban quản trị";
		require_once "app/view/khuyemthi.php";
	}
	function gioithieu(){
		$this->titleofpage="Giới thiệu website " . TITLE_SITE;
		require_once "app/view/home.php";
	}
	function gioithieu_kt(){
		$this->titleofpage="Giới thiệu " . TITLE_SITE;		
		$bai = $this->model->detail(IDBAIVIETGIOITHIEU);
		require_once "app/view/khuyemthi.php";
	}
	function lichsu_kt(){		
		$this->titleofpage="Lịch sử " . TITLE_SITE;
		$bai = $this->model->detail(IDBAIVIETLICHSUCHUA);
		require_once "app/view/khuyemthi.php";
	}
	function ducphat_kt(){
		$this->titleofpage="Lịch sử đức Phật Thích Ca Mâu Ni";
		$bai = $this->model->detail(IDBAIVIETDUCPHAT);
		require_once "app/view/khuyemthi.php";
	}
	function ducphat(){
		$this->titleofpage="Lịch sử đức Phật Thích Ca Mâu Ni";
		$bai = $this->model->detail(IDBAIVIETDUCPHAT);		
		require_once "app/view/home.php";
	}
	function album_detail(){
		require_once "app/view/home.php";
	}
	
    function chitietvideo(){
	    $idvideo= $this->params[0]; settype($idvideo,"int"); if ($idvideo<=0) return;
		$video = $this->model->chitietvideo($idvideo);		
		require_once "app/view/home.php";      
	}
	function playlist(){
		$idmediaplaylist= $this->params[0]; settype($idmediaplaylist,"int"); 
		if ($idmediaplaylist<=0) die(); 
		$chitietplaylist = $this->model->laychitietplaylist($idmediaplaylist);
		if (count($chitietplaylist)<=0) die();
		$this->titleofpage = $chitietplaylist['tenmediaplaylist'];		
		require_once "app/view/home.php";  
	}
	function playlist_1(){
		require_once "app/view/playlist_1.php";  
	}
	function media_kt(){
		require_once "app/view/khuyemthi.php";  
	}
	function media(){
		require_once "app/view/home.php";  
	}
	function detail_kt(){
		$alias= $this->params[0];		
		$idbv= $this->model->layidbaiviet($alias);
		if ($idbv<=0) die("Không biết bài bài để hiện cho bạn xem");		
		$this->params=array($idbv);	
		$this->model->luuthongtin("detail", $this->params);			
		$bai = $this->model->detail($idbv);
		require_once "app/view/khuyemthi.php";  
	}
	function kt_sebo(){ //giống action cat nhung cho nguoi khuyếm thị
		$alias= $this->params[0];
		$idloai = $this->model->layidLoai($alias); //lấy idloai tương ứng với alias		
		if ($idloai<=0)die("A Di Đà Phật! Không biết loại nào cần hiện");
		
		$currentpage= $this->params[1];	settype($currentpage,"int");
		if ($currentpage<=0) $currentpage=1;
		$per_page=PER_PAGE; $totalrows=0; 
        
		$start = ($currentpage-1)*$per_page;
		$listbai = $this->model->baitrongloai($idloai,$per_page, $start,$totalrows);
		$tenloai = $this->model->laytenloaibaiviet($idloai);
		require_once "app/view/khuyemthi.php"; 
	}
	function phapthoai_kt(){
		require_once "app/view/khuyemthi.php"; 
	}
	function phimphatgiao_kt(){
		require_once "app/view/khuyemthi.php"; 
	}
	function vkt(){ //giống action cat nhưng hiện list video cho người khuyếm thị
		$alias= $this->params[0];
		$chudevideo = $this->model->laychitietchudevideo($alias); //lấy idloai tương ứng với alias
		if ($chudevideo==false)die("A Di Đà Phật! Không biết chủ đề  nào cần hiện");
		$idloai=$chudevideo['idchudevideo'];
		
		$currentpage= $this->params[1];	settype($currentpage,"int");
		if ($currentpage<=0) $currentpage=1;
		$per_page=PER_PAGE; $totalrows=0; 
        
		$start = ($currentpage-1)*$per_page;		
		$listvideo = $this->model->videotrongchude($idloai,$per_page,$start, $totalrows );
		$tenchudevideo = $chudevideo['tenchudevideo'];
		require_once "app/view/khuyemthi.php"; 
	}
	function videotrongchude(){ //
		$alias= $this->params[0];
		$chudevideo = $this->model->laychitietchudevideo($alias); //lấy idloai tương ứng với alias
		if ($chudevideo==false)die("A Di Đà Phật! Không biết chủ đề  nào cần hiện");
		$idloai=$chudevideo['idchudevideo'];
		
		$currentpage= $this->params[1];	settype($currentpage,"int");
		if ($currentpage<=0) $currentpage=1;
		$per_page=PER_PAGE*5; $totalrows=0; 
        
		$start = ($currentpage-1)*$per_page;		
		$listvideo = $this->model->videotrongchude($idloai,$per_page,$start, $totalrows );
		$tenchudevideo = $chudevideo['tenchudevideo'];
		require_once "app/view/home.php"; 
	}
	function videotrongcacchude(){ //
		$array_alias= $this->params;		
		require_once "app/view/home.php"; 
	}
	function hitcounter(){
		//if (isset($_COOKIE['hitcounter'])==false) setcookie('hitcounter',1, 0, BASE_DIR);		
		$hitcounter= $this->model->hitcounter();
		$songuoionline = $this->model->demsonguoionline();			
		echo "Lượt truy cập: <span>". str_pad($hitcounter,5,"0",0). " </span>";
        echo "Đang online: <span>". str_pad($songuoionline,5,0,0)." </span>";            
	}
	
    function listykien(){			
		$idbv= $this->params[0]; settype($idbv,"int"); 
		$currentpage= $this->params[1];	settype($currentpage,"int");
		if ($idbv<=0) return; if ($currentpage<=0) $currentpage=1;
		$per_page=PER_PAGE; $totalrows=0; 
        
		$start = ($currentpage-1)*$per_page;
		$listyk = $this->model->listykien($idbv,$per_page, $start,$totalrows);
		require_once "app/view/listykien.php";
    }
	function luuykien(){
        if (isset($_POST['noidungyk'])){
            $error="";
            if ($_POST['cap']=="" || $_POST['cap']=="Nhập chữ trong hinh") $error="Bạn chưa nhập mã bảo vệ";            
            elseif ($_SESSION['captcha_code']!=$_POST['cap']) $error="Bạn nhập mã bảo vệ chưa chính xác";
            
            if ($error!="") echo $error; else echo $this->model->luuykien();			
		}
	}
	function guimail(){
		if (isset($_POST['bGuiMail'])) {
			$kq= $this->model->guimail();
			$_SESSION['mess']=$kq;
			header('location:'.BASE_URL.'mess');
		}
		else require_once "app/view/formguimail.php";
	}
	function mess(){
		session_start();
		echo $_SESSION['mess'];
	}
    function captcha(){        
        header('Content-type: image/png');
        header("Pragma: No-cache");
        header("Cache-Control:No-cache, Must-revalidate"); 
        $sokytu=5;  $w = 140;  $h = 40; 
        $size=20; $x=10; $y=35;  //toạ độ chữ
        $nghieng=5; $font = 'app/view/tahoma.ttf';
        
        $str1= rand(0,99);$str2= mt_rand(0,99); $str3= rand(0,99);      
        $str = substr($str1.$str2.$str3,0,5);         
        $_SESSION['captcha_code'] = $str; 
        
        $img = imagecreatetruecolor($w, $h); //tạo hình
        $nen = imagecolorallocate($img, 249, 210, 102); //tạo màu cần dùng
        $mauchu= imagecolorallocate($img, 255, 0, 255);
        $vien = ImageColorAllocate($img, 127, 127, 127);
        
        imagefilledrectangle($img, 0, 0, $w-1, $h-1, $nen);        
        imagettftext($img, $size, $nghieng=30, $x=10, $y=35, $mauchu, $font, $str[0]);
        imagettftext($img, $size, $nghieng=45, $x=35, $y=25, $mauchu, $font, $str[1]);
        imagettftext($img, $size, $nghieng=-30, $x=50, $y=20, $mauchu, $font, $str[2]);
        imagettftext($img, $size, $nghieng=30, $x=90, $y=35, $mauchu, $font, $str[3]);
        imagettftext($img, $size, $nghieng=20, $x=120, $y=30, $mauchu, $font, $str[4]);
        imagepng($img);imagedestroy($img);
    }
    
}//class
?>