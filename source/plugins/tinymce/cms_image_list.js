/**
 * @version $Id: cms_image_list.js 229 2012-07-30 13:31:07Z cmb69 $
 */

var tinyMCEImageList;

if(window.opener){

    tinyMCEImageList = window.opener.myImageList;
}
else{
    tinyMCEImageList = window.parent.myImageList;
}
