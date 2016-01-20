<script src="<?php echo BASE_DIR?>js/ckfinder/ckfinder.js" type="text/javascript"></script>
<script type="text/javascript">
var api;
function BrowseServer( startupPath, functionData ){
	var finder = new CKFinder();
	finder.basePath = '<?php echo BASE_DIR?>js/ckfinder/'; //Đường path nơi đặt ckfinder
	finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
	finder.selectActionFunction = SetFileField;//hàm được gọi khi chọn 1 file 
	finder.selectActionData = functionData; //id của textfield hiện địa chỉ hình
	api = finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer
function SetFileField( fileUrl, data ){
    if (data["selectActionData"] =="hinhdaidien"){
        document.getElementById( data["selectActionData"] ).value = fileUrl;     
    }else {
        var arr=api.getSelectedFiles();            
        for (i = 0; i< arr.length; i++) {
            document.getElementById( data["selectActionData"] ).value+=","+ arr[i].getUrl();
            var c= "<img src="+ arr[i].getUrl()+" width=120 height=90 align=left title='Nhắp vào để xóa'>";
            $("#imgcontainer").append(c);
        }
        $("#imgcontainer img").click(function(){            
            var url=","+$(this).attr("src");
            var str= document.getElementById("hinhtrongalbum").value.replace(url,"");
            document.getElementById("hinhtrongalbum").value=str;
            $(this).remove();
        })
    }
}
$(document).ready(function(){
    var arr= document.getElementById("hinhtrongalbum").value.split(",");
    for(i=0;i<arr.length;i++){
        if (arr[i]!="") {
            var c= "<img src="+ arr[i]+" width=120 height=90 align=left title='"+arr[i]+". Nhắp vào để xóa'>";
            $("#imgcontainer").append(c);           
        }        
    }
    $("#imgcontainer img").click(function(){            
            var url=","+$(this).attr("src");
            var str= document.getElementById("hinhtrongalbum").value.replace(url,"");
            document.getElementById("hinhtrongalbum").value=str;
            $(this).remove();
    })
    
})
</script>

<form action="" method="post" id="formalbum" class=form enctype="multipart/form-data">
	<h4>SỬA ALBUM</h4>
	<p><span>Tên Album</span><input class=txt type=text name=ten id=ten value="<?php echo $row['tenalbum']?>"></p>
	<p><span>Mô tả</span><textarea class=txt name=mota id=mota rows=5></textarea>
	<p><span>Thứ tự</span><input class=txt type=text name=thutu id=thutu value="<?php echo $row['thutu']?>"></p>
	<p><span>Ẩn hiện</span>
    <input type=radio name=anhien id=anhien value=0 <?php echo ($row['anhien']==0)?"checked":""?>>Ẩn 
	<input type=radio name=anhien id=anhien value=1 <?php echo ($row['anhien']==1)?"checked":""?>>Hiện</p>
	<p><span>Hình album</span>
    <input class=txt type=text name=hinhdaidien id=hinhdaidien onclick="BrowseServer('Images:/','hinhdaidien')" value="<?php echo $row['hinhdaidien']?>">
    </p>
	<p><span>Hình trong album</span>
    <input class=txt type=text name=hinhtrongalbum id=hinhtrongalbum onclick="BrowseServer('Images:/','hinhtrongalbum')" value="<?php echo $row['hinhtrongalbum']?>">
    </p>
	<p align=center><input value=" SỬA " type=submit name=btn id=btn ></p>
	<div id="imgcontainer"></div>
    <div style="clear: left;"></div>
</form>