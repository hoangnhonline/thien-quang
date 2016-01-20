<script>
$(document).ready(function(){
	$("#btnluubox").click(function(){
		var data = $("#box_detail").serialize();
		var url="<?php echo BASE_URL?>quantri/thongtin1box/";		
		$.post(url, data, function(d){
			$.ajax({
			url:"<?php echo BASE_URL?>quantri/layboxlist/-1", cache:false,
			success:function(data){ $("#listbox").html(data); $("#box_detail")[0].reset();$("#idbox").val(""); }
			});			
			alert(d);
		})
	});
	$("#btnboqua").click(function(){
		$("#idbox").val("");
		$("#box_detail")[0].reset();
	})
})
</script>
<form action="" method="post" id="box_detail" class="boxform" >
<h4>CHI TIẾT BOX</h4>
<input type=hidden name="idbox" id="idbox"/>
<p><span>Tên box</span><input class=txt type=text name=tenbox id=tenbox></p>
<p><span>Mô tả</span><textarea name="mota" id="mota" rows=6 class="txt"></textarea></p>
<p><span>List id</span><input class=txt type=text name=listid id=listid title="id các loại hoặc id các bài viết hoặc id các tag, cách nhau bởi dấu phẩy"></p>

<p>
<span>Loại box</span>
<select name=loaibox id=loaibox class="txt">
<option value="0">Bỏ qua listid</option>
<option value="1" title="Box hiện bài viết trong các loại bạn chỉ định">listid là loại</option>
<option value="2" title="Box hiện các bài viết bạn chỉ định">listid là tin</option>
<option value="3" title="Box hiện bài viết trong các tag bạn chỉ định">listid là tag</option>
<option value="4" title="Box hiện nội dung do bạn nhập trong mô tả">box html</option>
</select>
</p>
<p><span>Số bài</span><input class=txt type=text name=sobai id=sobai value="10" title="Số bài viết sẽ hiện trong box"></p>
<p>
<span>Hiện bài</span>
<select name=hienthibai id=hienthibai class="txt" title="Các thông tin sẽ hiện của một bài viết">
<option value="0" title="Tiêu đề" >Tiêu đề</option>
<option value="1" title="Tiêu đề+ Tooltip" >Tiêu đề + Tooltip</option>
<option value="2" title="Tiêu đề+ Tóm tắt" >Tiêu đề+ Tóm tắt</option>
<option value="3" title="Tiêu đề + Hình + Tóm tắt" >Tiêu đề + Hình + Tóm tắt</option>
<option value="4" title="Hình + Tiêu đề" >Hình + Tiêu đề</option>
<option value="5" title="Hình + Tiêu đề + Tóm tắt" >Hình + Tiêu đề + Tóm tắt</option>
<option value="6" title="Hình + Tóm tắt" >Hình  + Tóm tắt</option>
<option value="7" title="Hình" >Hình</option>
</select>
</p>

<p>
<span>Nổi bật</span>
<select name=noibat id=noibat class="txt">
<option value="0" title="Hiện các bài viết bình thường và nổi bật">Bình thường + nổi bật</option>
<option value="1" title="Chỉ hiện các bài viết nổi bật">Nổi bật</option>
<option value="2" title="Chỉ hiện các bài viết bình thường">Bình thường</option>
</select>
</p>
<p>
<span>Sắp xếp</span>
<select name=sapxep id=sapxep class="txt">
<option value="0" title="Hiện các bài viết bình thường và nổi bật">Không sắp xếp</option>
<option value="1" title="Sắp xếp bài viết theo ngày tăng dần">Ngày tăng dần</option>
<option value="2" title="Sắp xếp bài viết theo ngày giảm dần">Ngày giảm dần</option>
<option value="3" title="Sắp xếp bài viết theo số lần xem tăng dần">Solanxem tăng dần</option>
<option value="4" title="Sắp xếp bài viết theo số lần xem giảm dần">Solanxem giảm dần</option>
</select>
</p>
<span>Hiện tên</span>
<input type="radio" name="hientenbox" value=0 id="antenbox">Ẩn tên box
<input type="radio" name="hientenbox" value=1 id="hientenbox" checked>Hiện tên box
</p>
<p>
<span>Ẩn hiện</span>
<input type="radio" name="anhien" value=0 id="anbox">Ẩn box
<input type="radio" name="anhien" value=1 id="hienbox" checked>Hiện box
</p>
<p>

<p align=center>
<input value=" BỎ QUA " type=button name="btnboqua" id="btnboqua" >
<input value=" LƯU BOX " type=button name="btnluubox" id="btnluubox" >
</p>

</form>