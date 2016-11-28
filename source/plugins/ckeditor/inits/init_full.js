
/*
 * @version $Id: init_full.js 246 2015-06-10 22:00:45Z hi $
 *
 */

{
    baseHref : '%BASE_HREF%',
    contentsCss : '%STYLESHEET%',
    //remove default styles
    stylesSet : [],
    //%height%
    defaultLanguage : 'en',
    language : '%LANGUAGE%',
    skin: '%SKIN%',
    //%autogrow_on_startup%
    toolbarCanCollapse : true,
	
    entities : false,
    entities_latin : false,
    entities_greek : false,
    entities_additional : '', // '#39' (The single quote (') character.) 
    
    //%tbgroups%
    
    //%rmbuttons%
    	
    //Filebrowser - settings
    //%FbWinW%
    //%FbWinH%
    //%FILEBROWSER%
    //%removePlugins%
    //%extraPlugins%
    //extraPlugins : 'CMSimpleSave,fixed' //no komma after last entry
    //%additionaConfigs%
    format_tags : '%FORMAT_TAGS%',
    font_names : %FORMAT_FONTS%,
    fontSize_sizes : '%FORMAT_FONTSIZES%'
}