/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.filebrowserBrowseUrl = '/resource_dev/ckfinder/ckfinder.html',
 	config.filebrowserImageBrowseUrl = '/resource_dev/ckfinder/ckfinder.html?type=Images',
 	config.filebrowserFlashBrowseUrl = '/resource_dev/ckfinder/ckfinder.html?type=Flash',
 	config.filebrowserUploadUrl = '/resource_dev/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
 	config.filebrowserImageUploadUrl = '/resource_dev/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
 	config.filebrowserFlashUploadUrl = '/resource_dev/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
};