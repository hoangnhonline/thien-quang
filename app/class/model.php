<?php
class model{
	public $db;
	public function __construct(){
		$this->db= new mysqli(HOST, USER_DB, PASS_DB, DB_NAME);	
		$this->db->set_charset("utf8");
	}	
	function bodaunhay($str){
		if ($str=="") return "";
		$str = trim(strip_tags($str));
		$str=str_replace(  array("'",'"') , "" , $str);
		$str = htmlentities($str, ENT_QUOTES, 'utf-8');
		return $str;
	}
	function layidLoai($str){ //lấy idloai
		$str = $this->bodaunhay($str);
		$sql="select idloai from loaibaiviet where alias='$str'";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		if ($kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0];		
		} 
		else return 0;		
	}
	function layidbaiviet($str){ //ví dụ: str=bo-thi.HTML , dùng trong hàm construct của controller
		$str = $this->bodaunhay($str);
		$str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
		$str=basename($str,ARTICLE_SUFFIX); //GỠ BỎ .HTML Ở CUỐI
		$sql="select idbv from baiviet where alias='$str'";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		if ($kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0];		
		} 
		else return 0;
	}
	public function bainoibat($sobai=5){
		$sql="SELECT idbv, tieude, urlhinh, ngay, tomtat, idtacgia ,baiviet.alias as aliasBV,loaibaiviet.alias as aliasLoai  
              FROM baiviet , loaibaiviet 
              WHERE  baiviet.idloai =loaibaiviet.idloai AND loaibaiviet.aiduocxem=0 AND baiviet.noibat=1 
              ORDER BY idbv DESC LIMIT 0, $sobai";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data = array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;		
		return $data;
	}
	public function baixemnhieu_sebo($sobai=5){
		$sql="SELECT idbv, tieude, urlhinh, ngay, tomtat, idtacgia,baiviet.alias as aliasBV,loaibaiviet.alias as aliasLoai 
            FROM baiviet , loaibaiviet 
			WHERE baiviet.idloai =loaibaiviet.idloai AND loaibaiviet.aiduocxem=0 AND baiviet.anhien=1 
            ORDER BY solanxem DESC LIMIT 0, $sobai";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	public function baimoi($sobai=5){
		$sql="SELECT idbv, tieude, urlhinh, ngay, tomtat, baiviet.alias as alias
              FROM baiviet, loaibaiviet 
			  WHERE baiviet.idloai =loaibaiviet.idloai AND loaibaiviet.aiduocxem=0 AND baiviet.anhien=1
              ORDER BY ngay DESC, idbv DESC LIMIT 0, $sobai";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	
	public function baitieptheo($idbv, $sobai=5){
		$sql="SELECT idbv, tieude, urlhinh, tomtat, alias 
			FROM baiviet
			WHERE anhien=1 AND idloai=(select idloai from baiviet where idbv=$idbv) 
            AND ngay<(select ngay from baiviet where idbv=$idbv)
			ORDER BY ngay DESC LIMIT 0, $sobai";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	function baingaunhien_sebo($sobai =10){
		$sql="SELECT idbv, tieude, urlhinh, tomtat, idtacgia ,baiviet.alias as aliasBV,loaibaiviet.alias as aliasLoai 
              FROM baiviet , loaibaiviet
              WHERE  baiviet.idloai =loaibaiviet.idloai AND loaibaiviet.aiduocxem=0 AND baiviet.anhien=1 AND baiviet.urlhinh<>'' 
			  ORDER BY rand() LIMIT 0, $sobai";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	public function baitrongloai($idloai,$per_page=5, $startrow=0, &$totalrows){	
		$sql="SELECT idbv, tieude, urlhinh, tomtat,ngay, solanxem ,alias
			FROM baiviet
			WHERE idloai=$idloai AND anhien=1 
			ORDER BY ngay DESC, idbv DESC LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) FROM baiviet WHERE idloai=$idloai AND anhien=1";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
				
		return $data;
	}
	public function baimoitrongloai($idloai,$sobai=5){
		$sql="SELECT idbv, tieude, tomtat, urlhinh, ngay, solanxem,baiviet.alias as alias
			  FROM baiviet  , loaibaiviet
			  WHERE baiviet.anhien=1 AND baiviet.idloai =loaibaiviet.idloai AND baiviet.idloai IN (SELECT idloai FROM loaibaiviet WHERE  idloai=$idloai OR idcha=$idloai )
			  ORDER BY ngay DESC, idbv desc LIMIT 0,$sobai";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	function laytennguoidang_sebo($id){
		settype($id,"int");
		$sql="SELECT hoten FROM users WHERE iduser=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if ($kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0];		
		} else return "";
	}
    function laytentacgiabv_sebo($id){
        if ($id==0) return "";
        $sql="SELECT tieude, tentacgia FROM tacgia WHERE idtacgia=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if ($kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0] . " ". $row[1];		
		} else return "";
        
    }
    function lay1loaibv($id){
		settype($id,"int");
		$sql="SELECT *  FROM loaibaiviet WHERE idloai=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if ($kq->num_rows>0) {$row = $kq->fetch_assoc(); return $row;}		
        else return false;
	}
   
	function laytenloaibaiviet($id){
		settype($id,"int");
		$sql="SELECT tenloai FROM loaibaiviet WHERE idloai=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if ($kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0];		
		} else return "Không có";
	}
	public function detail($id){
		settype($id,"int");
		
		$sql="UPDATE baiviet SET solanxem=solanxem+1 WHERE idbv=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		
		$sql="SELECT baiviet.*, hientieudeodetail, hientomtatodetail,hienngayodetail,hiensolanxemodetail, baiviet.alias as aliasBV, loaibaiviet.alias as aliasLoai 
			  FROM baiviet, loaibaiviet 
			  WHERE baiviet.idloai=loaibaiviet.idloai AND idbv=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;		
		return $data;		
	}
	public function cacloai($idcha=-1){
		$sql="SELECT idloai, tenloai,alias,mota FROM loaibaiviet WHERE anhien=1 AND aiduocxem=0 AND (idcha=$idcha or $idcha=-1) ORDER BY thutu";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}
    function layalbum_anhdep_sebo(){
        $sql ="select idobj from cauhinh where id=4";
        $kq = $this->db->query($sql);
        if ($kq ) $row=$kq->fetch_row();
        if ($row) $idalbum=$row[0]; else $idalbum=-1; settype($idalbum,"int");
        $album= $this->layalbum($idalbum);
        return $album;
    }
    function lienketwebsite_sebo($solink=10){
		$sql ="select idobj from cauhinh where id=11";//xem table cấu hình với id=11
        $kq = $this->db->query($sql);
        if ($kq ) $row=$kq->fetch_row();
        if ($row) $idloai=$row[0]; else $idloai=-1; settype($idloai,"int");
        $sql="select tieude, content from baiviet where idloai=$idloai and anhien=1 order by ngay desc LIMIT 0,$solink";
		$kq = $this->db->query($sql);        
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data; 
	}
	function demvideocuatacgia($idtacgia){
		$sql="select count(*) from video where idtacgia=$idtacgia";
		if(!$kq = $this->db->query($sql)) die( $this->db->error); 
		$row = $kq->fetch_row();
		return $row[0];
	}
	function playlisttheochude($idchudemedia,$per_page, $start,&$totalrows){
		$sql="select * from mediaplaylist where idchudemedia=$idchudemedia or $idchudemedia=-1			  
			  order by thutu asc , tenmediaplaylist asc
			  LIMIT $start, $per_page ";
		if(!$kq = $this->db->query($sql)) die( $this->db->error); 
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
				
		$sql="SELECT count(*) from mediaplaylist where idchudemedia=$idchudemedia or $idchudemedia=-1";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];				
		return $data; 
	}
	function listtacgiavideotheochude_sebo($idchudevideo,$per_page, $start,&$totalrows){
		$sql="select idtacgia, tieude, tentacgia 
			  from tacgia
			  where idtacgia in (select idtacgia from video where idchudevideo=$idchudevideo)			  
			  order by thutu asc , tieude asc, tentacgia asc
			  LIMIT $start, $per_page ";
		if(!$kq = $this->db->query($sql)) die( $this->db->error); 
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
				
		$sql="SELECT count(*)
			  from tacgia
			  where idtacgia in (select idtacgia from video where idchudevideo=$idchudevideo)";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
		
		return $data; 
	}


	function layloivangngoc_sebo(){
        $sql ="select idobj from cauhinh where id=1";//xem table cấu hình với id=1
        $kq = $this->db->query($sql);
        if ($kq ) $row=$kq->fetch_row();
        if ($row) $idloai=$row[0]; else $idloai=-1; settype($idloai,"int");
        //$sql ="select * from baiviet where idloai=$idloai order by RAND() LIMIT 0,1 ";
        $sql ="select * from baiviet where idbv=76";
        $kq = $this->db->query($sql);        
		if ($kq->num_rows<=0) return "";
		$row = $kq->fetch_assoc();
		return $row; 
    }
	 function laylienketwebsite_sebo(){
        $sql ="select idobj from cauhinh where id=13";//xem table cấu hình với id=13
        $kq = $this->db->query($sql);
        if ($kq ) $row=$kq->fetch_row();
        if ($row) $idbv=$row[0]; else $idbv=-1; settype($idbv,"int");
        $sql ="select tieude,content from baiviet where anhien=1 and idbv=$idbv";
        $kq = $this->db->query($sql);        
		if ($kq->num_rows>0) {
			$row = $kq->fetch_assoc();
			return $row; 
		} else return false;
    }
	
	function layplaylist($idmediaplaylist, $numrows=5){
        $sql ="select * from media 
                where anhien=1 and idmediaplaylist=$idmediaplaylist 
				ORDER BY thutu ASC,tenmedia ASC limit 0,$numrows";
        $kq = $this->db->query($sql);        
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data; 
    }
	function laylistnamcuaphapthoai(){
		$sql ="select year(ngaygiang) as nam from video 
                where anhien=1 and idtacgia=5				
				GROUP BY year(ngaygiang) DESC 
				HAVING nam>1970
				limit 0,10"; //5 là idtagia sc huong nhu
        $kq = $this->db->query($sql);        
		$data=array();		
		while ($row = $kq->fetch_assoc()) if ($row['nam']>2000)$data[]=$row['nam'];
		
		return $data; 
	}
	function laychitietplaylist($idmediaplaylist){
		settype($idmediaplaylist,"int");
		$sql ="select * from mediaplaylist where anhien=1 and idmediaplaylist=$idmediaplaylist 
				ORDER BY thutu ASC,tenmediaplaylist ASC";
        if(!$kq = $this->db->query($sql)) die( $this->db->error);	     
		if (count($kq)<=0) return; 
		return $kq->fetch_assoc();
	}
	function laymediatrongplaylist($idmediaplaylist){
		$sql ="select * from media where anhien=1 and idmediaplaylist=$idmediaplaylist ORDER BY thutu ASC,tenmedia ASC";
        $kq = $this->db->query($sql);        
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data; 
	}
	function layalbum($id){
		settype($id, "int");
		$sql="SELECT * FROM album  WHERE idalbum = $id";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$row = $kq->fetch_assoc();
		return $row;
	}
    function listchudevideo(){
        $sql="SELECT * FROM chudevideo WHERE anhien=1 ORDER BY thutu ASC";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;        
    }
	public function videotrongchude_sebo($idchudevideo,$per_page=5, $startrow=0, &$totalrows){	
		$sql="SELECT * FROM video WHERE idchudevideo=$idchudevideo AND anhien=1 
			ORDER BY ngay idvideo DESC LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) FROM video WHERE idchudevideo=$idchudevideo AND anhien=1";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
				
		return $data;
	}
	function laychitietchudevideo($alias){
        $sql="SELECT * FROM chudevideo WHERE anhien=1 and alias='$alias'";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);		
		if ($kq->num_rows<=0 ) return false;
		$row = $kq->fetch_assoc();
		return $row;        
    }
	function listchudemedia(){
		$sql="SELECT * FROM chudemedia WHERE anhien=1 ORDER BY thutu ASC, tenchudemedia ASC";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;        
	}
	function listvideotheotacgia($idtacgia,$per_page=5, $startrow=0, &$totalrows){
		$sql="SELECT * FROM video WHERE idtacgia=$idtacgia AND anhien=1 
			  ORDER BY ngaygiang DESC LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) FROM video WHERE idtacgia=$idtacgia AND anhien=1";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
				
		return $data;
	}
    public function videotrongnam($loaichude,$nam,$per_page=5, $startrow=0, &$totalrows){
		$sql="	SELECT * FROM video
				WHERE year(ngaygiang)=$nam AND anhien=1 AND idchudevideo in (select idchudevideo from chudevideo where loai='$loaichude' or '$loaichude'='')
				ORDER BY ngay DESC LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) FROM video WHERE year(ngaygiang)=$nam AND anhien=1 AND idchudevideo in (select idchudevideo from chudevideo where loai='$loaichude' or '$loaichude'='')";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
				
		return $data;
	}
	
	public function videotrongloaichude($loaichude,$per_page=5, $startrow=0, &$totalrows){
		$sql="	SELECT * FROM video
				WHERE anhien=1 AND idchudevideo in (select idchudevideo from chudevideo where loai='$loaichude')
				ORDER BY tenvideo ASC LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) FROM video WHERE anhien=1 AND idchudevideo in (select idchudevideo from chudevideo where loai='$loaichude')";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
				
		return $data;
	}
	public function videotrongchude($idchude,$per_page=5, $startrow=0, &$totalrows){
		$sql="SELECT * FROM video WHERE idchudevideo=$idchude AND anhien=1 
			  ORDER BY ngay DESC LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) FROM video WHERE idchudevideo=$idchude AND anhien=1";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
				
		return $data;
	}
    public function chitietvideo_sebo($id){
		settype($id,"int");		
		$sql="UPDATE video SET solanxem=solanxem+1 WHERE idvideo=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		
		$sql="SELECT * FROM video WHERE idvideo=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;		
        return $data;		
	}
    function laytenchudevideo($idchude){
    	settype($idchude,"int");
		$sql="SELECT tenchudevideo FROM chudevideo WHERE idchudevideo=". $idchude;
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if ($kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];} else return "&nbsp;";    
    }
	function laytenchudemedia($idchude){
    	settype($idchude,"int");
		$sql="SELECT tenchudemedia FROM chudemedia WHERE idchudemedia=". $idchude;
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if ($kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];} else return "&nbsp;";    
    }
    function laytentacgia($id){
        if ($id==0) return "";
        $sql="SELECT tieude, tentacgia FROM tacgia WHERE idtacgia=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if ($kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0] . " ". $row[1];		
		} else return "";
        
    }
    function listalbum($per_page, $start,&$totalrows) {
        $sql="SELECT * FROM album WHERE AnHien=1 ORDER BY ThuTu ASC LIMIT $start, $per_page";		  
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) FROM album WHERE AnHien=1";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];
		
		return $data;		
    }
	function album_cotphai($soalbum){
		$sql="SELECT * FROM album WHERE AnHien=1 ORDER BY ThuTu ASC LIMIT 0,$soalbum";		  
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}
    function laycauhinh_text($id){
        $sql ="select idobj from cauhinh where id=$id";
        $kq = $this->db->query($sql);
        if ($kq ) $row=$kq->fetch_row();
        if ($row) $idbv=$row[0]; else $idbv=-1; settype($idbv,"int");
        $bv= $this->detail($idbv);
        if ($bv['tomtat']!="") {
            $str = str_replace("\r\n","</p><p>",$bv['tomtat']);
            $str="<p>". $str . "</p>";
            return $str;
        }
        else  return $bv['content'];        
    }
	function getDescription($action,$p){
	 $default=SITE_DESCRIPTION;       
       if ($action=="detail") {
            $idbv = $p; settype($idbv,"int");
            $row = $this->detail($idbv); 
            if ($row) return $row['tomtat']; else return $default;
       } 
	   else if ($action=="cat") {
    	   $idloai=$p; settype($idloai,"int");
           $kq = $this->lay1loaibv($idloai);
		   if (!$kq)return $default;
           $mota = $kq['mota']; 
		   if (trim($mota)=="") return $default; 
		   else return $mota;
	   }	   
	   else return $default;
	}
    function getTitle($action,$p){
	   $default=TITLE_SITE;
	   switch ($action) {
	   case "detail": 
			$idbv = $p; settype($idbv,"int"); $row = $this->detail($idbv); 
            if ($row) return $row['tieude']; else return $default;
			break; 
	   case "cat": 
			$idloai=$p; settype($idloai,"int"); $kq = $this->laytenloaibaiviet($idloai);
			if ($kq) return $kq; else return $default; 		     	
			break;            			    		
		default: return $default;			
	   }//switch
    }
	function pageslist($baseurl, $totalrows, $offset,$per_page, $currentpage){
		$totalpages = ceil($totalrows/$per_page);
		if ($totalpages<=1) return "";
		$from = $currentpage-$offset;
		$to = $currentpage +$offset;
		if ($from<=0) $from=1;
		if ($to>$totalpages) $to=$totalpages;
		$links="<a href='{$baseurl}/' title='Trang đầu'>Đ</a>";
		for ($j=$from; $j<=$to; $j++) {
			if ($j==$currentpage) $links = $links . "<span>$j</span>"; 
			else 
				if ($j==1) $links = $links . "<a href = '$baseurl/'>$j</a>"; 	
				else $links = $links . "<a href = '$baseurl/$j/'>$j</a>"; 	
		}
        $links = $links . "<a href = '$baseurl/$totalpages/' title='Trang cuối'>C</a>";
		return $links;
	}
	function luuykien(){
		$hoten =trim(strip_tags($_POST['hoten'])); if ($hoten=="Họ tên của bạn") $hoten="";
		$email= trim(strip_tags($_POST['email'])); if ($email=="Email") $email="";
		$noidung = trim(strip_tags($_POST['noidungyk']));
        $idbv = $_POST['idbv']; settype($idbv,"int");
        $loi="";
        if ($hoten=="") return "Bạn chưa nhập họ tên";
        elseif (strlen($noidung)<=20) return "Bạn cần nhập nội dung dài hơn";
        else if ($idbv<=0) return "Bài viết ???";
        else if ($email!="" && filter_var($email,FILTER_VALIDATE_EMAIL)==false) return "Email không đúng";
        
        //lấy trạng thái ẩn hiện của ? kiến trong cấu h?nh
        $sql ="select idobj from cauhinh where id=10";
        $kq = $this->db->query($sql);
        if ($kq ) $row=$kq->fetch_row();
        if ($row) $anhien=$row[0]; else $anhien=0; settype($anhien,"int");
        
        
        $sql= "INSERT INTO bandocykien SET hoten=?, noidung=?, email=?,idbv=?,anhien=?, ngay=now()";
		
        $st = $this->db->prepare($sql);
		$st->bind_param('sssii',$this->db->real_escape_string($hoten), 
                                $this->db->real_escape_string($noidung),
                                $this->db->real_escape_string($email),$idbv,$anhien); 
		$st->execute();
        return "OK";
	}
    public function listykien($idbv,$per_page, $start,&$totalrows){
		$sql="SELECT *  FROM bandocykien WHERE  anhien=1 AND idbv=$idbv 
              ORDER BY ngay DESC, idykien DESC LIMIT $start, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data = array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
        
        $sql="SELECT count(*) FROM bandocykien WHERE  anhien=1 AND idbv=$idbv";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
        $row = $kq->fetch_row();
        $totalrows = $row[0];
		return $data;
	}
	function laylistbox_sebo($idpage, $idvitri){
		settype($idpage,"int"); settype($idvitri,"int");
		$sql="select box.*, boxinpage.thutu from boxinpage,box where boxinpage.idbox=box.idbox 
			  and  idpage = $idpage and idvitri = $idvitri order by boxinpage.thutu";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data = array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	function laychitiet1box_sebo($idbox){
		settype($idbox,"int"); 
		$sql="select * from box where idbox=$idbox";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);		
		return $kq->fetch_assoc();
	}
	function laybaitrongbox_sebo($loaibox,$listid, $sobai, $noibat, $sapxep){
		settype($loaibox,"int"); settype($sobai,"int");
		$where="WHERE anhien=1 ";
		if ($noibat==1) $where .= " AND noibat=1";
		elseif ($noibat==2) $where .= " AND noibat=0";
		if ($loaibox==1) $where .= " AND idloai in ($listid)"; //listid là id các loại		
		else if ($loaibox==2) $where .= " AND idbv in ($listid)";  //listid là idbv		
		else if ($loaibox==3) $where .= " AND idbv in (select idbv from baiviet_tag where idtag in ($listid) )"; //listid là idtag
		
		$orderby="";
		if ($sapxep==1) $orderby="ORDER BY ngay ASC";
		elseif ($sapxep==2) $orderby="ORDER BY ngay DESC";
		elseif ($sapxep==3) $orderby="ORDER BY solanxem ASC";
		elseif ($sapxep==4) $orderby="ORDER BY solanxem DESC";
		
		$limit="";if ($sobai>0) $limit =" LIMIT 0, $sobai"; 
		
		$sql="select tieude, tomtat, urlhinh, solanxem, ngay, alias as aliasBV from baiviet $where $orderby $limit";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data = array();
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	function guimail()	{
		
		$tennguoigui = trim(strip_tags($_POST['tennguoigui']));
		$to_email = trim(strip_tags($_POST['emailnhan']));
		$from_email = trim(strip_tags($_POST['emailgui']));
		$noidung = $_POST['noidung'];
		$noidung = str_replace("\r\n", "<br/>", $noidung);
		$tieude = trim(strip_tags($_POST['tieude']));
		
		$username = 'longnv.joomla@gmail.com';// Tài khoản gmail dùng để gửi thư
		$password = 'nnmmaaddddpp'; // mật khẩu của tài khoản gửi mail

	    require_once 'PHPMailerAutoload.php';		
		$mail = new PHPMailer(); //Create a new PHPMailer instance		
		$mail->isSMTP(); //Tell PHPMailer to use SMTP
		$mail->SMTPDebug = 0;  // 0 = off (for production use), 1 = client messages, 2 = client and server messages
		$mail->Debugoutput = 'html';
		$mail->CharSet = 'UTF-8';		
		$mail->ContentType = 'text/html; charset=utf-8\r\n';
		$mail->Host = "smtp.gmail.com"; //Set the hostname of the mail server		
		$mail->Port = 465;//Set the SMTP port number - likely to be 25, 465 or 587		
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth = true; //Whether to use SMTP authentication		
		$mail->Username = $username; //Username to use for SMTP authentication		
		$mail->Password = $password; //Password to use for SMTP authentication		
		$mail->setFrom($from_email, $tennguoigui); //Set who the message is to be sent from		
		//$mail->addReplyTo('replyto@example.com', 'First Last'); //Set an alternative reply-to address		
		//$mail->addAddress($to_email, 'John Doe'); //Set who the message is to be sent to
		$mail->addAddress($to_email); //Set who the message is to be sent to
		$mail->Subject = $tieude;
		$mail->msgHTML($noidung);

		//print_r($_FILES['f']);
		$name_arr = $_FILES['f']["name"];  		//print_r($name_arr);
		$tmpname_arr = $_FILES['f']['tmp_name']; //print_r($tmpname_arr);
		$size_arr = $_FILES['f']['size']; //print_r($size_arr);
		
		for($i=0; $i<count($name_arr);$i++) {		
			$tmp_name=$tmpname_arr[$i];  
			$name=$name_arr[$i]; 	
			$size=$size_arr[$i];
			if ($size<=0) continue;
			$mail->addAttachment($tmp_name,$name);
			move_uploaded_file($tmp_name, "../upload/". $name);
		}
		if (!$mail->send()) return "Lỗi: " . $mail->ErrorInfo;
		else return "Đã gửi mail";


	} //function guimail
	function luuThongtin($action, $params){
		$idloai=0;
		if ($action=="cat") $idloai=$params[0]; 
		elseif($action=="detail") {
			$idbv = $params[0]; settype($idbv,"int");
			$row = $this->detail($idbv); if ($row) $idloai = $row['idloai'];
		}
		settype($idloai,"int");
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$userAgent = $this->db->escape_string($_SERVER['HTTP_USER_AGENT']);
		$username=(isset($_SESSION['login_user'])==true)? $_SESSION['login_user']:"";
		$idSession = session_id();
		$sql = "SELECT idSession FROM sessions WHERE idSession='$idSession'";
		if(!$ses = $this->db->query($sql) ) die ($this->db->error);
			
		if ($ses->num_rows>0 ){ // người này có rồi, giờ request lại 
		$sql="UPDATE sessions SET lastVisit = unix_timestamp(), idloai=$idloai, 
				  username = '$username'	WHERE idSession='$idSession'";
			$this->db->query($sql) or die($this->db->error." : " . $sql);
		} else { //người này chưa có, mới vào lần đầu
			$sql="INSERT INTO sessions SET idSession = '$idSession', 
				userAgent = '$userAgent', lastVisit = unix_timestamp(),	
				session_start = unix_timestamp(),username = '$username',
				ipAddress = '$ipAddress', idloai = $idloai";
			$this->db->query($sql) or die($this->db->error);
		}
		$sessionTime = 15; //thời gian lưu thông tin 
		$sql="DELETE FROM sessions WHERE unix_timestamp()-lastVisit >=$sessionTime*60";
		$this->db->query($sql) or die($this->db->error);
	}//luuthongtin
	function DemSoNguoiXem($idloai){
	  $sql="select count(*) from sessions where idloai=$idloai 
			or idloai in (select idloai from loaibaiviet where idcha=$idloai)";
	  $rs=$this->db->query($sql) or die($this ->db->error);
	  $row= $rs->fetch_row();  $songuoi=$row[0];
	  return $songuoi;
	}
	function hitcounter(){
		//if (isset($_COOKIE['hitcounter'])==false){
		$sql="UPDATE thongke SET hitcounter=hitcounter+1";
		$this->db->query($sql) or die($this ->db->error);
		//}
		$sql="select hitcounter from thongke"; 
		$rs=$this->db->query($sql) or die($this ->db->error);
		$row= $rs->fetch_row();  $count=$row[0];
		return $count;
	}
    function demsonguoionline(){   
        $sql="SELECT count(*) FROM sessions";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];} else return 0;
    }
	
	function ThayTheCodeDacBiet($str){
		$str = $this->ChenCodeBanDo($str);
		$str = $this->ChenCodeYoutube($str);		
		$str = $this->ChenCodeMedia($str);
		$str = $this->ChenCodeMp3($str);
		$str = $this->ChenCodePlaylist($str);
		$str = $this->ChenCodeSliceShow1($str);
		return $str;
	}
	function ChenCodePlaylist($str){
		$pattern="#{playlist}(.*){/playlist}#i"; // {playlist}2{/playlist}
		preg_match($pattern, $str,$m); 
		if (count($m)==0) return $str;
		$idmediaplaylist = $m[1]; //2
		settype($idmediaplaylist,"int");
		if ($idmediaplaylist<=0) return $str;
		$sql="select url from media where idmediaplaylist=$idmediaplaylist";
		$rs=$this->db->query($sql) or die($this ->db->error);
		if ($rs->num_rows<=0) return $str;
		
		$media = $this->laymediatrongplaylist($idmediaplaylist);
		ob_start();
		include "app/view/playlist-nhungvaonoidungbaiviet.php";
		$codeplaylist= ob_get_clean();
		$str = preg_replace($pattern, $codeplaylist, $str);		
		return $str;
	}
	function ChenCodeMedia($str){
		$pattern="#{media}(.*){/media}#i"; // {media}2{/media}
		preg_match($pattern, $str,$m); 
		if (count($m)==0) return $str;
		$idmedia = $m[1]; //2
		settype($idmedia,"int");
		if ($idmedia<=0) return $str;
		$sql="select url from media where idmedia=$idmedia";
		$rs=$this->db->query($sql) or die($this ->db->error);
		if ($rs->num_rows<=0) return $str;
		$row= $rs->fetch_row();  
		$url=$row[0];
		$url=str_replace("&nbsp;"," ",$url);
		$url=trim($url);
		if (substr($url,0,1)=="/") $url = "http://".$_SERVER['SERVER_NAME']. $url;
		else if (substr($url,0,7)=="http://") $url = $url;
		else $url = BASE_URL. $url;
		
		$codemedia="		
		<audio id='mp3player_{$idmedia}' preload='auto' controls type='audio/mpeg'	src='{$url}'> 
		Your browser does not support HTML5 audio.
		</audio>";
		$str = preg_replace($pattern, $codemedia, $str);		
		return $str ;
	}
	function ChenCodeMP3($str){
		$pattern="#{mp3}(.*){/mp3}#i"; // {mp3}http://trinh-cong-son.com/nhac/CatBui_sc.mp3{/mp3}
		preg_match_all($pattern, $str,$arr); //echo "<pre>";print_r($arr); echo "</pre>";		
		if (count($arr)==0) return $str;

		$arr_code = $arr[0];
		$arr_url = $arr[1];
		for($i=0; $i<count($arr_code) ; $i++){
			$code = $arr_code[$i]; //{mp3}/mp3/NhacPhatGiao/AnNghiaSinhThanh1/BaiThoDangCha.mp3{/mp3}			
			$url = $arr_url[$i];
			$url=str_replace("&nbsp;"," ",$url); $url=trim($url);
			if ($url=="") continue;
			if (substr($url,0,1)=="/") $url = "http://".$_SERVER['SERVER_NAME']. $url;
			else if (substr($url,0,7)=="http://") $url = $url;
			else $url = BASE_URL. $url;
			$rand = rand(0,9999);
			$codeaudio="		
			<audio id='mp3player_{$rand}' preload='auto' controls type='audio/mpeg'	src='{$url}'> 
			Your browser does not support HTML5 audio.
			</audio>";
			$str = preg_replace("#{$code}#", $codeaudio, $str);		
		}	
		return $str;
	}
	function ChenCodeSliceShow1($str){
		$pattern="#{slideshow1}(.*){/slideshow1}#i"; // {slideshow1}upload/images/NTHuynhLien|400|200|aa{/slideshow1}
		preg_match($pattern, $str,$m); //echo "<pre>";print_r($m);
		if (count($m)==0) return $str;
		$ss = $m[1]; //upload/images/NTHuynhLien|400|200|aa
		if ($ss=="") return $str;
		$a = explode("|",$ss);
		if (count($a)==0) return $str;
		$folder=trim($a[0]); $w=trim($a[1]); $h=trim($a[2]); $id=trim($a[3]);
		$arr=scandir($_SERVER['DOCUMENT_ROOT'].BASE_DIR.$folder);
		if (count($arr)<=2) return $str;
		array_shift($arr);array_shift($arr); //bỏ  . và ..
		$dir=BASE_DIR;
		$codeslideshow="
		<link rel=stylesheet href='{$dir}css/slideshow1/themes/default/default.css' type='text/css'/>
		<link rel='stylesheet' href='{$dir}css/slideshow1/nivo-slider.css' type='text/css' />
		<script type='text/javascript' src='{$dir}css/slideshow1/jquery.nivo.slider.js'></script>
		<script>jQuery(document).ready(function() {jQuery('#{$id}').nivoSlider();});</script>
		<div class='slider-wrapper theme-default' style='width:{$w}px; height:{$h}px; margin:auto; border:solid 1px red'>
		<div id='{$id}' class='nivoSlider'>";
		foreach($arr as $filename) $codeslideshow.="<img src='{$dir}{$folder}/{$filename}' style='width:{$w}px;height:{$h}px' />";		
		$codeslideshow .="</div><div style='clear:both'></div></div>";
		$str = preg_replace($pattern, $codeslideshow, $str);
		return $str;	
	}
	function ChenCodeYoutube($str){
		$pattern="#{youtube}(.*){/youtube}#i"; // {youtube}yĩddddd|400|200|1{youtube}
		
		preg_match($pattern, $str,$m); //echo "<pre>";print_r($m);
		if (count($m)==0) return $str;
		$video = $m[1]; //abdxy67d|400|200|1
		if ($video=="") return $str;
		$a = explode("|",$video);
		if (count($a)==0) return $str;
		//$codebando = $this->bando($a[0],$a[1],$a[2],$a[3],$a[4],$a[5],$a[6],$a[7]);
		$id=trim($a[0]); $w=trim($a[1]); $h=trim($a[2]); $autostart=trim($a[3]); 
		$codevideo="
		<div id=video class=video align=center>
		<object classid='clsid:166B1BCA-3F9C-11CF-8075-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=10,1,1,0' width= $w height= $h >
		  <param name='src' value='http://youtube.com/v/{$id}' />
		  <embed src='http://youtube.com/v/{$id}' pluginspage='http://www.adobe.com/shockwave/download/' width= $w height= $h ></embed>
		</object></div>
		";
		$str = preg_replace($pattern, $codevideo, $str);
		return $str;		
	}
	public function ChenCodeBanDo($str){
		$pattern="#{bando}(.*){/bando}#i";
		preg_match($pattern, $str,$m); //echo "<pre>";print_r($m);
		if (count($m)==0) return $str;
		$bd = $m[1]; //HYBRID|10.766118|106.641731|17|500px|350px||ABC
		if ($bd=="") return $str;
		$a = explode("|",$bd);
		if (count($a)==0) return $str;
		$codebando = $this->bando($a[0],$a[1],$a[2],$a[3],$a[4],$a[5],$a[6],$a[7]);
		$str = preg_replace($pattern, $codebando, $str);
		return $str;
	}//function ChenCodeBanDo
	public function ChenCodeBanDoDanhLam($str, $lat, $lng, $tendanhlam,$aliasdanhlam){
		$pattern="#{bddanhlam}{/bddanhlam}#i";
		preg_match($pattern, $str,$m); //echo "<pre>";print_r($m);
		if (count($m)==0) return $str;
		$tendiv="map-". $aliasdanhlam ;
		$maker="{$lat},{$lng},{$tendanhlam}";
		$codebando = $this->bando(MAPTYPE_DANHLAM,$lat,$lng,MAPZOOM_DANHLAM,MAPWIDTH_DANHLAM,MAPHEIGHT_DANHLAM,$maker,$tendiv);
		$codebando ="<div class='bandodanhlam_container'>{$codebando}</div>";
		$str = preg_replace($pattern, $codebando, $str);
		return $str;
	}//function ChenCodeBanDoDanhLam
	function bando($kieubando,$vido,$kinhdo,$zoom,$rong,$cao,$maker_str,$tendiv){
		$code= "
		<div id='$tendiv' style='width:$rong; height:$cao' class='ban_do'> </div>
		<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&language=vi'>
		</script>
		<script> var bd1;
		google.maps.event.addDomListener(window, 'load', hienbando());

		function hienbando() {
			var opt = { center: new google.maps.LatLng($vido, $kinhdo), zoom: $zoom,
			mapTypeId: google.maps.MapTypeId.$kieubando  };
			bd1 = new google.maps.Map(document.getElementById('$tendiv'), opt);	
		}
		</script>
		<script>";	
		$maker_arr=explode(":::",$maker_str);		
		foreach ($maker_arr as $t) {
		   $mk = explode(",",$t);
		   $code.="m=new google.maps.Marker({map:bd1, position: new google.maps.LatLng($mk[0],$mk[1]), title:'$mk[2]'});";
		}//foreach
		$code .="</script>";
		return $code;
	} // function bando

}//class