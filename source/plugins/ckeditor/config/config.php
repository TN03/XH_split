<?php

$plugin_cf['ckeditor']['toolbar']="full";
$plugin_cf['ckeditor']['skin']="moono-lisa";
$plugin_cf['ckeditor']['language']="CMSimple";
$plugin_cf['ckeditor']['filebrowser_window_width']="'80%'";
$plugin_cf['ckeditor']['filebrowser_window_height']="'70%'";
$plugin_cf['ckeditor']['format_tags']="p;h1;h2;h3;h4;h5;h6;pre;address;div";
$plugin_cf['ckeditor']['format_fonts']="'Arial/Arial, Helvetica, sans-serif;' +\r\n'Comic Sans MS/Comic Sans MS, cursive;' +\r\n'Courier New/Courier New, Courier, monospace;' +\r\n'Georgia/Georgia, serif;' +\r\n'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +\r\n'Tahoma/Tahoma, Geneva, sans-serif;' +\r\n'Times New Roman/Times New Roman, Times, serif;' +\r\n'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +\r\n'Verdana/Verdana, Geneva, sans-serif;'";
$plugin_cf['ckeditor']['format_fontsizes']="8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px";
$plugin_cf['ckeditor']['toolbarset_full']="CKEDITOR.editorConfig = function( config ) {\r\n\tconfig.toolbarGroups = [\r\n\t\t{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },\r\n\t\t{ name: 'tools', groups: [ 'tools' ] },\r\n\t\t{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },\r\n\t\t{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },\r\n\t\t{ name: 'forms', groups: [ 'forms' ] },\r\n\t\t{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },\r\n\t\t{ name: 'colors', groups: [ 'colors' ] },\r\n\t\t{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },\r\n\t\t{ name: 'links', groups: [ 'links' ] },\r\n\t\t{ name: 'insert', groups: [ 'insert' ] },\r\n\t\t{ name: 'styles', groups: [ 'styles' ] },\r\n\t\t{ name: 'others', groups: [ 'others' ] },\r\n\t\t{ name: 'about', groups: [ 'about' ] }\r\n\t];\r\n\tconfig.removeButtons = 'BidiLtr,BidiRtl';\r\n};";
$plugin_cf['ckeditor']['toolbarset_medium']="CKEDITOR.editorConfig = function( config ) {\r\n\tconfig.toolbar = [\r\n\t\t{ name: 'document', items: [ 'Source', '-', 'Save', '-', 'Templates' ] },\r\n\t\t\r\n\t\t{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },\r\n\t\t{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'InsertPre' ] },\r\n\t\t'/',\r\n\t\t{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },\r\n\t\t{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },\r\n\t\t{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },\r\n\t\t{ name: 'about', items: [ 'About' ] }\r\n\t];\r\n};";
$plugin_cf['ckeditor']['toolbarset_minimal']="";
$plugin_cf['ckeditor']['toolbarset_sidebar']="";
$plugin_cf['ckeditor']['autogrow_enabled']="true";
$plugin_cf['ckeditor']['autogrow_on_startup']="true";
$plugin_cf['ckeditor']['plugins_remove']="pagebreak";
$plugin_cf['ckeditor']['configuration_additional_options']="//add here any additional settings you need\r\n//(remember: no komma after last entry),\r\n//for example:\r\n//autoGrow_maxHeight : 2000,\r\n//autoGrow_bottomSpace : 100,\r\nautoGrow_minHeight : 600";

?>
