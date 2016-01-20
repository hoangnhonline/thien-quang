<?php
class controller {
	public $model;
	public $params;
	public $current_action;
	
	public $alias="";
	public $titleofpage="";
	public $descriptionofpage="";
	function __construct($url){		
		$arr = explode("/", $url);   
		// phần tử 1 của $arr là rất quan trọng, nó có thể là 0.Tên controller 1. danhlam 2.video 3.album 4.tên loại 5.tiêu đề bài viết
		$what = $arr[INDEX_CNAME]; 		
		
		if ($what=="quantri") { $c = new quantri($url); return;	}			
		if ($what=="khiemthi") { $c = new khiemthi($url);	return;	}
		if (isset($_SESSION['login_level'])==false ||  $_SESSION['login_level']<3) exit();
		$this->model = new model();		
		$params=array(); for($i=INDEX_CNAME+1 ; $i<count($arr); $i++) $params[]=$arr[$i]; $this->params=$params; //dãy tham số phía sau
		
		if ($what==""){//nếu request không có gì sau domain thì là trang chủ
			$this->current_action=DEFAULT_ACTION; 
			$this->model->luuthongtin($this->current_action, $this->params);
			$this->titleofpage=TITLE_SITE;
			$this->descriptionofpage=SITE_DESCRIPTION;
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
		 
		switch ($what){			
			case "duc-phat-thich-ca.html": 	
				$this->current_action="ducphat";  
				$this->titleofpage="Lịch sử đức Phật Thích Ca Mâu Ni";				
				$this->ducphat(); return; break;
			case "lien-he-chua-thien-quang.html": 
				$this->current_action="lienhe";	
				$this->titleofpage=TITLE_SITE . " - Liên hệ ban quản trị";
				$this->descriptionofpage="Liên hệ ban quản trị website " . TITLE_SITE ;
				$this->lienhe(); return; break;
			case "duong-den-chua-thien-quang.html": 
				$this->current_action="bando";	
				$this->titleofpage="Đường đến ". TITLE_SITE;
				$this->descriptionofpage="Bản đồ để bạn xem đường đến chùa Thiên Quang. Bạn xem kỹ nhé, để tránh đi nhằm đường.";
				$this->bando(); return; break;
			case "nhac-phat-giao": 
				$this->current_action="media";  $this->params=array(2); 
				$this->titleofpage="Nhạc Phật giáo";
				$this->descriptionofpage="Nhạc Phật giáo là những bài hát mang nội dung, âm hưởng giáo lý Phật giáo. Giúp bạn vừa nghe nhạc giải trí vừa hiểu thêm về đạo đức, tâm lý, lịch sử, giáo lý Phật giáo...";
				$this->media(); return; break;
			case "sach-doc-phat-giao": 
				$this->current_action="media";	$this->params=array(7);	
				$this->titleofpage="Sách đọc Phật giáo";
				$this->descriptionofpage="Sách đọc Phật giáo là chuyên mục sưu tập nhiều sách, truyện Phật giáo đặc sắc do quý Phật tử đọc và ghi âm mp3. Kinh sách Phật giáo là một kho tàng kiền thức mênh mông về tâm lý, đạo đức, triết học về vũ trụ nhân sinh. Nghe đọc sách Phật giáo giúp bạn mở mang tri thức Phật học, tiết kiệm tiền mua sách ";
				$this->media(); return; break;
			case "tung-niem": 
				$this->current_action="media";	$this->params=array(3);	
				$this->titleofpage="Tụng kinh - Niệm Phật";
				$this->descriptionofpage="Tụng kinh là ôn lại lời Phật dạy để ứng dụng vào đời sống hàng ngày. Tụng kinh với giọng ngân nga trầm bổng để thêm trân trọng, dễ nhập tâm, có tiếng chuông, tiếng mõ để tâm trung tâm ý. Niệm Phật là nhớ nghĩ về đức Phật, về hạnh nguyện, đề đạo đức, về trí tuệ của Ngài đề chúng ta nương theo tu tập... ";
				$this->media(); return; break;
			case "kinh-doc": 
				$this->current_action="media";	
				$this->params=array(11);$this->titleofpage="Kinh đọc";
				$this->descriptionofpage="Kinh đọc là mục chuyển âm mp3 những lời Phật dạy. ";
				$this->media(); return; break;	
			case "ca-co-phat-giao": 
				$this->current_action="media";	$this->params=array(12);
				$this->titleofpage="Ca cổ Phật giáo";
				$this->descriptionofpage="Những bài ca cổ nhẹ nhàng, mang nội dung, âm hưởng Phật giáo. Do các ca sĩ Phật tử thể hiện.";
				$this->media(); return; break;	
			case "phim-phat-giao-viet-nam": 
				$this->current_action="videotrongchude"; $this->params=array("phim-phat-giao-viet-nam"); 
				$this->titleofpage="Phim Phật giáo Việt Nam";
				$this->descriptionofpage="Những phim truyện mang Phật giáo rất hay do các chùa, hãng phim trong nước thực hiện nhằm diễn bày những giáo lý Phật giáo, những sự nhiệm màu trong đạo Phật, những giá trị cao tột của Phật giáo đối với đời sống nhân sinh.";
				$this->videotrongchude(); return; break;	
			case "phim-phat-giao-nuoc-ngoai": 
				$this->current_action="videotrongchude";$this->params=array("phim-phat-giao-nuoc-ngoai");
				$this->titleofpage="Phim Phật giáo nước ngoài";
				$this->descriptionofpage="Những phim Phật giáo nước ngoài diễn bày giáo lý Phật giáo, những sự nhiệm màu trong đạo Phật, những đóng góp tích cực của Phật giáo trong đời sống tinh thần của con người.";
				$this->videotrongchude(); return; break;	
			case "phim-hoat-hinh-phat-giao": 
				$this->current_action="videotrongchude"; $this->params=array("phim-hoat-hinh-phat-giao");
				$this->titleofpage="Phim hoạt hình Phật giáo";
				$this->descriptionofpage="Những phim hoạt hình Phật giáo nói về giáo lý Phật giáo, đạo đức con người, lịch sử đức Phật... Không chỉ thích hợp cho trẻ em mà còn cho cả người lớn.";
				$this->videotrongchude(); return; break;	
			case "cai-luong-phat-giao": 
				$this->current_action="videotrongchude"; $this->params=array("cai-luong-phat-giao");
				$this->titleofpage="Cải lương Phật giáo";
				$this->descriptionofpage="Những tuồng cải lương Phật giáo, vừa giúp giải trí, vừa học hỏi thêm về Phật pháp";
				$this->videotrongchude(); return; break;	
			case "phim-phat-giao": 
				$this->current_action="videotrongcacchude"; 
				$this->params=array("phim-phat-giao-viet-nam","phim-phat-giao-nuoc-ngoai","phim-hoat-hinh-phat-giao");
				$this->titleofpage="Phim Phật giáo";
				$this->descriptionofpage="Phim Phật giáo gồm nhiều phim Phật giáo trong nước, ngoài nước, phim hoạt hình... rất hay. Nội dung nói về giáo lý Phật giáo như nhân-duyên-quả, nghiệp báo, luân hồi, vô thường... Nói về tâm lý, đạo đức làm người... Nói về lịch sử Phật giáo. Nói về những nhiệm màu trong đạo Phật...";
				$this->videotrongcacchude(); return; break;	
			case "nghe-phap-thoai": 
				$this->current_action="phapthoai"; 
				$this->params=array(); 
				$this->titleofpage="Nghe pháp thoại";
				$this->descriptionofpage="Nghe pháp thoại sư cô Hương Nhũ";
				$this->videotrongchude(); return; break;	
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
		require_once "app/view/home.php";
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
		require_once "app/view/home.php";
	}
	function lienhe(){ 		
		require_once "app/view/home.php";
	}
	function ducphat(){		
		$bai = $this->model->detail(IDBAIVIETDUCPHAT);		
		if ($bai!=null) $this->descriptionofpage=$bai['tomtat'];
		require_once "app/view/home.php";
	}
	function album_detail_chuadung(){
		require_once "app/view/home.php";
	}
	
    function chitietvideo_sebo(){
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
	function media(){
		require_once "app/view/home.php";  
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