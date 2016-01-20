<?php
session_start();
function CheckAuthentication()
{
	return isset($_SESSION['login_id']) &&  ($_SESSION['login_level']==4 || $_SESSION['login_level']==3);
}
$config['LicenseName'] = '';
$config['LicenseKey'] = '';
$baseUrl = '/';
$baseDir = resolveUrl($baseUrl);

$config['Thumbnails'] = Array(
		'url' => $baseUrl . '_thumbs',
		'directory' => $baseDir . '_thumbs',
		'enabled' => true,
		'directAccess' => false,
		'maxWidth' => 100,
		'maxHeight' => 100,
		'bmpSupported' => false,
		'quality' => 80);

$config['Images'] = Array(
		'maxWidth' => 1600,
		'maxHeight' => 1200,
		'quality' => 80);

$config['RoleSessionVar'] = 'CKFinder_UserRole';
$config['AccessControl'][] = Array(
		'role' => '*',
		'resourceType' => '*',
		'folder' => '/',

		'folderView' => true,
		'folderCreate' => true,
		'folderRename' => true,
		'folderDelete' => true,

		'fileView' => true,
		'fileUpload' => true,
		'fileRename' => true,
		'fileDelete' => true);

$config['DefaultResourceTypes'] = '';

$config['ResourceType'][] = Array(
		'name' => 'Files',				// Single quotes not allowed
		'url' => $baseUrl . 'files',
		'directory' => $baseDir . 'files',
		'maxSize' => 0,
		'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
		'deniedExtensions' => '');

$config['ResourceType'][] = Array(
		'name' => 'Images',
		'url' => $baseUrl . 'images',
		'directory' => $baseDir . 'images',
		'maxSize' => 0,
		'allowedExtensions' => 'bmp,gif,jpeg,jpg,png',
		'deniedExtensions' => '');
$config['ResourceType'][] = Array(
		'name' => 'hinh',
		'url' => $baseUrl . 'hinh',
		'directory' => $baseDir . 'hinh',
		'maxSize' => 0,
		'allowedExtensions' => 'bmp,gif,jpeg,jpg,png,zip',
		'deniedExtensions' => '');
$config['ResourceType'][] = Array(
		'name' => 'hinh-bai-viet',
		'url' => $baseUrl . 'hinh-bai-viet',
		'directory' => $baseDir . 'hinh-bai-viet',
		'maxSize' => 0,
		'allowedExtensions' => 'bmp,gif,jpeg,jpg,png,zip',
		'deniedExtensions' => '');
$config['ResourceType'][] = Array(
		'name' => 'Mp3',				// Single quotes not allowed
		'url' => '/mp3',
		'directory' => resolveUrl('/mp3/'),
		'maxSize' => 0,
		'allowedExtensions' => 'mp3,wav,wma,zip',
		'deniedExtensions' => '');

$config['CheckDoubleExtension'] = true;
$config['DisallowUnsafeCharacters'] = false;
$config['FilesystemEncoding'] = 'UTF-8';
$config['SecureImageUploads'] = true;
$config['CheckSizeAfterScaling'] = true;
$config['HtmlExtensions'] = array('html', 'htm', 'xml', 'js');
$config['HideFolders'] = Array(".*", "CVS");
$config['HideFiles'] = Array(".*");
$config['ChmodFiles'] = 0777 ;
$config['ChmodFolders'] = 0755 ;
$config['ForceAscii'] = false;
$config['XSendfile'] = false;

include_once "plugins/imageresize/plugin.php";
include_once "plugins/fileeditor/plugin.php";
include_once "plugins/zip/plugin.php";

$config['plugin_imageresize']['smallThumb'] = '90x90';
$config['plugin_imageresize']['mediumThumb'] = '120x120';
$config['plugin_imageresize']['largeThumb'] = '180x180';
