
/*
 * @version $Id: init_sidebar.js 246 2015-06-10 22:00:45Z hi $
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
	
    toolbar : 'CMSimpleSidebar' ,
	
    toolbar_CMSimpleSidebar :
	[
        { name: 'document',    items : [ 'CMSimpleSave'] },
        { name: 'basicstyles', items : [ 'Bold','Italic','-','RemoveFormat' ] },
        { name: 'links',       items : [ 'Link','Unlink' ] },
        { name: 'insert',      items : [ 'Image' ] },
    ],
	
    //Filebrowser - settings
    filebrowserWindowHeight : '70%' ,
    filebrowserWindowWidth : '80%' ,

    %FILEBROWSER%
	
    //removePlugins : 'autogrow',
    extraPlugins : 'CMSimpleSave' //no komma after last entry

}