CKEDITOR.editorConfig = function( config ) {
	//config.entities_latin = false;
	//config.extraPlugins = 'stylescombo,htmlbuttons';
	config.stylesSet = 'my_styles';
	config.language = 'vi';	
	config.skin= 'office2013';
	config.uiColor= '#11752C';
	config.height ='400px';
	config.entities_latin = false;
	
	config.extraPlugins = 'stylescombo';
	config.extraPlugins='htmlbuttons'; 
	config.toolbar = [
	[ 'Source', 'Cut', 'Copy', 'Paste', 'PasteText' ] , 
	[ 'Find', 'Replace', '-', 'SelectAll', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat','Link', 'Unlink', 'Table', 'HorizontalRule' ] ,
	[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] ,
	[ 'Smiley', 'SpecialChar', 'Iframe' ] ,
	[ 'Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor', 'Maximize', 'ShowBlocks', 'Flash','Image','button1','button2','button3','button4','button5','button6','button7','button8' ],
	];
};
CKEDITOR.stylesSet.add( 'my_styles', [    
    { name: 'Không định dạng', element: 'p', attributes: { 'class': 'auto' }, styles:{'*':'initial'} }, 
    { name: 'TiêuĐềBài(20px)', element: 'h3', attributes: { 'class': 'tieudebv' } }, 
	{ name: 'TiêuĐềBài(18px)', element: 'p', attributes: { 'class': 'tieudebvNho' } }, 
	{ name: 'TácGiả(Phải)', element: 'p', attributes: { 'class': 'tacgiabvCanhPhai' } },
	{ name: 'TácGiả(Giữa)', element: 'p', attributes: { 'class': 'tacgiabvCanhGiua' } },
	{ name: 'Chữ đậm', element: 'p', styles: { 'font-weight': 'Bold' } },
	{ name: 'Chữ đậm giữa' , element: 'p', attributes:{'class':'chuDamGiua' } },
	{ name: 'Chữ nghiêng' , element: 'p', attributes:{'class': 'chuNghieng' } },	
	{ name: 'Nguồn' , element: 'p', attributes: { 'class': 'nguonBV'} },	 
] );