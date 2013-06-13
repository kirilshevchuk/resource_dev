/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.extraPlugins='jwplayer';
        config.filebrowserBrowseUrl = '/resource_dev/ckfinder/ckfinder.html',
 	config.filebrowserImageBrowseUrl = '/resource_dev/ckfinder/ckfinder.html?type=Images',
 	config.filebrowserFlashBrowseUrl = '/resource_dev/ckfinder/ckfinder.html?type=Files',
 	config.filebrowserUploadUrl = '/resource_dev/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
 	config.filebrowserImageUploadUrl = '/resource_dev/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
 	config.filebrowserFlashUploadUrl = '/resource_dev/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
        //config.extraPlugins = 'mediaembed';
     config.toolbar=	[['Source','-','Save','NewPage','Preview','-','Templates'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    ['TextColor','BGColor'],
    '/',
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],//'jwplayer',
    '/',
    ['Styles','Format','Font','FontSize'],
    ['BidiLtr', 'BidiRtl'], ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
    ['Maximize', 'ShowBlocks','-','About']]; 
     /*
   config.toolbar = 'MediaToolbar';
   config.toolbar_MediaToolbar = 
      [
         ['MediaEmbed', 'Preview'],
         ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Scayt'],
         ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat']
      ];        */
};