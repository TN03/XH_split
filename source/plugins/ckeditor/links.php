<?php

/*
 * @version $Id: links.php 138 2013-05-30 17:22:31Z hi $
 *
 */

if (!function_exists('sv') || preg_match('/links.php/i', sv('PHP_SELF')))die('Access denied');

/*
function cke_get_images($directory) {

    $files = array();
    $handle = opendir($directory);
    if(!$handle) { return ''; }

    $i = 0;
    
        while (false !== ($file = readdir($handle))) {
            if (preg_match("/(\.jpg$|\.gif$|\.png$|\.jpeg$)/", $file)) {
                $files[$i]['name'] = $file;
                $files[$i]['path'] = $directory . "" . $file;
                $i++;
            }
        }
    

    closedir($handle);

    sort($files);
    $list = '';
    foreach ($files as $i) {
        $list .='["' . ($i['name']) . '", "' . ($i['path']) . '"],';
    }
    $list = substr($list, 0, -1); // strip the last ","
    return($list);
}
*/

function ckeditorGetInternalLinks($h, $u, $l, $sn, $downloads_path) {
    $list = '';
	$list .= '["Links:",""],';
    for ($i = 0; $i < count($h); $i++) {
        $spacer = '--';
        if ($l[$i] > 1) {
            $spacer = str_repeat('----', $l[$i] - 1);  // just for indenting lower level "pages"
        }
        //$list.='["' . $spacer . ' ' . substr(str_replace('"', '&quot;', $h[$i]), 0, 30) . '", "' . $sn . '?' . $u[$i] . '"],'; //ToDo: &amp -> & ...
		//$list.='["' . $spacer . substr(str_replace('"', '&quot;', $h[$i]), 0, 30) . '", "?' . $u[$i] . '"],';
		$list.='["' . $spacer . addcslashes($h[$i], "\n\r\t\"\\") . '", "?' . $u[$i] . '"],';
    }
    if (@is_dir($downloads_path)) {
        $list .= '["DOWNLOADS:",""],';
        $fs = sortdir($downloads_path);
        foreach ($fs as $p) {
            if (preg_match("/.+\..+$/", $p)) {
                $list .= '["-- ' . substr($p, 0, 25) . ' (' . (round((filesize($downloads_path . '/' . $p)) / 102.4) / 10) . ' KB)", "./?download=' . $p . '"],';
            }
        }
    }
    $list = substr($list, 0, -1);
    return($list);
}
