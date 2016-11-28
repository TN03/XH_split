
/*
 * @version $Id: init_full.js 199 2013-10-03 20:31:26Z hi $
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
	
    //Filebrowser - settings
    filebrowserWindowHeight : '70%' ,
    filebrowserWindowWidth : '80%' ,
    
    %FILEBROWSER%
    
    removePlugins : 'save,bidi', //bidi deaktiviert enthalten lassen, save muss deaktiviert enthalten bleiben
    extraPlugins : 'CMSimpleSave' //no komma after last entry

}