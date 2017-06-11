/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	//config.extraPlugins = 'uploadimage';
	//config.uploadUrl = '/uploader/upload.php';
	config.filebrowserBrowseUrl = '../admin/kcfinder/browse.php?opener=ckeditor&type=files';
   config.filebrowserImageBrowseUrl = '../admin/kcfinder/browse.php?opener=ckeditor&type=images';
   config.filebrowserFlashBrowseUrl = '../admin/kcfinder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = '../admin/kcfinder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = '../admin/kcfinder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = '../admin/kcfinder/upload.php?opener=ckeditor&type=flash';
};  
