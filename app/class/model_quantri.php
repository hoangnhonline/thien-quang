<?php
class model_quantri{
	public $db;
	public function __construct(){
		$this->db= new mysqli(HOST, USER_DB, PASS_DB, DB_NAME);	
		$this->db->set_charset("utf8");		
		
	}
	function capnhaturlhinhshare(){
		$sql="select idbv, tieude from baiviet";
		$baiviet = $this->db->query($sql) ;		
		$dem=0;
		while ($once = $baiviet->fetch_assoc() ){
			if ($urlhinh=="" || file_exists($urlhinh)==false) 
				$hinhshare=BSE_URL."img/timhieu-dao-phat.jpg";
			else {
				$urlhinh = $once['urlhinh'];
				$info = getimagesize($urlhinh);
				if ($info[0]<200 || $info[1]<200) continue;
				else $hinhshare=$urlhinh;
			}
			$sql="update baiviet set urlhinh_sharefacebook='$hinhshare' where idbv=". $once['idbv'];
			if(!$kq = $this->db->query($sql)) die( $this->db->error);			
			$dem++;
		}
		echo "Đã cập nhật xong $dem bài viết";	
	}
	function checklogin($g) { //$g là nhóm có quyền đăng nhập vào quản trị
		if (isset($_SESSION['login_id'])== false){			 
			  $_SESSION['error'] = 'Bạn chưa đăng nhập';
			  $_SESSION['back'] = $_SERVER['REQUEST_URI'];
			   header('location:'. BASE_URL. 'quantri/dangnhap'); 
			   exit();
		 }elseif (in_array($_SESSION['login_level'],$g)==false){
			  $_SESSION['error'] = 'Bạn không có quyền xem trang này';
			  $_SESSION['back'] = $_SERVER['REQUEST_URI'];
			  header('location:'. BASE_URL. 'quantri/dangnhap'); 
			  exit();
		 }
	}//function
	public function login($u, $p){
		$sql=sprintf("SELECT iduser, username, password,hoten,idgroup FROM users 
		  WHERE username='%s'",$u);
		if(!$kq = $this->db->query($sql)) die( $this->db->error);		
		if ($kq->num_rows==0) return 1; //username không tồn tại
		
		$sql=sprintf("SELECT iduser, username, password,hoten,idgroup FROM users 
		  WHERE username='%s' AND password=md5(concat('%s', salt))",$u,$p);
		if(!$kq = $this->db->query($sql)) die( $this->db->error);		
		if ($kq->num_rows==0) return 2; // mật khẩu không đúng		
		$row = $kq->fetch_assoc();
		$_SESSION['login_id']=$row['iduser'];
		$_SESSION['login_user']=$row['username'];
		$_SESSION['login_hoten']=$row['hoten'];
		$_SESSION['login_level']=$row['idgroup'];
		return 3; //Login OK
	}//login
	function capnhatthututacgia(){
		$idtacgia_arr = $_POST['idtacgia'];
		$thutu_arr = $_POST['thutu'];
		//print_r($idtacgia_arr);	print_r($thutu_arr);
		for ($i=0; $i<count($idtacgia_arr); $i++){
			$idtacgia= $idtacgia_arr[$i];
			$thutu= $thutu_arr[$i];
			$sql="UPDATE tacgia SET thutu=$thutu WHERE idtacgia=$idtacgia";
			if(!$kq = $this->db->query($sql)) die( $this->db->error);
		}
		echo "Đã cập nhật xong thứ tự của " . count($idtacgia_arr) . " tác giả";
	}
	function tacgia_list($per_page=5, $startrow=0, &$totalrows){				
		if (isset($_POST['tukhoatk'])==true) $_SESSION['tukhoatk']=trim(strip_tags($_POST['tukhoatk']));		
		
		if (strlen($_SESSION['tukhoatk'])>0) $tukhoa= $_SESSION['tukhoatk'];  
		else $tukhoa="";
		
        if ($tukhoa=="") $sql= "select * from tacgia ORDER BY idtacgia DESC LIMIT $startrow, $per_page";
		else $sql= "select * from tacgia WHERE tentacgia regexp '$tukhoa' or idtacgia='$tukhoa' ORDER BY idtacgia DESC LIMIT $startrow, $per_page";
		
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array(); while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		if ($tukhoa=="") $sql="SELECT count(*) from tacgia ";
		else $sql="SELECT count(*) from tacgia WHERE tentacgia regexp '$tukhoa' or idtacgia='$tukhoa'";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
		return $data;
	}
	function tacgia_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM tacgia WHERE idtacgia=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
	}
	function tacgia_them(){
		$tentacgia= trim(strip_tags($_POST['tentacgia']));
		$tieude= trim(strip_tags($_POST['tieude']));
		$mota= trim(strip_tags($_POST['mota']));
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu']; settype($thutu, "int");
		$sql= "INSERT INTO tacgia SET tieude=?, tentacgia=?, mota=?, anhien=?, thutu=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('sssii',  $this->db->escape_string($tieude), $this->db->escape_string($tentacgia),
									 $this->db->escape_string($mota),$anhien,$thutu); 
		$st->execute();
	}
	function tacgia_sua($id){		
		$tentacgia= trim(strip_tags($_POST['tentacgia']));
		$tieude= trim(strip_tags($_POST['tieude']));
		$mota= trim(strip_tags($_POST['mota']));
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu']; settype($thutu, "int");
		$sql= "UPDATE tacgia SET tieude=?, tentacgia=?, mota=?, anhien=?, thutu=? WHERE idtacgia=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('sssiii',  $this->db->escape_string($tieude), $this->db->escape_string($tentacgia), 
								   $this->db->escape_string($mota),$anhien,$thutu,$id); 
		$st->execute();
	}	
	public function chitiettacgia($id){
		settype($id,"int");
		$sql="SELECT * FROM tacgia WHERE idtacgia=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
	function capnhatthutubaiviet(){
		$idbv_arr = $_POST['idbv'];
		$thutu_arr = $_POST['thutu'];
		for ($i=0; $i<count($idbv_arr); $i++){
			$idbv= $idbv_arr[$i];
			$thutu= $thutu_arr[$i];
			$sql="UPDATE baiviet SET thutu=$thutu WHERE idbv=$idbv";
			if(!$kq = $this->db->query($sql)) die( $this->db->error);
		}
		echo "Đã cập nhật xong thứ tự của " . count($idbv_arr) . " bài viết";
	}
	function baiviet_list($idloai, $idtacgia,$noibat, $anhien, $sapxepbaiviettheo, $per_page=5, $startrow=0, &$totalrows){		
	    $orderby ="idbv DESC";
		switch ($sapxepbaiviettheo) {
			case 0: 
				$orderby="idbv DESC"; break;
			case 1: 
				$orderby="idbv ASC"; break;
			case 2: 
				$orderby="baiviet.thutu ASC"; break;				
			case 3: 
				$orderby="baiviet.thutu DESC"; break;
		}
		
		if (strlen($_SESSION['tukhoatimbv'])>0) $tukhoa= $_SESSION['tukhoatimbv'];
        if ($tukhoa=="") 
        $sql= "select * from baiviet WHERE (idloai=$idloai or $idloai=-1) AND (idtacgia=$idtacgia or $idtacgia=-1) 
		AND (noibat=$noibat or $noibat=-1)  AND (anhien=$anhien or $anhien=-1) 
		ORDER BY $orderby LIMIT $startrow, $per_page";
        else 
        $sql= "select * from baiviet 
        WHERE (idloai=$idloai or $idloai=-1) AND (idtacgia=$idtacgia or $idtacgia=-1) 
		AND (noibat=$noibat or $noibat=-1)  AND (anhien=$anhien or $anhien=-1) 
		AND (tieude regexp '$tukhoa' or tomtat regexp '$tukhoa' or idbv='$tukhoa') 
        ORDER BY $orderby LIMIT $startrow, $per_page";
        
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array(); while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
        if ($tukhoa=="")
		$sql="SELECT count(*) from baiviet WHERE (idloai=$idloai or $idloai=-1) AND (idtacgia=$idtacgia or $idtacgia=-1)
		AND (noibat=$noibat or $noibat=-1)  AND (anhien=$anhien or $anhien=-1) 
		";
        else
        $sql="SELECT count(*) from baiviet  WHERE (idloai=$idloai or $idloai=-1) AND (idtacgia=$idtacgia or $idtacgia=-1) 
		AND (noibat=$noibat or $noibat=-1)  AND (anhien=$anhien or $anhien=-1) 
		AND (tieude regexp '$tukhoa' or tomtat regexp '$tukhoa' or idbv='$tukhoa')";
        
        
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
		return $data;
	}
	function baiviet_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM baiviet WHERE idbv=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
		$sql="DELETE FROM bandocykien WHERE idbv=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		$sql="DELETE FROM baiviet_tag WHERE idbv=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);
	}
	function baiviet_them(){		
		
		$iduser = $_SESSION['login_id'];

		$tieude= trim(strip_tags($_POST['tieude']));
		$tomtat= stripslashes(trim(strip_tags($_POST['tomtat'])));
		$urlhinh= trim(strip_tags($_POST['urlhinh']));
		$urlhinh_sharefacebook= trim(strip_tags($_POST['urlhinh_sharefacebook']));
		
		$noidung= stripslashes($_POST['noidung']);
		if (isset($_POST['anhien']) ) $anhien=1; else $anhien=0;
		if (isset($_POST['noibat']) ) $noibat=1; else $noibat=0;
		if (isset($_POST['themykien']) ) $themykien=1; else $themykien=0;
		$loaicha=$_POST['loaicha']; settype($loaicha, "int");
        $idtacgia=$_POST['tacgia']; settype($idtacgia, "int");		
		$alias = $this->makealiasforarticle(-1,$tieude);
		$sql= "INSERT INTO baiviet SET tieude=?, alias=?,tomtat=?, urlhinh=?,urlhinh_sharefacebook=?, content=?, anhien=?, noibat=?, idloai=?, themykien=?, iduser= ?, idtacgia=?, ngay=now()";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssssssiiiiii',  $tieude,$alias,$tomtat, $urlhinh, $urlhinh_sharefacebook, $noidung,$anhien,$noibat, $loaicha,$themykien,$iduser,$idtacgia); 
		$st->execute();
		$idbv = $st->insert_id;		
		$tag = trim(strip_tags($_POST['tag']));		
		$tag_arr = explode(",",$tag);
		foreach ($tag_arr as $t){
			$t= trim($t); if ($t=="") continue;				
			$kq= $this->db->query("SELECT idtag from tags where tentag='$t'") ;
			if ($kq->num_rows>0) {
				$row = $kq->fetch_assoc();
				$idtag = $row['idtag'];
			} else {				
				$this->db->query("INSERT INTO tags SET tentag='$t'");
				$idtag =  $this->db->insert_id;
			}
			$sql="INSERT IGNORE INTO baiviet_tag SET idbv =$idbv , idtag=$idtag";
			if(!$kq = $this->db->query($sql))  die( $this->db->error. " - " . $sql);
		}
		return $idbv;
	}
	function baiviet_sua($idbv){
		$iduser = $_SESSION['login_id'];
		$tieude= trim(strip_tags($_POST['tieude']));
		$tomtat= stripslashes(trim(strip_tags($_POST['tomtat'])));
		
		$urlhinh= trim(strip_tags($_POST['urlhinh']));
		$urlhinh_sharefacebook= trim(strip_tags($_POST['urlhinh_sharefacebook']));
		$noidung= stripslashes($_POST['noidung']);
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$noibat=$_POST['noibat']; settype($noibat, "int");
		$loaicha=$_POST['loaicha']; settype($loaicha, "int");
        $idtacgia=$_POST['tacgia']; settype($idtacgia, "int");
		$themykien=$_POST['themykien']; settype($themykien, "int");
		$alias = $this->makealiasforarticle($idbv,$tieude);
        if (isset($_POST['capnhatngay'])==true)
		$sql= "UPDATE baiviet SET tieude=?, alias=?,tomtat=?, urlhinh=?, urlhinh_sharefacebook=?,content=?, anhien=?, noibat=?, idloai=?, themykien=?, iduser=?,idtacgia=?,ngay=now() where idbv=?";
		else
        $sql= "UPDATE baiviet SET tieude=?, alias=?,tomtat=?, urlhinh=?, urlhinh_sharefacebook=?,content=?, anhien=?, noibat=?, idloai=?, themykien=?, iduser=?,idtacgia=? where idbv=?";
        $st = $this->db->prepare($sql);
		$st->bind_param('ssssssiiiiiii',$tieude,$alias,$tomtat, $urlhinh, $urlhinh_sharefacebook,$noidung,$anhien,$noibat, $loaicha,$themykien,$iduser,$idtacgia,$idbv);
        
		$st->execute();		
		
		$sql="DELETE FROM baiviet_tag WHERE idbv =$idbv";		
		if(!$kq = $this->db->query($sql))  die( $this->db->error. " - " . $sql);		
		
		$tag = trim(strip_tags($_POST['tag']));		
		$tag_arr = explode(",",$tag);
		foreach ($tag_arr as $t){
			$t= trim($t); if ($t=="") continue;				
			$kq= $this->db->query("SELECT idtag from tags where tentag='$t'") ;
			if ($kq->num_rows>0) {
				$row = $kq->fetch_assoc();
				$idtag = $row['idtag'];
			} else {				
				$this->db->query("INSERT INTO tags SET tentag='$t'");
				$idtag =  $this->db->insert_id;
			}
			$sql="INSERT IGNORE INTO baiviet_tag SET idbv =$idbv , idtag=$idtag";
			if(!$kq = $this->db->query($sql))  die( $this->db->error. " - " . $sql);
		}
	}	
	function baiviet_loc($idloai, $tukhoa, $taglocbv){
		//phục vụ cho lọc bv ở cột trái trong trang baiviet_them, baviet_sua
		settype($idloai,"int");		
		$tukhoa = urldecode($tukhoa); if (trim($tukhoa)=='Từ khóa') $tukhoa='';				
		$idbv=-1; if (is_numeric($tukhoa) ==true) $idbv=intval($tukhoa);
		$taglocbv = urldecode($taglocbv); if (trim($taglocbv)=='Tag') $taglocbv='';	
		
		if ($tukhoa!="")
		$sql="select idbv, tieude, tomtat, urlhinh,DATE_FORMAT(ngay,'%d/%m') as ngay,baiviet.alias as aliasBV,loaibaiviet.alias as aliasLoai
		from baiviet, loaibaiviet WHERE baiviet.idloai = loaibaiviet.idloai
		AND  (baiviet.idloai=$idloai or $idloai=-1) 
		AND (tieude regexp '{$tukhoa}' OR tomtat regexp '{$tukhoa}' OR '{$tukhoa}'='' OR idbv=$idbv)
		AND ('$taglocbv'='' or idbv in (select idbv from baiviet_tag, tags where baiviet_tag.idtag=tags.idtag and tentag like '%$taglocbv%'))
		order by idbv desc";		
		else
		$sql="select idbv, tieude, tomtat, urlhinh,DATE_FORMAT(ngay,'%d/%m') as ngay,baiviet.alias as aliasBV,loaibaiviet.alias as aliasLoai
		from baiviet, loaibaiviet WHERE baiviet.idloai = loaibaiviet.idloai
		AND  (baiviet.idloai=$idloai or $idloai=-1) 		
		AND ('$taglocbv'='' or idbv in (select idbv from baiviet_tag, tags where baiviet_tag.idtag=tags.idtag and tentag like '%$taglocbv%'))
		order by idbv desc";		
		
		if(!$kq = $this->db->query($sql)) die( $this->db->error);		
		$data=array(); 
		while ( $row = $kq->fetch_assoc()) {$data[]=$row; }
		return $data;
	}
	function laytagcuabaiviet($idbv){
		$sql="select tentag from baiviet_tag, tags  where  baiviet_tag.idtag=tags.idtag AND  baiviet_tag.idbv=$idbv";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row['tentag'];
		$data = implode(",",$data);
		return $data;
	}
	function laybaivietcuatag($idtag){
		$sql="select baiviet.idbv, baiviet.tieude, baiviet.alias, baiviet_tag.thutubv , loaibaiviet.alias as aliasLoai
		FROM baiviet_tag, baiviet, loaibaiviet  
		WHERE  baiviet_tag.idbv=baiviet.idbv AND baiviet.idloai=loaibaiviet.idloai AND baiviet_tag.idtag=$idtag  
		ORDER BY thutubv";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;		
		return $data;
	}
	function dembaitrongtag($idtag){
		$sql="SELECT count(*) from baiviet_tag WHERE idtag=$idtag";
		$kq= $this->db->query($sql) or die($this->db-error . " ". $sql);
		$row = $kq->fetch_row();
		return $row[0];
	}
	
	function makealiasforcat($idLoai,$str){
		$alias = $this->changetitle($str);
		
		$cnam_arr = explode("|",CNAME_ARR); //lấy danh sách tên controller
		$action_special = explode("|",ACTION_SPECIAL); //lấy danh sách các action
		$alias_unable=array_merge($cnam_arr, $action_special); //dãy liệt kê các alias bị cấm vì trùng tên controller và action đặc biệt
		
		$i=0; $alias_new = $alias;
		while (in_array($alias_new, $alias_unable)==true) {
			$i++;
			$alias_new= $alias . "-". $i;
		}
		$alias= $alias_new; //nếu alias trong danh sách cấm thì thêm con số phía sau vào
		
		$sql="select idloai from loaibaiviet where alias='$alias' AND idLoai!=$idLoai";
		if(!$kq = $this->db->query($sql))  die( $this->db->error. " - " . $sql);			
		if ($kq->num_rows>0) $alias = $alias."-".$kq->num_rows;
		return $alias;
	}
	function laydaytenloai(){
		$data=array();
		$sql="select alias from loaibaiviet";  
		if(!$kq = $this->db->query($sql))  return $data;		
		while($row=$kq->fetch_assoc()) $data[]=$row['alias'];
		return $data;
	}
	function makealiasforarticle($idbv,$str){
		$alias = $this->changetitle($str);
		
		$cnam_arr = explode("|",CNAME_ARR); //lấy danh sách tên controller
		$action_special = explode("|",ACTION_SPECIAL); //lấy danh sách các action
		$arr_tenloai=$this->laydaytenloai();
		$alias_unable=array_merge($cnam_arr, $action_special,$arr_tenloai); //dãy liệt kê các alias bị cấm vì trùng tên controller, action , tên loại
		print_r($alias_unable);
		$i=0; $alias_new = $alias;
		while (in_array($alias_new, $alias_unable)==true) {
			$i++;
			$alias_new= $alias . "-". $i;
		}
		$alias= $alias_new; //nếu alias trong danh sách cấm thì thêm con số phía sau vào
		
		$sql="select idbv from baiviet where alias='$alias' AND idbv!=$idbv";  
		if(!$kq = $this->db->query($sql))  die( $this->db->error);			
		if ($kq->num_rows>0) $alias = $alias."_".$idbv;
		return $alias;
	}
	function makealiasfordanhlam($iddanhlam,$str, $alias){
		$alias= trim($alias);
		if ($alias=="" || $alias=="Alias") $alias = $this->changetitle($str);		
		
		$i=0; $alias_new = $alias;
		do { 
			$i++;
			$sql="select iddanhlam from danhlam where alias='$aliasnew' AND iddanhlam<>$iddanhlam";  
			if(!$kq = $this->db->query($sql))  die( $this->db->error);		
			if ($kq->num_rows>0) $aliasnew = $alias."-".$i;						
		} while($kq->num_rows>0);
		return $alias;
	}
	public function chitietbaiviet($id){
		settype($id,"int");
		$sql="SELECT * FROM baiviet WHERE idbv=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
	function baiviet_daoanhien($id){
		settype($id,"int");
		$sql="SELECT anhien FROM baiviet WHERE idbv=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;
		$row = $kq->fetch_assoc() ;
		$anhien = $row['anhien'];
		if ($anhien==0) $anhien=1; else $anhien=0;
		$sql="UPDATE baiviet SET anhien=$anhien WHERE idbv=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		return BASE_DIR. "img/AnHien_{$anhien}.jpg";
	}
	function baiviet_daonoibat($id){
		settype($id,"int");
		$sql="SELECT noibat FROM baiviet WHERE idbv=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;
		$row = $kq->fetch_assoc() ;
		$noibat = $row['noibat'];
		if ($noibat==0) $noibat=1; else $noibat=0;
		$sql="UPDATE baiviet SET noibat=$noibat WHERE idbv=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		return BASE_DIR. "img/NoiBat_{$noibat}.jpg";
	}
	function baiviet_dangbai($id){
		settype($id,"int");		
		$sql="UPDATE baiviet SET anhien=1, ngay=now() WHERE idbv=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		return "OK";
	}
	public function loaibaiviet(){	//phuc vu cho form them bai giang
		$sql="SELECT * FROM loaibaiviet";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	public function tacgia(){		//phuc vu cho form them bai giang
		$sql="SELECT * FROM tacgia order by tentacgia asc";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	
	function loaibaiviet_list($per_page=5, $startrow=0, &$totalrows){		
		
		$sql= "select * from loaibaiviet ORDER BY idcha ASC, idloai DESC LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array(); while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) from loaibaiviet";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
		return $data;
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
	function listloai_dequy($idcha = 0,$gach = '-  ', $arr = NULL){ 
	   if(!$arr) $arr = array();
	   $sql="SELECT idloai, tenloai FROM loaibaiviet WHERE idcha=$idcha ORDER BY ThuTu";
	   if(!$kq = $this->db->query($sql)) die( $this->db->error);	
	   while($row = $kq->fetch_assoc()){ 
		$arr[] = array('id'=>$row['idloai'],'ten'=>$gach.$row['tenloai']); 
		$arr = $this->listloai_dequy($row['idloai'],$gach.'--   ',$arr); 
	   } 
	   return $arr; 
	}//layloai

	function demsobaiviettrongloai($id){
		settype($id,"int");
		$sql="SELECT count(*) FROM baiviet WHERE idloai=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0];		
		} else return 0;
	}
	function demsobaivietcuatacgia($id){
		settype($id,"int");
		$sql="SELECT count(*) FROM baiviet WHERE idtacgia=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0];		
		} else return 0;
	}
	function demloaicon($id){
		settype($id,"int");
		$sql="SELECT count(*) FROM loaibaiviet WHERE idcha=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0];		
		} else return 0;
	}
    function demtongsobaiviet(){
		$sql="SELECT count(*) FROM baiviet";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];} else return 0;
    }    
    function demtongsoloaibaiviet(){   
        $sql="SELECT count(*) FROM loaibaiviet";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];} else return 0;
    }
    function demalbum(){   
        $sql="SELECT count(*) FROM album";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];} else return 0;
    } 
    function demthanhvienonline(){   
        $sql="SELECT count(*) FROM sessions";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];} else return 0;
    }
    function demuser(){   
        $sql="SELECT count(*) FROM users";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];} else return 0;
    }     
    function demluottruycap(){   
        $sql="SELECT hitcounter FROM thongke";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];} else return 0;
    }   
	function loaibaiviet_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM loaibaiviet WHERE idloai=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
		$sql="DELETE FROM baiviet WHERE idloai=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
	}
	function loaibaiviet_them(){
		$tenloai= $_POST['tenloai'];
		$alias= $_POST['alias'];
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu']; settype($thutu, "int");
		$loaicha=$_POST['loaicha']; settype($loaicha, "int");
        $aiduocxem = $_POST['aiduocxem']; settype($aiduocxem, "int");
		$sapxepbaiviettheo=$_POST['sapxepbaiviettheo']; settype($sapxepbaiviettheo, "int");
		$mota= strip_tags($_POST['mota']);
		if ($alias=="") $alias = $this->makealiasforcat(-1,$tenloai);
		$sql= "INSERT INTO loaibaiviet SET tenloai=?, alias=?,anhien=?, thutu=?, idcha=?, aiduocxem=?,sapxepbaiviettheo=?, mota=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssiiiiis',  $this->db->escape_string($tenloai),$alias,$anhien,$thutu,$loaicha,$aiduocxem,$sapxepbaiviettheo,$mota); 
		$st->execute();
	}
	function loaibaiviet_sua($id){		
		$tenloai= $_POST['tenloai'];
		$alias= $_POST['alias'];		
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu']; settype($thutu, "int");
		$loaicha=$_POST['loaicha']; settype($loaicha, "int");
        $aiduocxem = $_POST['aiduocxem']; settype($aiduocxem, "int");
		$sapxepbaiviettheo=$_POST['sapxepbaiviettheo']; settype($sapxepbaiviettheo, "int");
		$mota= strip_tags($_POST['mota']);
		if ($alias=="")$alias = $this->makealiasforcat($id,$tenloai);
		
		$sql= "UPDATE loaibaiviet SET tenloai=?, alias=?,anhien=?, thutu=?, idcha=?, aiduocxem=?,sapxepbaiviettheo=?,mota=? WHERE idloai=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssiiiiisi', $this->db->escape_string($tenloai),$alias,$anhien,$thutu,$loaicha,$aiduocxem,$sapxepbaiviettheo,$mota,$id); 
		$st->execute();
	}	
	public function chitietloaibaiviet($id){
		settype($id,"int");
		$sql="SELECT * FROM loaibaiviet WHERE idloai=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
//loaichudevideo
    function chudevideo_list($per_page=5, $startrow=0, &$totalrows){		
		$sql= "select * from chudevideo LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array(); while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) from chudevideo";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
		return $data;
	}
    function demsovideotrongchude($id){
		settype($id,"int");
		$sql="SELECT count(*) FROM chudevideo WHERE idchudevideo=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];	} else return 0;
	}
    function chudevideo_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM chudevideo WHERE idchudevideo=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
	}
	function chudevideo_them(){
		$tenchudevideo= $this->db->escape_string($_POST['tenchudevideo']);	
        $mota= $_POST['mota'];	
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu']; settype($thutu, "int");
		
		$sql= "INSERT INTO chudevideo SET tenchudevideo=?, mota=?,anhien=?, thutu=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssii',$tenchudevideo,$mota,$anhien,$thutu); 
		$st->execute();
	}
	function chudevideo_sua($id){	
	    settype($id,"int");
		$tenchudevideo= $this->db->escape_string($_POST['tenchudevideo']);	
        $mota= $_POST['mota'];	
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu']; settype($thutu, "int");
		
		$sql= "UPDATE chudevideo SET tenchudevideo=?, mota=?,anhien=?, thutu=? WHERE idchudevideo=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssiii',$tenchudevideo,$mota,$anhien,$thutu,$id); 
		$st->execute();
	}	
	public function chitietchudeVIDEO($id){
		settype($id,"int");
		$sql="SELECT * FROM chudevideo WHERE idchudevideo=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
//loaichude

//loaichudemedia
    function chudemedia_list($per_page=5, $startrow=0, &$totalrows){		
		$sql= "select * from chudemedia LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array(); while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) from chudemedia";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
		return $data;
	}
    function demsomediatrongchude($id){
		settype($id,"int");
		$sql="SELECT count(*) FROM media WHERE idchudemedia=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if (isset($kq) && $kq->num_rows>0) {$row = $kq->fetch_row();return $row[0];	} else return 0;
	}
    function chudemedia_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM chudemedia WHERE idchudemedia=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
	}
	function chudemedia_them(){
		$tenchudemedia= $_POST['tenchudemedia'];	
        $mota= $_POST['mota'];	
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu']; settype($thutu, "int");
		
		$sql= "INSERT INTO chudemedia SET tenchudemedia=?, mota=?,anhien=?, thutu=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssii',  $this->db->escape_string($tenchudemedia),$mota,$anhien,$thutu); 
		$st->execute();
	}
	function chudemedia_sua($id){	
	    settype($id,"int");
		$tenchudemedia= $_POST['tenchudemedia'];	
        $mota= $_POST['mota'];	
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu']; settype($thutu, "int");
		
		$sql= "UPDATE chudemedia SET tenchudemedia=?, mota=?,anhien=?, thutu=? WHERE idchudemedia=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssiii',  $this->db->escape_string($tenchudemedia),$mota,$anhien,$thutu,$id); 
		$st->execute();
	}	
	public function chitietchudemedia($id){
		settype($id,"int");
		$sql="SELECT * FROM chudemedia WHERE idchudemedia=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
//loaichudemedia
//media

	function media_them(){
		$tenmedia= strip_tags($_POST['tenmedia']);
		$url= strip_tags($_POST['url']); 
        $mota= $_POST['mota'];
        $idtacgia = $_POST['idtacgia'];settype($idtacgia, "int");
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$chudemedia=$_POST['chudemedia'];settype($chudemedia, "int");
     
		$sql= "INSERT INTO media SET tenmedia=?,mota=?,url=?, anhien=?, idchudemedia=?, idtacgia=?, ngay=now()";
		$st = $this->db->prepare($sql);
		$st->bind_param('sssiii', $tenmedia,$mota,$url,$anhien,$chudemedia,$idtacgia); 
		$st->execute();

	}
	function media_sua($id){		
		settype($id,"int");
		$tenmedia= strip_tags($_POST['tenmedia']);
		$url= strip_tags($_POST['url']); 
        $mota= $_POST['mota'];
        $idtacgia = $_POST['idtacgia'];settype($idtacgia, "int");
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$chudemedia=$_POST['chudemedia'];settype($chudemedia, "int");
		$sql= "UPDATE media SET tenmedia=?,mota=?,url=?, anhien=?, idchudemedia=?, idtacgia=?, ngay=now() WHERE idmedia=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('sssiiii', $tenmedia,$mota,$url,$anhien,$chudemedia,$idtacgia,$id); 
		$st->execute();
	}
	function media_list($idchude,$per_page=5, $startrow=0, &$totalrows){		
		
		if (strlen($_SESSION['tukhoatimmedia'])>0) $tukhoa= $_SESSION['tukhoatimmedia'];
        if ($tukhoa=="") 
		$sql= "select media.*, tenchudemedia from media, chudemedia
		WHERE (media.idchudemedia=chudemedia.idchudemedia) AND(media.idchudemedia=$idchude or $idchude=-1)  
		LIMIT $startrow, $per_page";
		else
		$sql= "select media.*, tenchudemedia from media, chudemedia
		WHERE (media.idchudemedia=chudemedia.idchudemedia) AND(media.idchudemedia=$idchude or $idchude=-1)  
		AND (tenmedia regexp '$tukhoa' or media.mota regexp '$tukhoa' or idmedia='$tukhoa') 
		LIMIT $startrow, $per_page";
		
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		 if ($tukhoa=="")
		$sql="SELECT count(*) from media, chudemedia
		WHERE (media.idchudemedia=chudemedia.idchudemedia) AND(media.idchudemedia=$idchude or $idchude=-1) ";
		else
		$sql="SELECT count(*) from media, chudemedia
		WHERE (media.idchudemedia=chudemedia.idchudemedia) AND(media.idchudemedia=$idchude or $idchude=-1) 
		AND (tenmedia regexp '$tukhoa' or media.mota regexp '$tukhoa' or idmedia='$tukhoa') 
		";	
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		

		return $data;
	}
	function media_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM media WHERE idmedia=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
	}
	public function chitietmedia($id){
		settype($id,"int");
		$sql="SELECT * FROM media WHERE idmedia=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
	function chudemedia(){
		$sql="SELECT * FROM chudemedia  ORDER BY thutu";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		return $data;
	}
//mediaplaylist
	
	function mediaplaylist_them(){
		$tenmediaplaylist= trim(strip_tags($_POST['tenmediaplaylist']));
        $mota= trim(strip_tags($_POST['mota']));
        $idtacgia = $_POST['idtacgia'];settype($idtacgia, "int");
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$chudemedia=$_POST['chudemedia'];settype($chudemedia, "int");
     
		$sql= "INSERT INTO mediaplaylist SET tenmediaplaylist=?,mota=?,anhien=?, idchudemedia=?, idtacgia=?, ngay=now()";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssiii', $tenmediaplaylist,$mota,$anhien,$chudemedia,$idtacgia); 
		$st->execute();
		$idmediaplaylist = $st->insert_id;
		
		$daymedianame= $_POST['medianame'];  $daymediaurl= $_POST['mediaurl'];
		//print_r($daymedianame);
		if (count($daymedianame)==0 || count($daymediaurl)==0) return;		
		for($i=0; $i<count($daymedianame); $i++){
			$medianame = trim(strip_tags($daymedianame[$i]));
			$mediaurl = trim(strip_tags($daymediaurl[$i]));
			$sql= "INSERT INTO media SET tenmedia='$medianame', url='$mediaurl', idtacgia=$idtacgia, 
			idchudemedia=$chudemedia, idmediaplaylist=$idmediaplaylist, thutu=$i, ngay=now()
			on duplicate key update tenmedia=values(tenmedia), thutu=values(thutu)";
			//echo $sql,"<br>";
			if(!$rs = $this->db->query($sql)) die( $this->db->error);
		}
		
	}
	function mediaplaylist_sua($id){		
		settype($id,"int");
		$tenmediaplaylist= trim(strip_tags($_POST['tenmediaplaylist']));		
        $mota= trim(strip_tags($_POST['mota']));
        $idtacgia = $_POST['idtacgia'];settype($idtacgia, "int");
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$chudemedia=$_POST['chudemedia'];settype($chudemedia, "int");
		$sql= "UPDATE mediaplaylist SET tenmediaplaylist=?, mota=?,anhien=?, idchudemedia=?, idtacgia=?, ngay=now() WHERE idmediaplaylist=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssiiii', $tenmediaplaylist,$mota,$anhien,$chudemedia,$idtacgia,$id); 
		$st->execute();
		
		$sql="DELETE FROM media WHERE idmediaplaylist=$id";
		if(!$this->db->query($sql)) die( $this->db->error);
		
		$daymedianame= $_POST['medianame'];  $daymediaurl= $_POST['mediaurl'];
		if (count($daymedianame)==0 || count($daymediaurl)==0) return;		
		for($i=0; $i<count($daymedianame); $i++){
			$medianame = trim(strip_tags($daymedianame[$i]));
			$mediaurl = trim(strip_tags($daymediaurl[$i]));
			$sql= "INSERT INTO media SET tenmedia='$medianame', url='$mediaurl', idtacgia=$idtacgia, 
			idchudemedia=$chudemedia, idmediaplaylist=$id, thutu=$i, ngay=now()
			on duplicate key update tenmedia=values(tenmedia), thutu=values(thutu)";
			if(!$rs = $this->db->query($sql)) die( $this->db->error);
		}
	}
	
	function mediaplaylist_list($idchude,$per_page=5, $startrow=0, &$totalrows){		
		
		$sql= "select * from mediaplaylist	WHERE idchudemedia=$idchude or $idchude=-1 LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) from mediaplaylist WHERE idchudemedia=$idchude or $idchude=-1";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		

		return $data;
	}
	function mediaplaylist_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM mediaplaylist WHERE idmediaplaylist=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
	}
	public function chitietmediaplaylist($id){
		settype($id,"int");
		$sql="SELECT * FROM mediaplaylist WHERE idmediaplaylist=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
	function mediatrongplaylist($id){
		settype($id,"int");
		$sql="SELECT * FROM media  WHERE idmediaplaylist=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		return $data;
	}
//video

	function video_them(){
		$tenvideo= strip_tags($_POST['tenvideo']);
		$idyoutube= strip_tags($_POST['idyoutube']); 
        $mota= $_POST['mota'];
		$ngaygiang= $_POST['ngaygiang'];
		$ngaygiang_arr=explode("/", $ngaygiang);
		if (count($ngaygiang_arr)==3)
			$ngaygiang_str=$ngaygiang_arr[2]."-".$ngaygiang_arr[1]."-".$ngaygiang_arr[0]; //2015-2-13
		else $ngaygiang_str="0000-00-00";
        $idtacgia = $_POST['idtacgia'];settype($idtacgia, "int");
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$chudevideo=$_POST['chudevideo'];settype($chudevideo, "int");
        //print_r($_POST);
		$sql= "INSERT INTO video SET tenvideo=?,mota=?,idyoutube=?, anhien=?, idchudevideo=?, idtacgia=?, ngaygiang=?, ngay=now()";
		$st = $this->db->prepare($sql);
		$st->bind_param('sssiiis', $tenvideo,$mota,$idyoutube,$anhien,$chudevideo,$idtacgia,$ngaygiang_str); 
		$st->execute();

	}
	function video_sua($id){		
		settype($id,"int");
		$tenvideo= strip_tags($_POST['tenvideo']);
		$idyoutube= strip_tags($_POST['idyoutube']); 
        $mota= $_POST['mota'];
		$ngaygiang= $_POST['ngaygiang'];  //       13/2/2015
		$ngaygiang_arr=explode("/", $ngaygiang);
		if (count($ngaygiang_arr)==3)
			$ngaygiang_str=$ngaygiang_arr[2]."-".$ngaygiang_arr[1]."-".$ngaygiang_arr[0]; //2015-2-13
		else $ngaygiang_str="0000-00-00";
        
		$idtacgia = $_POST['idtacgia'];settype($idtacgia, "int");
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$chudevideo=$_POST['chudevideo'];settype($chudevideo, "int");
        //print_r($_POST);
		$sql= "UPDATE video SET tenvideo=?,mota=?,idyoutube=?, anhien=?, idchudevideo=?, idtacgia=?, ngaygiang=?, ngay=now() WHERE idvideo=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('sssiiisi', $tenvideo,$mota,$idyoutube,$anhien,$chudevideo,$idtacgia,$ngaygiang_str,$id); 
		$st->execute();
	}
		
	function video_list($idchude,$per_page=5, $startrow=0, &$totalrows, $orderby){		
		settype($orderby,"int");
		if ($orderby==0) $orderby_str="idvideo DESC";		
		else if ($orderby==1) $orderby_str="idvideo DESC";
		else if ($orderby==2) $orderby_str="idvideo ASC";
		else if ($orderby==3) $orderby_str="tenvideo DESC";
		else if ($orderby==4) $orderby_str="tenvideo ASC";
		else if ($orderby==5) $orderby_str="thutu DESC";
		else if ($orderby==6) $orderby_str="thutu ASC";
		else if ($orderby==7) $orderby_str="ngaygiang DESC";
		else if ($orderby==8) $orderby_str="ngaygiang ASC";
	
	    if (strlen($_SESSION['tukhoatimvideo'])>0) $tukhoa= $_SESSION['tukhoatimvideo'];  
		
		if ($tukhoa=="") 
		$sql= "select * from video WHERE video.idchudevideo=$idchude or $idchude=-1 order by $orderby_str LIMIT $startrow, $per_page";
		else
		$sql= "select * from video WHERE (video.idchudevideo=$idchude or $idchude=-1) 
		AND (tenvideo regexp '$tukhoa' or idyoutube = '$tukhoa' or idvideo='$tukhoa')
		order by $orderby_str LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		if ($tukhoa=="") 
		$sql="SELECT count(*) from video WHERE video.idchudevideo=$idchude or $idchude=-1 ";
		else
		$sql="SELECT count(*) from video WHERE (video.idchudevideo=$idchude or $idchude=-1)
		AND (tenvideo regexp '$tukhoa' or idyoutube = '$tukhoa' or idvideo='$tukhoa')
		";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);
		$row = $rs->fetch_row();
		$totalrows=$row[0];
		return $data;
	}
	function video_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM video WHERE idvideo=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
	}
	public function chitietvideo($id){
		settype($id,"int");
		$sql="SELECT * FROM video WHERE idvideo=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
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
	function chudevideo(){
		$sql="SELECT * FROM chudevideo  ORDER BY thutu";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		return $data;
	}
	function demvideotrongchude($idchude){
		$sql="SELECT count(*) from video WHERE idchudevideo=$idchude or $idchude=-1";
		$kq= $this->db->query($sql) or die($this->db-error . " ". $sql);
		$row = $kq->fetch_row();
		return $row[0];
	}


//ketthuc video

//album
	function album_them(){
		$ten= $_POST['ten'];
		$mota= $_POST['mota'];
        $hinhdaidien = $_POST['hinhdaidien'];
        $hinhtrongalbum= $_POST['hinhtrongalbum'];
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu'];settype($thutu, "int");
		
		$sql= "INSERT INTO album SET tenalbum=?, mota=?, hinhdaidien=?, hinhtrongalbum=?,anhien=?, thutu=?, ngay=now()";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssssii', $ten,$mota,$hinhdaidien,$hinhtrongalbum,$anhien,$thutu); 
		$st->execute();        
	}
	function album_list($per_page=5, $startrow=0, &$totalrows){		
		
		$sql= "select * from album ORDER BY idalbum DESC LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) from album";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
		return $data;
	}
	public function chitietalbum($id){
		settype($id,"int");
		$sql="SELECT * FROM album WHERE idalbum=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
	function album_sua($id){
		$ten= $_POST['ten'];
		$mota= $_POST['mota'];
        $hinhdaidien = $_POST['hinhdaidien'];
        $hinhtrongalbum= $_POST['hinhtrongalbum'];
		$anhien=$_POST['anhien']; settype($anhien, "int");
		$thutu=$_POST['thutu'];settype($thutu, "int");
		
		$sql= "UPDATE album SET tenalbum=?, mota=?, hinhdaidien=?, hinhtrongalbum=?,anhien=?, thutu=?, ngay=now() WHERE idalbum=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('ssssiii', $ten,$mota,$hinhdaidien,$hinhtrongalbum,$anhien,$thutu,$id); 
		$st->execute();
	}
    function album_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM album WHERE idalbum=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);				
	}
//ket thuc albumn

//quan tri tag
	function tag_list($per_page=5, $startrow=0, &$totalrows){		
	    if (strlen($_SESSION['tukhoatimtag'])>0) $tukhoa= $_SESSION['tukhoatimtag'];  
		
		if ($tukhoa=="") $sql= "select * from tags ORDER BY tentag LIMIT $startrow, $per_page ";
		else
		$sql= "select * from tags WHERE (tentag regexp '$tukhoa' or idtag = '$tukhoa') ORDER BY tentag LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		if ($tukhoa=="") $sql="SELECT count(*) from tags";
		else $sql="SELECT count(*) from tags	WHERE (tentag regexp '$tukhoa' or idtag = '$tukhoa')";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];
		return $data;
	}
	function tag_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM tags WHERE idtag=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);				
		$sql="DELETE FROM baiviet_tag WHERE idtag=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);
	}
	function chitiettag($id){
		settype($id,"int");
		$sql="SELECT * FROM tags WHERE idtag=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;
	}
	function tag_sua($id){		
		settype($id,"int");
		$tentag= trim(strip_tags($_POST['tentag']));
		$st = $this->db->prepare("UPDATE tags  SET tentag=? WHERE idtag=?");
		$st->bind_param('si', $tentag,$id); 
		$st->execute();
		
		$sql="DELETE FROM baiviet_tag WHERE idtag=$id";
		if(!$this->db->query($sql)) die( $this->db->error);
		
		$dayidbv= $_POST['idbv'];  
		
		if (count($dayidbv)==0 ) return;		
		for($i=0; $i<count($dayidbv); $i++){
			$idbv = $dayidbv[$i]; settype($idbv,"int");	
			$thutu=$i+1;
			$sql= "INSERT INTO baiviet_tag SET idbv=$idbv, idtag=$id, thutubv=$thutu
				   on duplicate key update thutubv=$thutu";
			if(!$this->db->query($sql)) die( $this->db->error. " " . $sql);
		}
	}
//ketthuc tag

//quan tri box
	function box_them(){
		$tenbox = trim(strip_tags($_POST['tenbox']));
		$mota = trim(strip_tags($_POST['mota']));
		$listid = trim(strip_tags($_POST['listid']));
		$loaibox = $_POST['loaibox'];settype($loaibox, "int");
		$sobai = $_POST['sobai'];settype($sobai, "int");
		$hienthibai = $_POST['hienthibai'];settype($hienthibai, "int");
		$noibat = $_POST['noibat'];settype($noibat, "int");
		$sapxep = $_POST['sapxep'];settype($sapxep, "int");
		$hientenbox = $_POST['hientenbox'];settype($hientenbox, "int");
		$anhien = $_POST['anhien']; settype($anhien, "int");
		
		$sql= "INSERT INTO box SET tenbox=?, mota=?, listid=?, loaibox=?, sobai=?, hienthibai=?,noibat=?, sapxep=?, hientenbox=?, anhien=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('sssiiiiiii',  $tenbox, $mota,$listid, $loaibox, $sobai, $hienthibai,$noibat, $sapxep, $hientenbox, $anhien);  
		$st->execute();
	}
	function box_list($per_page=5, $startrow=0, &$totalrows){		
	    if (strlen($_SESSION['tukhoatimbox'])>0) $tukhoa= $_SESSION['tukhoatimbox'];  
		
		if ($tukhoa=="") $sql= "select * from box ORDER BY tenbox LIMIT $startrow, $per_page ";
		else
		$sql= "select * from box WHERE (tenbox regexp '$tukhoa' or idbox = '$tukhoa') ORDER BY tenbox LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		if ($tukhoa=="") $sql="SELECT count(*) from box";
		else $sql="SELECT count(*) from box	WHERE (tenbox regexp '$tukhoa' or idbox = '$tukhoa')";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];
		return $data;
	}
	function box_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM box WHERE idbox=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);				
		$sql="DELETE FROM boxinpage WHERE idbox=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);
	}
	function chitietbox($id){
		settype($id,"int");
		$sql="SELECT * FROM box WHERE idbox=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;
	}
	function box_sua($id){		
		settype($id,"int");
		$tenbox = trim(strip_tags($_POST['tenbox']));
		$mota = trim(strip_tags($_POST['mota']));
		$listid = trim(strip_tags($_POST['listid']));
		$loaibox = $_POST['loaibox'];settype($loaibox, "int");
		$sobai = $_POST['sobai'];settype($sobai, "int");
		$hienthibai = $_POST['hienthibai'];settype($hienthibai, "int");
		$noibat = $_POST['noibat'];settype($noibat, "int");
		$sapxep = $_POST['sapxep'];settype($sapxep, "int");
		$hientenbox = $_POST['hientenbox'];settype($hientenbox, "int");
		$anhien = $_POST['anhien']; settype($anhien, "int");
		
		$sql= "UPDATE box SET tenbox=?, mota=?, listid=?, loaibox=?, sobai=?, hienthibai=?, noibat=?, sapxep=?, hientenbox=?, anhien=? where idbox=$id";
		$st = $this->db->prepare($sql);
		$st->bind_param('sssiiiiiii',  $tenbox, $mota,$listid, $loaibox, $sobai, $hienthibai, $noibat, $sapxep, $hientenbox, $anhien);  
		$st->execute();
	}
	function box_luu(){				
		$idbox = $_POST['idbox']; settype($idbox,"int");
		$tenbox = trim(strip_tags($_POST['tenbox']));
		$mota = trim(strip_tags($_POST['mota']));
		$listid = trim(strip_tags($_POST['listid']));
		$loaibox = $_POST['loaibox'];settype($loaibox, "int");
		$sobai = $_POST['sobai'];settype($sobai, "int");
		$hienthibai = $_POST['hienthibai'];settype($hienthibai, "int");
		$noibat = $_POST['noibat'];settype($noibat, "int");
		$sapxep = $_POST['sapxep'];settype($sapxep, "int");
		$hientenbox = $_POST['hientenbox'];settype($hientenbox, "int");
		$anhien = $_POST['anhien']; settype($anhien, "int");
		if ($idbox>0){
			$sql= "UPDATE box SET tenbox=?, mota=?, listid=?, loaibox=?, sobai=?, hienthibai=?, noibat=?, sapxep=?, hientenbox=?, anhien=? where idbox=$idbox";
			$st = $this->db->prepare($sql);
			if ($st===false){ return "Lỗi 1: ". htmlspecialchars($this->db->error); }
			$rc = $st->bind_param('sssiiiiiii',  $tenbox, $mota,$listid, $loaibox, $sobai, $hienthibai, $noibat, $sapxep, $hientenbox, $anhien); 
			if ($rc===false){ return "Lỗi 2: ". htmlspecialchars($st->error); 	}
		}else{
			$sql= "INSERT INTO box SET tenbox=?, mota=?, listid=?, loaibox=?, sobai=?, hienthibai=?,noibat=?, sapxep=?, hientenbox=?, anhien=?";
			$st = $this->db->prepare($sql);
			if ($st===false){ return "Lỗi 1: ". htmlspecialchars($this->db->error); }
			$rc = $st->bind_param('sssiiiiiii',  $tenbox, $mota,$listid, $loaibox, $sobai, $hienthibai,$noibat, $sapxep, $hientenbox, $anhien);  
			if ($rc===false){ return "Lỗi 2: ". htmlspecialchars($st->error); 	}
		}
		$rc = $st->execute();
		if ($rc===false){return "Lỗi 3: ". htmlspecialchars($st->error);}			
		$st->close();
		return "Đã lưu box";
	}
//ketthuc box
//quan tri ykien

    function ykien_list($idbv, $per_page=5, $startrow=0, &$totalrows,$anhien=0, $orderby ="ngay DESC"){		
	   
		if (strlen($_SESSION['tukhoatimyk'])>0) $tukhoa= $_SESSION['tukhoatimyk'];  
  
        if ($tukhoa=="") 
        $sql= "select * from bandocykien WHERE (idbv=$idbv or $idbv=-1) AND (anhien=$anhien OR $anhien=-1) ORDER BY $orderby LIMIT $startrow, $per_page";
        else 
        $sql= "select * from bandocykien 
        WHERE (idbv=$idbv or $idbv=-1) AND (hoten regexp '$tukhoa' or noidung regexp '$tukhoa' or idykien='$tukhoa') AND (anhien=$anhien OR $anhien=-1) 
        ORDER BY $orderby LIMIT $startrow, $per_page";
        
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array(); while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
        if ($tukhoa=="")
		$sql="SELECT count(*) from bandocykien WHERE (idbv=$idbv or $idbv=-1) AND (anhien=$anhien OR $anhien=-1)";
        else
        $sql="SELECT count(*) from bandocykien WHERE (idbv=$idbv or $idbv=-1) AND (hoten regexp '$tukhoa' or noidung regexp '$tukhoa' or idykien='$tukhoa') AND (anhien=$anhien OR $anhien=-1)";
        
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];		
		return $data;
	}
    function ykien_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM bandocykien WHERE idykien=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);				
	}
	function demykien($anhien){
		$sql="SELECT count(*) from bandocykien WHERE anhien=$anhien";
		$kq= $this->db->query($sql) or die($this->db-error . " ". $sql);
		$row = $kq->fetch_row();
		return $row[0];
	}
    public function chitietykien($id){
		settype($id,"int");
		$sql="SELECT * FROM bandocykien WHERE idykien=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
	function ykien_daoanhien($id){
		settype($id,"int");
		$sql="SELECT anhien FROM bandocykien WHERE idykien=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;
		$row = $kq->fetch_assoc() ;
		$anhien = $row['anhien'];
		if ($anhien==0) $anhien=1; else $anhien=0;
		$sql="UPDATE bandocykien SET anhien=$anhien WHERE idykien=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		return BASE_DIR. "img/AnHien_{$anhien}.jpg";
	}
    function ykien_sua($id){
		$hoten= trim(strip_tags($_POST['hoten']));
		$noidung= trim(strip_tags($_POST['noidung']));
        $anhien= $_POST['anhien'];settype($anhien, "int");
        $email= trim(strip_tags($_POST['email']));
	
		$sql= "UPDATE bandocykien SET hoten=?, noidung=?, email=?, anhien=? WHERE idykien=?";
		$st = $this->db->prepare($sql);
		$st->bind_param('sssii', $hoten,$noidung,$email,$anhien,$id); 
		$st->execute();
	}
//ketthucykien
    public function cacloai($idcha=-1){
		$sql="SELECT idloai, tenloai FROM loaibaiviet WHERE anhien=1 AND (idcha=$idcha or $idcha=-1) ORDER BY thutu";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		while ($row = $kq->fetch_assoc()) $data[] =	$row;
		return $data;
	}

	function cauhinh_layra(){
	   	$sql= "select * from cauhinh ORDER BY thutu ASC";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
        return $data;
	}
    function cauhinh_luu(){
        $arr_id = $_POST['id'];
        $arr_idobj = $_POST['idobj'];
        for($i=0; $i<count($arr_id);$i++){
            $id = $arr_id[$i];
            $idobj=$arr_idobj[$i];
            $sql="UPDATE cauhinh SET idobj=$idobj WHERE id=$id";$this->db->query($sql);
        }
	}
    
    function tag_Autocomlete($tag){
		
		$sql= "select tentag from tags WHERE tentag like '%$tag%' ORDER BY tentag ASC";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_row())  $data[] ='"'. $row[0]. '"';
		$data = "[". implode(",",$data) . "]";
        return $data;
	}
    
	function pageslist($baseurl, $totalrows, $offset,$per_page, $currentpage){
		$totalpages = ceil($totalrows/$per_page);
		$from = $currentpage-$offset;
		$to = $currentpage +$offset;
		if ($from<=0) $from=1;
		if ($to>$totalpages) $to=$totalpages;
		$links="<a href=$baseurl title='Trang đầu'>Đ</a>";
		for ($j=$from; $j<=$to; $j++) {
			if ($j==$currentpage) $links = $links . "<span>$j</span>"; 
			else $links = $links . "<a href = '$baseurl/$j/'>$j</a>"; 	
		}
		$links = $links . "<a href = '$baseurl/$totalpages/' title='Trang cuối'>C</a>"; 	
		return $links;
	}
	
	function pageslist1($baseurl, $totalrows, $offset,$per_page, $currentpage){
		$totalpages = ceil($totalrows/$per_page);
		$from = $currentpage-$offset;
		$to = $currentpage +$offset;
		if ($from<=0) $from=1;
		if ($to>$totalpages) $to=$totalpages;
		
		$links="<a href=$baseurl title='Trang đầu'>Đ</a>";
		for ($j=$from; $j<=$to; $j++) {
			if ($j==$currentpage) $links = $links . "<span>$j</span>"; 
			else $links = $links . "<a href = '$baseurl&pagenum=$j'>$j</a>"; 	
		}
		$links = $links . "<a href = '$baseurl&pagenum=$totalpages' title='Trang cuối'>C</a>"; 	
		return $links;
	}
	function luuykien(){
		$hoten =trim(strip_tags($_POST['hoten']));
		$tieude = trim(strip_tags($_POST['tieude']));
		$noidung = trim(strip_tags($_POST['noidung']));
		$sql = sprintf("INSERT INTO bandocykien SET hoten='%s', tieude = '%s', noidung='%s',Ngay=NOW)",
			   $this->db->escape_string($hoten),$this->db->escape_string($tieude),$this->db->escape_string($noidung));
		$this->db->query($sql) or print($this->db->error);
	}
	function changeTitle($str){
		$str = $this->stripUnicode($str);
		$str = str_replace(array("'",'"',"&","?","+","%","#","“","”","(",")","–","“","”","…",",","`",":"),"",$str);		
		$str = str_replace(array("ā","ī","ṭ","ṇ","ḍ","ð","Ð","ō"),array("a","i","t","n","d","d","d","o"),$str);
		$str = str_replace("-"," ",$str);		
		$str = trim($str);		
		while (strpos($str,'  ')>0) $str = str_replace("  "," ",$str);
		$str = mb_convert_case($str , MB_CASE_LOWER , 'utf-8');		
		$str = str_replace(" ","-",$str);	
		$str = str_replace("/","-",$str);	
		return $str;
	}
	function stripUnicode($str){ //dưới đăy có nhiều dấu có vẻ như trùng nhưng thực sự thì không trùng
		if(!$str) return false;
		$unicode = array(
		 'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ|́á|á|ạ|á|à|ạ',
		 'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		 'd'=>'đ',
		 'D'=>'Đ',
		 'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		 'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		 'i'=>'í|ì|ỉ|ĩ|ị|í',	  
		 'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		 'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|ò',
		 'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		 'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|ụ',
		 'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		 'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		 'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
		);
		foreach($unicode as $khongdau=>$codau) {
		  $arr = explode("|",$codau);
		  $str = str_replace($arr,$khongdau,$str);
		}
		return $str;
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
	function changepass(&$loi){
		if (isset($_SESSION['login_id'])==false) return;		
		$passold = trim(strip_tags($_POST['passold']));
		$passnew1 = trim(strip_tags($_POST['passnew1']));
		$passnew2 = trim(strip_tags($_POST['passnew2']));
		$loi=array();
		if ($this->codaunhay($passold)==true) $loi['passold']="Password cũ không được chứa dấu ' và \" <br/>";
		else if (0<strlen($passnew1) && strlen($passnew1)<6) $loi['passnew']="Mật khẩu mới quá ngắn<br/>";
        else if ($passnew1!=$passnew2) $loi['passnew']="Mật khẩu mới hai lần nhập không giống nhau<br/>";
		if (count($loi)>0) return false;     
		
		$sql="select * from users where iduser=" . $_SESSION['login_id'];
		if(!$kq = $this->db->query($sql)) die($this->db->error) ;
		if ($kq->num_rows<=0) { $loi['user']="User không xác định"; return false; }
		$sql=sprintf("SELECT * FROM users  WHERE iduser='%s' AND password=md5(concat('%s', salt))",$_SESSION['login_id'],$passold);
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		if ($kq->num_rows==0)  { $loi['passold'] = "Mật khẩu cũ không đúng"; return false; }
		
        $sql= sprintf("UPDATE users SET password=md5(concat('%s',salt)) WHERE iduser=%d", $passnew1, $_SESSION['login_id']);    
        if(!$kq = $this->db->query($sql)) die( $this->db->error);         		
        return true;		
	}
	function codaunhay($str){
		if (substr($str,0,1)=="'" || substr($str,0,1)=='"')  return true;
		if (strpos($str,"'")>0 || strpos($str,'"')>0)  return true;
		return false;
	}
	function user_list($idgroup, $tukhoatimuser, $per_page=5, $startrow=0, &$totalrows){		
		$sql= "select * from users
		WHERE (users.idgroup=$idgroup or $idgroup=-1)  
		AND ( 
			'$tukhoatimuser'='all' or hoten like '%{$tukhoatimuser}%' or username like '%{$tukhoatimuser}%' 
			or iduser = '{$tukhoatimuser}' or diachi like '%{$tukhoatimuser}%' or dienthoai like '%{$tukhoatimuser}%' 
		)
		ORDER By iduser DESC
		LIMIT $startrow, $per_page";
		if(!$kq = $this->db->query($sql)) die( $this->db->error);
		$data=array();
		while ($row= $kq ->fetch_assoc()) $data[] =	$row;
		
		$sql="SELECT count(*) from users
		WHERE (users.idgroup=$idgroup or $idgroup=-1)  
		AND ( 
			'$tukhoatimuser'='all' or hoten like '%{$tukhoatimuser}%' or username like '%{$tukhoatimuser}%' 
			or iduser = '{$tukhoatimuser}' or diachi like '%{$tukhoatimuser}%' or dienthoai like '%{$tukhoatimuser}%' 		
		)";
		if(!$rs = $this->db->query($sql)) die( $this->db->error);		
		$row = $rs->fetch_row();
		$totalrows=$row[0];
		return $data;
	}
	function laygroupuser(){
        $sql="SELECT * FROM groupuser order by thutu";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		$data=array();
	    while ($row= $kq ->fetch_assoc()) $data[] =	$row;
        return $data;        
    }
	function laytengroupuser($idgroup){
        if ($idgroup==0) return "Không có";
        $sql="SELECT tengroup FROM groupuser WHERE idgroup=$idgroup";
		if (!$kq= $this->db->query($sql)) die($this->db->error);	
		if ($kq->num_rows>0) {
			$row = $kq->fetch_row();
			return $row[0];		
		} else return "Không có";
    }
	function user_them(&$loi){
		$username = trim(strip_tags($_POST['username']));
        $password = trim(strip_tags($_POST['password'])); 
        $repassword = trim(strip_tags($_POST['repassword']));
        $hoten = trim(strip_tags($_POST['hoten']));
		$email = trim(strip_tags($_POST['email'])); 
        $diachi = trim(strip_tags($_POST['diachi']));
        $dienthoai = trim(strip_tags($_POST['dienthoai']));
        $ngaysinh = strip_tags($_POST['ngaysinh']);
        $gioitinh = $_POST['gioitinh']; settype($gioitinh, "int");
        $active = $_POST['active']; settype($active, "int");
        $idgroup = $_POST['idgroup']; settype($idgroup, "int");
		
        $loi=array();				
        if ($username=="") $loi['username']="Chưa nhập usernme<br/>";
		else if ($this->codaunhay($username)==true) $loi['username']="Username không được chứa dấu ' và \" <br/>";
        else if (strlen($username)<3) $loi['username']="Username quá ngắn<br/>";
        else if ($this->username_exitst($username)==true) $loi['username'] = "Username đã có<br/>";

        if ($email=="") $loi['email']="Chưa nhập email<br/>";
        else if (filter_var($email,FILTER_VALIDATE_EMAIL)==false) $loi['email']="Email không hợp lệ<br/>";
        else if ($this->email_exitst($email)==true) $loi['email']="Email đã có<br/>";
        
        if ($hoten=="") $loi['hoten']="Chưa nhập họ tên<br/>";        
        else if ($this->codaunhay($hoten)==true) $loi['hoten']="Họ tên không được chứa dấu ' và \" <br/>";
		
        if ($password=="") $loi['password']="Chưa nhập mật khẩu<br/>";
        else if ($this->codaunhay($password)==true) $loi['password']="Password không được chứa dấu ' và \" <br/>";
		else if (strlen($password)<6) $loi['password']="Mật khẩu quá ngắn<br/>";
        else if ($password!=$repassword) $loi['password']="Mật khẩu hai lần nhập không giống nhau<br/>";
        
		if ($this->codaunhay($diachi)==true) $loi['diachi']="Địa chỉ không được chứa dấu ' và \" <br/>";
		if ($this->codaunhay($dienthoai)==true) $loi['dienthoai']="Điện thoại không được chứa dấu ' và \" <br/>";
		if ($this->codaunhay($ngaysinh)==true) $loi['ngaysinh']="Ngày sinh không được chứa dấu ' và \" <br/>";
		else if ($this->kiemtradangngay($ngaysinh)==false) $loi['ngaysinh'] ="Ngày sinh không hợp lệ";
        if (count($loi)>0) return false;
		
		$salt = substr(md5(rand(0,999)),0,3);
        $password=md5($password.$salt);		
		$sql= "INSERT INTO users SET username=?, password=?, salt=?,hoten=?,email=?,diachi=?, dienthoai=?, ngaysinh=STR_TO_DATE(?,'%d/%m/%Y'), gioitinh=?, active=?, idgroup=?, ngaydangky=now()";
        try{            
    		$st = $this->db->prepare($sql);
    		$st->bind_param('ssssssssiii', $username, $password,$salt,$hoten,$email,$diachi,$dienthoai,$ngaysinh,$gioitinh,$active,$idgroup); 
			$kq= $st->execute();
    		if ($kq==false) throw new Exception($st->error);  
			else return true;
        } catch (Exception $e) {  
            $_SESSION['message_title']="Lỗi khi thêm user: ";
            $_SESSION['message_content']= $e->getMessage();
            return false; 
        }          
        return true;
	}
	function username_exitst($username){
   	    $sql="SELECT username FROM users WHERE username='{$username}'";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		if ($kq->num_rows>0) return true; else return false;		
    }
    function email_exitst($email){
   	    $sql="SELECT email FROM users WHERE email='{$email}'";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		if ($kq->num_rows>0) return true; else return false;		
    }
	function kiemtradangngay($str){
		$arr = explode("/",$str);
		if (count($arr)<=2) return false;
		$d=$arr[0]; $m=$arr[1]; $y=$arr[2];		
		if (checkdate($m,$d,$y)==false) return false;
		else return true;
	}
	public function chitietuser($id){
		settype($id,"int");
		$sql="SELECT * FROM users WHERE iduser=$id";
		if (!$kq= $this->db->query($sql)) die($this->db->error);
		if (!$kq) return FALSE;		
		$data = $kq->fetch_assoc() ;
		return $data;		
	}
	function user_sua($id,&$loi){	
		$row = $this->chitietuser($id);
        $password = trim(strip_tags($_POST['password'])); 
        $repassword = trim(strip_tags($_POST['repassword']));
        $hoten = trim(strip_tags($_POST['hoten']));
		$email = trim(strip_tags($_POST['email'])); 
        $diachi = trim(strip_tags($_POST['diachi']));
        $dienthoai = trim(strip_tags($_POST['dienthoai']));
        $ngaysinh = strip_tags($_POST['ngaysinh']);
        $gioitinh = $_POST['gioitinh']; settype($gioitinh, "int");
        $active = $_POST['active']; settype($active, "int");
        $idgroup = $_POST['idgroup']; settype($idgroup, "int");
		
        $loi=array();

        if ($email=="") $loi['email']="Chưa nhập email<br/>";
        else if (filter_var($email,FILTER_VALIDATE_EMAIL)==false) $loi['email']="Email không hợp lệ<br/>";		
        else if (($email!=$row['email']) && ($this->email_exitst($email)==true) )
		$loi['email']="Email đã có<br/>"; //nhập email mới nhưng trùng với email đang có
        
        if ($hoten=="") $loi['hoten']="Chưa nhập họ tên<br/>";        
        else if ($this->codaunhay($hoten)==true) $loi['hoten']="Họ tên không được chứa dấu ' và \" <br/>";
		
        if ($this->codaunhay($password)==true) $loi['password']="Password không được chứa dấu ' và \" <br/>";
		else if (0<strlen($password) && strlen($password)<6) $loi['password']="Mật khẩu quá ngắn<br/>";
        else if ($password!=$repassword) $loi['password']="Mật khẩu hai lần nhập không giống nhau<br/>";
        
		if ($this->codaunhay($diachi)==true) $loi['diachi']="Địa chỉ không được chứa dấu ' và \" <br/>";
		if ($this->codaunhay($dienthoai)==true) $loi['dienthoai']="Điện thoại không được chứa dấu ' và \" <br/>";
		if ($this->codaunhay($ngaysinh)==true) $loi['ngaysinh']="Ngày sinh không được chứa dấu ' và \" <br/>";
		else if ($this->kiemtradangngay($ngaysinh)==false) $loi['ngaysinh'] ="Ngày sinh không hợp lệ";
        if (count($loi)>0) return false;     
		try{
            if ($password==""){
                $sql= "UPDATE users SET hoten=?,email=?,diachi=?, dienthoai=?, ngaysinh=STR_TO_DATE(?,'%d/%m/%Y'), 
                gioitinh=?, active=?, idgroup=? WHERE iduser=?";
                $st = $this->db->prepare($sql);
        		$st->bind_param('sssssiiii', $hoten,$email,$diachi,$dienthoai,$ngaysinh,$gioitinh,$active,$idgroup,$id);
            }
            else{
                $salt = substr(md5(rand(0,999)),0,3);
                $password=md5($password.$salt);
                $sql= "UPDATE users SET password=?, salt=?,hoten=?,email=?,diachi=?, dienthoai=?, ngaysinh=STR_TO_DATE(?,'%d/%m/%Y'), 
                gioitinh=?, active=?, idgroup=?, ngaydangky=now() WHERE iduser=?";    
                $st = $this->db->prepare($sql);
        		$st->bind_param('sssssssiiii', $password,$salt,$hoten,$email,$diachi,$dienthoai,$ngaysinh,$gioitinh,$active,$idgroup,$id);
            }    		 
    		if ($st->execute()==false) throw new Exception($st->error);        
			else return true;
        } catch (Exception $e) {              
            $_SESSION['message_title']="Lỗi khi chỉnh user: ";
            $_SESSION['message_content']= $e->getMessage();
            return false;  
        } 		
        return true;
	}
	function user_xoa($id){
		settype($id,"int");
		$sql="DELETE FROM users WHERE iduser=". $id;
		if (!$kq= $this->db->query($sql)) die($this->db->error);		
	}
}//class