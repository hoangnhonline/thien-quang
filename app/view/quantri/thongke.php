
<div id="thongke">
<table align=center>
<tr>
<td valign=top width=50%>
<fieldset id=cacchucnang>
<legend>Các chức năng</legend>
<div id=them_baiviet class=nut><a href="<?php echo BASE_DIR?>quantri/baiviet_them">Thêm bài viết</a></div>
<div id=them_loaibaiviet class=nut><a href="<?php echo BASE_DIR?>quantri/baiviet_list">Quản lý bài viết</a></div>
<div id=them_loaibaiviet class=nut><a href="<?php echo BASE_DIR?>quantri/loaibaiviet_list">Quản lý loại bv</a></div>
<div id=them_loaibaiviet class=nut><a href="<?php echo BASE_DIR?>quantri/ykien_list">Quản lý ý kiến</a></div>
<div id=them_loaibaiviet class=nut><a href="#" onclick="BrowseServer1('hinh://',''); return false;" title="Có thể upload file zip lên rồi giải nén trên server">Upload hình</a></div>
<div id=them_loaibaiviet class=nut><a href="#" onclick="BrowseServer1('mp3://',''); return false;" title="Có thể upload file zip lên rồi giải nén trên server">Upload mp3</a></div>
<div id=them_loaibaiviet class=nut><a href="<?php echo BASE_DIR?>" target="pub">Phần Public</a></div>
<div id=them_baiviet class=nut><a href="<?php echo BASE_DIR?>quantri/video_them">Thêm Video</a></div>
</fieldset>
</td><td valign=top width=50%>
<fieldset id=thongtin>
<legend>Thống kê</legend>
<p><span>- Đang có <?php echo $this->qt->demtongsobaiviet()?> bài viết trong <?php echo $this->qt->demtongsoloaibaiviet()?> loại</span></p>
<p><span>- Có <?php echo $this->qt->demalbum()?> album </span></p>
<p><span>- Có <?php echo $this->qt->demvideotrongchude(-1)?> video </span></p>

<p><span>- <?php echo $this->qt->demuser()?> thành viên với <?php echo $this->qt->demluottruycap()?> lượt truy cập</span></p>
<p><span>- Đang có <?php echo $this->qt->demthanhvienonline()?> người đang online </span></p>
<?php $soyk= $this->qt->demykien(0);
if ($soyk>0) {?>
<p><span>- Có  
<a href="<?php echo BASE_DIR?>quantri/ykien_list/-1/0/"><?php echo $soyk?> ý kiến</a> 
chưa duyệt</span></p>
<?php }?>
</fieldset>
</td>
</tr>
</table>
</div>