/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

					//config.extraPlugins = 'tableresize';
					config.extraPlugins = 'image';
					config.extraPlugins = 'dialog';
					config.extraPlugins = 'link';
					config.extraPlugins = 'wsc';
					config.extraPlugins = 'scayt';
					config.language = 'ro';
					config.skin = 'kama';

					

    config.filebrowserBrowseUrl          = '/GENERAL/js/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl     = '/GENERAL/js/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl     = '/GENERAL/js/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl          = '/GENERAL/js/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl     = '/GENERAL/js/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl     = '/GENERAL/js/kcfinder/upload.php?type=flash';

 config.toolbar = 'Full';
	config.toolbar_Comoti =
[
	{ name: 'document', items : [ 'Print'] },
	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	{ name: 'links', items : [ 'Link','Unlink' ] },
	{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','SpecialChar' ] },
	'/',
	{ name: 'styles', items : [ 'Font','FontSize' ] },
	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-',
									'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
	{ name: 'colors', items : [ 'TextColor','BGColor' ] }
];
    config.toolbar_smallTOOL =
    [

        { name: 'clipboard', items : [ 'Cut','Copy','Paste'] },
        { name: 'styles', items : [ 'Font','FontSize' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','RemoveFormat' ] },
        { name: 'paragraph', items : ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'colors', items : [ 'TextColor','BGColor' ] }
    ];
//config.toolbar = 'Full';
config.toolbar_Full =
[
	{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
	{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
        'HiddenField' ] },
	'/',
	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
	'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
	{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
	'/',
	{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
];

    config.toolbar_EXTRAsmallTOOL =
      [


          { name: 'styles', items : ['FontSize' ] },
          { name: 'basicstyles', items : [ 'Bold','Italic','Underline','RemoveFormat' ] },
          { name: 'paragraph', items : ['JustifyLeft','JustifyCenter' ] },
          { name: 'colors', items : [ 'TextColor' ] }

      ];

    config.toolbar_smallTOOL =
    [


        { name: 'styles', items : [ 'Font','FontSize' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','RemoveFormat' ] },
        { name: 'paragraph', items : ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'colors', items : [ 'TextColor','BGColor' ] },
        { name: 'insert', items : [ 'Image','Flash','Table' ] }
    ];

    config.resize_enabled = true;
};
