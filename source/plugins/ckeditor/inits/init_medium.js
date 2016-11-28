
/*
 * @version $Id: init_medium.js 246 2015-06-10 22:00:45Z hi $
 *
 */

{

    baseHref : '%BASE_HREF%',
    contentsCss : '%STYLESHEET%',
    //remove default styles
    stylesSet : [],
    height : '%EDITOR_HEIGHT%',
    defaultLanguage : 'en',
    language : '%LANGUAGE%',
    skin: '%SKIN%',
    autoGrow_onStartup : true,
    toolbarCanCollapse : true,
	
    entities : false,
    entities_latin : false,
    entities_greek : false,
    entities_additional : '', // '#39' (The single quote (') character.) 
	
    format_tags : '%FORMAT_TAGS%',
    
    font_names : %FORMAT_FONTS%,
    
    fontSize_sizes : '%FORMAT_FONTSIZES%',
	
    toolbar : 'CMSimpleMedium' ,
	
    toolbar_CMSimpleMedium :
	[
	{ name: 'document',    items : [ 'CMSimpleSave','-','Source','-','Maximize', 'ShowBlocks'] },
        { name: 'clipboard',   items : [ 'Undo','Redo' ] },
	// '/',
        { name: 'basicstyles', items : [ 'Bold','Italic','-','RemoveFormat' ] },
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
        { name: 'links',       items : [ 'Link','Unlink' ] },
        { name: 'insert',      items : [ 'Image','Table','HorizontalRule','SpecialChar' ] },
        { name: 'about',       items : [ 'About' ] },
	// '/',
        { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] }
    ],
	
    //Filebrowser - settings
    filebrowserWindowHeight : '70%' ,
    filebrowserWindowWidth : '80%' ,

    %FILEBROWSER%
	
    //removePlugins : 'autogrow',
    extraPlugins : 'CMSimpleSave' //no komma after last entry

}