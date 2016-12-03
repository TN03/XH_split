<?php

/*
 * @version $Id: init.php 246 2015-06-10 22:00:45Z hi $
 *
 */

if (!function_exists('sv') || preg_match('/init.php/i', sv('PHP_SELF')))
    die('Access denied');

//global $adm;
//if ($adm) {

function ckeditor_filebrowser() {
    global $adm, $cf;

    $url = '';
    $config = '';

    if (!$adm) {
        return '';
    }

    //Einbindung alternativer Filebrowser, gesteuert über $cf['filebrowser']['external']
    //und den Namen des aufrufenden Editors
    if ($cf['filebrowser']['external'] != false) {
        $fbConnector = CMSIMPLE_BASE . 'plugins/' . $cf['filebrowser']['external'] . '/connectors/ckeditor/ckeditor.php';
        if (is_readable($fbConnector)) {
            include_once($fbConnector);
            $init_function = $cf['filebrowser']['external'] . '_ckeditor_init';
            if (function_exists($init_function)) {
                $config = $init_function();
                return $config;
            }
        }
    }

    //default filebrowser
    $url = CMSIMPLE_ROOT . 'plugins/filebrowser/editorbrowser.php?editor=ckeditor&prefix=' . CMSIMPLE_BASE;

    $config = "filebrowserBrowseUrl      : " . "'" . $url . "&type=downloads'," . "\n";
    $config.= "filebrowserImageBrowseUrl : " . "'" . $url . "&type=images'," . "\n";
    $config.= "filebrowserFlashBrowseUrl : " . "'" . $url . "&type=media'," . "\n";
    return $config;
}

function ckeditor_getExternalPlugins() {
    global $pth;
    $plugins = array();
    $handle = opendir($pth['folder']['plugins'] . 'ckeditor/plugins_external/');
    if(!$handle) { return $plugins; }
    while (false !== ($entry = readdir($handle))) {
        if (strpos($entry, '.') === false) {
            $plugins[] = $entry;
        }
    }
    closedir($handle);
    return $plugins;
}

function ckeditor_parseConfig($element = false, $config = false) {
    global $plugin_cf, $pth, $sl, $sn, $cf;

    $externalPlugins = ckeditor_getExternalPlugins();

    $ck_mode = '';
    $initFile = '';
    $temp = false;

    if (!$config) {
        $ck_mode = isset($plugin_cf['ckeditor']['toolbar']) && file_exists($pth['folder']['plugins']
                        . 'ckeditor/' . 'inits/init_'
                        . $plugin_cf['ckeditor']['toolbar'] . '.js') ? $plugin_cf['ckeditor']['toolbar'] : 'full';
        $initFile = $pth['folder']['plugins'] . 'ckeditor/' . 'inits/init_' . $ck_mode . '.js';
        $temp = file_get_contents($initFile);
    }

    if ($temp === false) {
        if (file_exists($pth['folder']['plugins']
                        . 'ckeditor/' . 'inits/init_' . basename($config) . '.js')) {
            $initFile = $pth['folder']['plugins']
                    . 'ckeditor/' . 'inits/init_' . basename($config) . '.js';
            $temp = file_get_contents($initFile);
        } else {
            $temp = $config;
        }
    }

    //extra plugins
    $extraPlugins = array('CMSimpleSave');
    $extraPlugins = array_merge($extraPlugins, $externalPlugins);
    $temp = str_replace('//%extraPlugins%', 'extraPlugins: \'' . implode(',', $extraPlugins) . '\',', $temp);

    //remove plugins
    $removePlugins = array();
    if ($plugin_cf['ckeditor']['plugins_remove'] != '') {
        $removePlugins = array_map('trim', explode(',', $plugin_cf['ckeditor']['plugins_remove']));
    }
    if (count($removePlugins) > 0) {
        $temp = str_replace('//%removePlugins%', 'removePlugins: \'' . implode(',', $removePlugins) . '\',', $temp);
    }

    $lang = $plugin_cf['ckeditor']['language'] == 'CMSimple' ? basename($sl) : '';
    $css = $pth['folder']['template'] . 'stylesheet.css';

    $temp = str_replace('%BASE_HREF%', 'http://' . $_SERVER['HTTP_HOST'] . $sn, $temp);
    $temp = str_replace('%STYLESHEET%', $css, $temp);

    //special handling of "autogrow" - plugin
    if ($plugin_cf['ckeditor']['autogrow_enabled'] != 'true') {
        $removePlugins[] = 'autogrow';
    } else {
        if ($plugin_cf['ckeditor']['autogrow_on_startup'] == 'true') {
            $temp = str_replace('//%autogrow_on_startup%', 'autoGrow_onStartup : true,', $temp);
        }
    }

    //additional user-defined configuration settings
    if ($plugin_cf['ckeditor']['configuration_additional_options'] != '') {
        $temp = str_replace('//%additionaConfigs%', $plugin_cf['ckeditor']['configuration_additional_options'] . ',', $temp);
    }

    //toolbar configuration & remove buttons
    $tb = $plugin_cf['ckeditor']['toolbarset_' . $ck_mode];
    $btnRemove = 'Save'; //remove original Save-Button
    if ($tb != '') {
        //only toolbar-groups?
        if (preg_match("/config.toolbarGroups\s*=\s*\[(.*?)\]/isU", $tb, $matches)) {
            $temp = str_replace('//%tbgroups%', 'toolbarGroups : [ ' . $matches[1] . '],', $temp);
        } else {
            //or groups & buttons
            if (preg_match("/config.toolbar\s*=\s*\[(.*?)\]/isU", $tb, $matches)) {
                $toolbar = str_replace('Save', 'CMSimpleSave', $matches[1]);
                $temp = str_replace('//%tbgroups%', 'toolbar : [ ' . $toolbar . '],', $temp);
            }
        }
        if (preg_match("/config.removeButtons\s*=\s*'(.*)';/i", $tb, $matches)) {
            $btnRemove .= ',' . $matches[1];
        }
    }
    $temp = str_replace('//%rmbuttons%', 'removeButtons : \'' . $btnRemove . '\',', $temp);



    if ($element == 'xh-editor') {
        $temp = str_replace('//%height%', 'height: ' . $cf['editor']['height'] . ',', $temp);
    }

    $temp = str_replace('//%FbWinW%', 'filebrowserWindowWidth: ' . $plugin_cf['ckeditor']['filebrowser_window_width'] . ',', $temp);
    $temp = str_replace('//%FbWinH%', 'filebrowserWindowHeight: ' . $plugin_cf['ckeditor']['filebrowser_window_height'] . ',', $temp);
    $temp = str_replace('%LANGUAGE%', $lang, $temp);
    $temp = str_replace('%SKIN%', $plugin_cf['ckeditor']['skin'], $temp);
    $temp = str_replace('%FORMAT_TAGS%', $plugin_cf['ckeditor']['format_tags'], $temp);
    $temp = str_replace('%FORMAT_FONTS%', $plugin_cf['ckeditor']['format_fonts'], $temp);
    $temp = str_replace('%FORMAT_FONTSIZES%', $plugin_cf['ckeditor']['format_fontsizes'], $temp);
    $temp = str_replace('//%FILEBROWSER%', ckeditor_filebrowser(), $temp);

    return $temp;
}

function ckeditor_iLinks() {
    global $adm, $hjs, $h, $u, $l, $sn, $pth;

    if (!$adm) {
        return '';
    } //i-Links only in admin-mode

    static $included = FALSE;
    if ($included) {
        return;
    }

    $included = TRUE;
    $hjs .='
        <script language="javascript" type="text/javascript" src="' . $pth['folder']['plugins'] . 'ckeditor/ckeditor_ilinks.js"></script>
        ';
    include_once $pth['folder']['plugins'] . 'ckeditor/' . 'links.php';
    $temp = 'var CMSLinkList = new Array(' . ckeditorGetInternalLinks($h, $u, $l, $sn, $pth['folder']['downloads']) . ');';
    return $temp;
}

function include_ckeditor() {
    global $cf, $pth, $hjs;
    static $again = FALSE;
    if ($again) {
        return;
    }
    $again = TRUE;
    $hjs .='
        <script language="javascript" type="text/javascript" src="' . $pth['folder']['plugins'] . 'ckeditor/' . 'ckeditor/ckeditor.js"></script>
        ';

    $hjs .= '<script language="javascript" type="text/javascript" src="' . $pth['folder']['plugins'] . 'ckeditor/init.js"></script>' . "\n";

    $externalPlugins = ckeditor_getExternalPlugins();
    if (count($externalPlugins) > 0) {
        $pjs = '';
        foreach ($externalPlugins as $plugin) {
            $pjs .= 'CKEDITOR.plugins.addExternal(\'' . $plugin . '\', \'../plugins_external/' . $plugin . '/\');' . PHP_EOL;
        }
        $hjs .= '<script type="text/javascript">
			/* <![CDATA[ */
                            ' . $pjs . '
			/* ]]> */
		</script>';
    }

    if (!preg_match('/true/i', $cf['xhtml']['endtags'])) {
        $hjs .= '<script type="text/javascript">
                    /* <![CDATA[ */
			CKEDITOR.on( \'instanceReady\', function( ev )
			{
                            // Ends self closing tags the HTML4 way, like <br>.
                            ev.editor.dataProcessor.writer.selfClosingEnd = \'>\';
			});
                    /* ]]> */
		</script>';
    }
}

function ckeditor_replace($elementID = false, $config = '') {
    if (!$elementID) {
        return;
    }
    $temp = ckeditor_parseConfig($elementID, $config);
    $linkList = ckeditor_iLinks();

    return
            $linkList . '
			CKEDITOR.replace( "' . $elementID . '", ' . $temp . ');
		';
}

function init_ckeditor($classes = array(), $config = false) {
    global $pth, $hjs, $onload;
    static $run = 0;

    $temp = false;
    $initClasses = 'xh-editor';
    if (is_array($classes) && (bool) $classes) {
        $initClasses = implode('|', $classes);
    }

    include_ckeditor();
    $temp = ckeditor_parseConfig($initClasses, $config);

    /*
      if (!$run) {
      $hjs .= '<script type="text/javascript" src="'.$pth['folder']['plugins'].'ckeditor/init.js"></script>'."\n";
      }
     */

    $linkList = ckeditor_iLinks();

    $hjs .= <<<SCRIPT
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$linkList
function CKeditor_initialize$run() {
    CKeditor_instantiateByClasses('$initClasses', $temp);
}
/* ]]> */
</script>

SCRIPT;

    $onload .= 'CKeditor_initialize' . $run . '();';
    $run++;
    return;
}

//} //if $adm
/*
 * End of file plugins/ckeditor/init.php
 */