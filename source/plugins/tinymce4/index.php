<?php
/**
 * tinyMCE Editor - index module
 *
 * Handles establish constants to distinguish between the tinymce4 variants
 * standard, 
 * CDN (Content delivery version) hosted remote, only the language packs are
 * needed on server,or jQuery Variant (not yet realized)
 *
 * PHP version 5
 *
 * @category CMSimple_XH
 *
 * @package   Tinymce4
 * @author    The CMSimple_XH developers <devs@cmsimple-xh.org>
 * @author    manu <info@pixolution.ch>
 * @copyright 1999-2009 <http://cmsimple.org/>
 * @copyright 2009-2015 The CMSimple_XH developers <http://cmsimple-xh.org/?The_Team>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://cmsimple-xh.org/
 * @since     File available since Release 1.6.0
 */
 
 /*
 * Prevent direct access and usage from unsupported CMSimple_XH versions.
 */
if (CMSIMPLE_XH_VERSION !== '@CMSIMPLE_XH_VERSION@') {
    if (!defined('CMSIMPLE_XH_VERSION') 
        || strpos(CMSIMPLE_XH_VERSION, 'CMSimple_XH') !== 0 
        || version_compare(CMSIMPLE_XH_VERSION, 'CMSimple_XH 1.6.6', 'lt')
    ) {
        header('HTTP/1.1 403 Forbidden');
        header('Content-Type: text/plain; charset=UTF-8');
        die(
            <<<EOT
    $plugin detected an unsupported CMSimple_XH version.
    Uninstall encmail_XH or upgrade to a supported CMSimple_XH version!
EOT
        );
    }
}

define('TINYMCE4_VARIANT', '');  //TinyMCE4 fully installed
//define('TINYMCE4_VARIANT', 'CDN');  //TinyMCE4 externally loaded
//define('TINYMCE4_VARIANT', 'jQuery');  //TinyMCE4 jQuery Version not yet realized

if (TINYMCE4_VARIANT == 'CDN') {
    $plugin_cf['tinymce4']['CDN_src'] 
            = '//cdn.tinymce.com/4/tinymce.min.js';
}


/**
 * Returns all available CDN versions.
 *
 * @return array 
 */
function tinymce4GetCdnVersions()
{
    return file("http://tinymce.cachefly.net/index.txt",FILE_IGNORE_NEW_LINES);
}
?>