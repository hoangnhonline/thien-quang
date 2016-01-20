/*
 * @file HTML Buttons plugin for CKEditor
 * Copyright (C) 2012 Alfonso Mart�nez de Lizarrondo
 * A simple plugin to help create custom buttons to insert HTML blocks
 */

CKEDITOR.plugins.add( 'htmlbuttons',
{
	init : function( editor )
	{
		var buttonsConfig = editor.config.htmlbuttons;
		if (!buttonsConfig)
			return;

		function createCommand( definition )
		{
			return {
				exec: function( editor ) {
					editor.insertHtml( definition.html );
				}
			};
		}

		// Create the command for each button
		for(var i=0; i<buttonsConfig.length; i++)
		{
			var button = buttonsConfig[ i ];
			var commandName = button.name;
			editor.addCommand( commandName, createCommand(button, editor) );

			editor.ui.addButton( commandName,
			{
				label : button.title,
				command : commandName,
				icon : this.path + button.icon
			});
		}
	} //Init

} );

/**
 * An array of buttons to add to the toolbar.
 * Each button is an object with these properties:
 *	name: The name of the command and the button (the one to use in the toolbar configuration)
 *	icon: The icon to use. Place them in the plugin folder
 *	html: The HTML to insert when the user clicks the button
 *	title: Title that appears while hovering the button
 *
 * Default configuration with some sample buttons:
 */
CKEDITOR.config.htmlbuttons =  [
	{
		name:'button1',
		icon:'icon1.png',
		html:'{slideshow1} hinh-danh-lam/tphcm/hoang-phap/1/ | 800 | 450| ten-chua-khong-dau {/slideshow1}',
		title:'Chèn slideshow hình'
	},
	{
		name:'button2',
		icon:'icon2.png',
		html:'{bando} HYBRID | 10.766118 | 106.641731 | 17 | 800px |450px | 10.766119 , 106.641741 , Chùa giác viên ::: 10.767820 , 106.641243 , Cửa vào ::: 10.766418 , 106.643744 , Đảo thần tiên | ABC {/bando}',
		title:'Chèn bản đồ'
	},
	{
		name:'button3',
		icon:'icon3.png',
		html:'{youtube} aaaaaaa| 800 | 450 | 1 {/youtube}',
		title:'Chèn video youtube'
	},
	{
		name:'button4',
		icon:'icon4.png',
		html:'{mp3} http://trinh-cong-son.com/nhac/CatBui_sc.mp3 {/mp3}',
		title:'Chèn mp3'
	},
	{
		name:'button5',
		icon:'icon5.png',
		html:'{playlist} 2 {/playlist}',
		title:'Chèn playlist'
	},
	{
		name:'button6',
		icon:'icon6.png',
		html:'{media} 3 {/media}',
		title:'Chèn media'
	},
	{
		name:'button7',
		icon:'icon7.png',
		html:'{bddanhlam}{/bddanhlam}',
		title:'Chèn bản đồ của danh lam hiện tại'
	},
	{
		name:'button8',
		icon:'icon8.png',
		html:'',
		title:'Chèn nhiều hình. Thực hiện như sau: Nhắp vào nút này rồi nhắp tên các file hình, sau đó nhắp nút phải chuột rồi nhắp vào chữ CHỌN  '
	},
];