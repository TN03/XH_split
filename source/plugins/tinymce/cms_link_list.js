/**
 * @version $Id: cms_link_list.js 229 2012-07-30 13:31:07Z cmb69 $
 */

var tinyMCELinkList;

if(window.opener){

    tinyMCELinkList = window.opener.myLinkList;
}
else{
    tinyMCELinkList = window.parent.myLinkList;
}
