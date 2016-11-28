<?php

/*
 * @version $Id: admin.php 246 2015-06-10 22:00:45Z hi $
 *
 */

/*
 * ==================================================================
 * CKEditor for CMSimple_XH 1.6.+
 * ==================================================================
 * Version:    $CKEDITOR_VERSION$
 * Build:      $CKEDITOR_BUILD$
 * Released:   $CKEDITOR_DATE$
 * Copyright:  Holger Irmler - all rights reserved
 * Email:      CMSimple@HolgerIrmler.de
 * Website:    http://CMSimple.HolgerIrmler.de
 *
 * ==================================================================
 */

if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

//Helper-functions
function ckeditor_getInits() {
    global $pth;
    $inits = glob($pth['folder']['plugins'] . 'ckeditor/inits/*.js');
    $options = array();
    foreach ($inits as $init) {
        $temp = explode('_', basename($init, '.js'));
        if (isset($temp[1])) {
            $options[] = $temp[1];
        }
    }
    return $options;
}

function ckeditor_getSkins() {
    global $pth;
    $skins = array();
    $handle = opendir($pth['folder']['plugins'] . 'ckeditor/ckeditor/skins/');
    while (false !== ($entry = readdir($handle))) {
        if (strpos($entry, '.') === false) {
            $skins[] = $entry;
        }
    }
    closedir($handle);
    return $skins;
}

function ckeditor_info() {
    global $o, $pth;

    $o .= '<script type="text/javascript" src="' . $pth['folder']['plugins'] . 
            'ckeditor/ckeditor/ckeditor.js"></script>';
    $ckeditor_version = '<script type="text/javascript">'
            . 'document.write(CKEDITOR.version + " (revision " + CKEDITOR.revision + ")");'
            . '</script>';
    $ckeditor_plugins = '<script type="text/javascript">'
            . 'var ckplugins = CKEDITOR.config.plugins;'
            . 'document.write(ckplugins.split(",").sort().join(", "))</script >';
            //. 'document.write(ckplugins.replace(/,/g , ", "))</script >';
    define('CKEDITOR_4CMSIMPLE_VERSION', '$CKEDITOR_VERSION$ - $CKEDITOR_DATE$');

    $o .= '<h1>CKEditor for CMSimple_XH</h1>';
    $o .= '<p>&copy;2015 <a target="_blank" '
            . 'href="http://www.cmsimple.holgerirmler.de">Holger Irmler</a>'
            . ' - all rights reserved</p>';
    $o .= tag('img src="' . $pth['folder']['plugins'] . 'ckeditor/logo_ckeditor.png"');
    $o .= '<p>Plugin-Version: ' . CKEDITOR_4CMSIMPLE_VERSION . tag('br');
    $o .= '<p>CKEditor-Version: ' . $ckeditor_version . ' &ndash; '
            . '<a href="http://www.ckeditor.com/" target="_blank">'
            . 'http://www.ckeditor.com</a>' . tag('br')
            . 'Plugins:' . tag('br')
            . $ckeditor_plugins . '</p>';
}

/*
 * Register the plugin menu items.
 */
if (function_exists('XH_registerStandardPluginMenuItems')) {
    XH_registerStandardPluginMenuItems(false);
}

/*
 * Register the plugin type 'editor'.
 */
if (function_exists('XH_registerPluginType')) {
    XH_registerPluginType('editor', 'ckeditor');
}

/*
 * Handle the administration.
 */
if (function_exists('XH_wantsPluginAdministration') 
        && XH_wantsPluginAdministration('ckeditor') 
        || isset($ckeditor) && $ckeditor == 'true') 
    {
    $o .= print_plugin_admin('off');
    switch ($admin) {
        case '':
            $o .= ckeditor_info();
            break;
        default:
            $o .= plugin_admin_common($action, $admin, 'ckeditor');
    }
}