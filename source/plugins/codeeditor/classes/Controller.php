<?php

/**
 * The plugin controller.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Codeeditor
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2011-2015 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Codeeditor_XH
 */

/**
 * The plugin controller.
 *
 * @category CMSimple_XH
 * @package  Codeeditor
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Codeeditor_XH
 */
class Codeeditor_Controller
{
    /**
     * Dispatches on plugin related requests.
     *
     * @return void
     *
     * @global array The configuration of the plugins.
     */
    static function dispatch()
    {
        global $plugin_cf;

        if (XH_ADM) {
            if (function_exists('XH_registerStandardPluginMenuItems')) {
                XH_registerStandardPluginMenuItems(false);
            }
            if ($plugin_cf['codeeditor']['enabled']) {
                self::main();
            }
            if (self::isAdministrationRequested()) {
                self::handleAdministration();
            }
        }
    }

    /**
     * Initializes CodeMirror for template and (plugin) stylesheets.
     *
     * @return void
     *
     * @global string (X)HTML to be inserted at the bottom of the `body' element.
     * @global string The value of the `admin' parameter.
     * @global string The value of the `action' parameter.
     * @global string The value of the `file' parameter.
     */
    static function main()
    {
        global $bjs, $admin, $action, $file;

        // TODO: is this necessary? (it doesn't hurt though)
        initvar('admin');
        initvar('action');
        initvar('file');

        if ($file == 'template' && ($action == 'edit' || $action == '')
            || $file == 'content' && ($action == 'edit' || $action == '')
        ) {
            $mode = 'php';
            $class = 'xh_file_edit';
        } elseif ($file == 'stylesheet' && ($action == 'edit' || $action == '')
            || $admin == 'plugin_stylesheet' && $action == 'plugin_text'
        ) {
            $mode = 'css';
            $class = 'xh_file_edit';
        } else {
            $mode = false;
        }

        if ($mode) {
            self::doInclude();
            $config = self::config($mode, '');
            $classes = json_encode(array($class));
            $bjs .= <<<EOS
<script type="text/javascript">
/* <![CDATA[ */
CodeMirror.on(window, "load", function() {
    codeeditor.instantiateByClasses($classes, $config);
})
/* ]]> */
</script>
EOS;
        }
    }

    /**
     * Returns whether the plugin administration has been requested.
     *
     * @return bool
     *
     * @global string Whether the plugin administration has been requested.
     */
    protected static function isAdministrationRequested()
    {
        global $codeeditor;

        return function_exists('XH_wantsPluginAdministration')
            && XH_wantsPluginAdministration('codeeditor')
            || isset($codeeditor) && $codeeditor == 'true';
    }

    /**
     * Handles the plugin administration.
     *
     * @return void
     *
     * @global string The value of the <var>admin</var> GP parameter.
     * @global string The value of the <var>action</var> GP parameter.
     * @global string The (X)HTML fragment to insert into the contents area.
     */
    protected static function handleAdministration()
    {
        global $admin, $action, $o;

        $o .= print_plugin_admin('off');
        switch ($admin) {
        case '':
            $o .= self::version() . self::systemCheck();
            break;
        default:
            $o .= plugin_admin_common($action, $admin, 'codeeditor');
        }
    }

    /**
     * Returns the plugin version information view.
     *
     * @return string The (X)HTML.
     *
     * @global array The paths of system files and folders.
     * @global array The localization of the plugins.
     */
    protected static function version()
    {
        global $pth, $plugin_tx;

        $ptx = $plugin_tx['codeeditor'];
        return '<h1>Codeeditor &ndash; '  . $ptx['label_info'] . '</h1>'
            . tag(
                'img src="' . $pth['folder']['plugins']
                . 'codeeditor/codeeditor.png" alt="' . $ptx['alt_logo']
                . '" style="float: left"'
            )
            . '<p>Version: ' . CODEEDITOR_VERSION . '</p>'
            . '<p>Codeeditor_XH is powered by '
            . '<a href="http://codemirror.net/" target="_blank">'
            . 'CodeMirror</a>.</p>'
            . '<p>Copyright &copy; 2011-2015 <a href="http://3-magi.net">'
            . 'Christoph M. Becker</a></p>'
            . '<p style="text-align:justify">This program is free software:'
            . 'you can redistribute it and/or modify'
            . ' it under the terms of the GNU General Public License as published by'
            . ' the Free Software Foundation, either version 3 of the License, or'
            . ' (at your option) any later version.</p>'
            . '<p style="text-align:justify">This program is distributed in the hope'
            . ' that it will be useful,'
            . ' but <em>without any warranty</em>; without even the implied warranty'
            . ' of <em>merchantability</em> or <em>fitness for a particular purpose'
            . '</em>.  See the GNU General Public License for more details.</p>'
            . '<p style="text-align:justify">You should have received a copy of the'
            . ' GNU General Public License'
            . ' along with this program.  If not, see'
            . ' <a href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/'
            . '</a>.</p>';
    }

    /**
     * Returns requirements information view.
     *
     * @return string The (X)HTML.
     *
     * @global array The paths of systems files and folders.
     * @global array The localization of the plugins.
     */
    protected static function systemCheck()
    {
        global $pth, $plugin_tx;

        $phpVersion = '5.2.0';
        $ptx = $plugin_tx['codeeditor'];
        $imgdir = $pth['folder']['plugins'] . 'codeeditor/images/';
        $ok = tag('img src="' . $imgdir . 'ok.png" alt="ok"');
        $warn = tag('img src="' . $imgdir . 'warn.png" alt="warning"');
        $fail = tag('img src="' . $imgdir . 'fail.png" alt="failure"');
        $o = '<h4>' . $ptx['syscheck_title'] . '</h4>'
            . (version_compare(PHP_VERSION, $phpVersion) >= 0 ? $ok : $fail)
            . '&nbsp;&nbsp;' . sprintf($ptx['syscheck_phpversion'], $phpVersion)
            . tag('br');
        foreach (array('json', 'pcre') as $ext) {
            $o .= (extension_loaded($ext) ? $ok : $fail)
                . '&nbsp;&nbsp;' . sprintf($ptx['syscheck_extension'], $ext)
                . tag('br');
        }
        $o .= tag('br');
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $pth['folder']['plugins'].'codeeditor/' . $folder;
        }
        foreach ($folders as $folder) {
            $o .= (is_writable($folder) ? $ok : $warn)
                . '&nbsp;&nbsp;' . sprintf($ptx['syscheck_writable'], $folder)
                . tag('br');
        }
        return $o;
    }

    /**
     * Returns the configuration in JSON format.
     *
     * The configuration string can be `full', `medium', `minimal', `sidebar'
     * or `' (which will use the users default configuration).
     * Other values are taken as file name or as JSON configuration object.
     *
     * @param string $mode   The syntax mode.
     * @param string $config The configuration string.
     *
     * @return string
     *
     * @global array  The paths of system files and folders.
     * @global string Error messages as (X)HTML `li' elements.
     * @global array  The configuration of the plugins.
     * @global array  The localization of the plugins.
     */
    protected static function config($mode, $config)
    {
        global $pth, $e, $plugin_cf, $plugin_tx;

        $pcf = $plugin_cf['codeeditor'];
        $ptx = $plugin_tx['codeeditor'];
        $config = trim($config);
        if (empty($config) || $config[0] != '{') {
            $std = in_array(
                $config, array('full', 'medium', 'minimal', 'sidebar', '')
            );
            $fn = $std
                ? $pth['folder']['plugins'] . 'codeeditor/inits/init.json'
                : $config;
            $config = ($config = file_get_contents($fn)) !== false ? $config : '{}';
        }
        $parsedConfig = json_decode($config, true);
        if (!is_array($parsedConfig)) {
            $e .= '<li><b>' . $ptx['error_json'] . '</b>' . tag('br')
                . (isset($fn) ? $fn : htmlspecialchars($config, ENT_QUOTES, 'UTF-8'))
                . '</li>';
            return null;
        }
        $config = $parsedConfig;
        if (!isset($config['mode']) || $config['mode'] == '%MODE%') {
            $config['mode'] = $mode;
        }
        if (!isset($config['theme']) || $config['theme'] == '%THEME%') {
            $config['theme'] = $pcf['theme'];
        }
        // We set the undocumented leaveSubmitMehtodAlone option; otherwise
        // multiple editors on the same form might trigger form submission
        // multiple times.
        $config['leaveSubmitMethodAlone'] = true;
        $config = json_encode($config);
        return $config;
    }

    /**
     * Returns the JavaScript to activate the configured filebrowser.
     *
     * @return void
     *
     * @global bool  Whether the user is logged in as admin.
     * @global array The paths of system files and folders.
     * @global array The configuration of the core.
     */
    protected static function filebrowser()
    {
        global $adm, $pth, $cf;

        // no filebrowser, if editor is called from front-end
        if (!$adm) {
            return '';
        }

        $script = '';
        if (!empty($cf['filebrowser']['external'])) {
            $connector = $pth['folder']['plugins'] . $cf['filebrowser']['external']
                . '/connectors/codeeditor/codeeditor.php';
            if (is_readable($connector)) {
                include_once $connector;
                $init = $cf['filebrowser']['external'] . '_codeeditor_init';
                if (function_exists($init)) {
                    $script = call_user_func($init);
                }
            }
        } else {
            $_SESSION['codeeditor_fb_callback'] = 'wrFilebrowser';
            $url =  $pth['folder']['plugins']
                . 'filebrowser/editorbrowser.php?editor=codeeditor&prefix='
                . CMSIMPLE_BASE . '&base=./&type=';
            $script = <<<EOS
/* <![CDATA[ */
codeeditor.filebrowser = function(type) {
    window.open("$url" + type, "codeeditor_filebrowser",
            "toolbar=no,location=no,status=no,menubar=no," +
            "scrollbars=yes,resizable=yes,width=640,height=480");
}
/* ]]> */
EOS;
        }
        return $script;
    }

    /**
     * Writes the basic JavaScript of the editor to the `head' element.
     * No editors are actually created. Multiple calls are allowed.
     * This is called from init_EDITOR() automatically, but not from
     * EDITOR_replace().
     *
     * @return void
     *
     * @global string (X)HTML to insert in the `head' element.
     * @global array  The paths of system files and folders.
     * @global array  The configuration of the plugins.
     * @global array  The localization of the plugins.
     */
    static function doInclude()
    {
        global $hjs, $pth, $plugin_cf, $plugin_tx;
        static $again = false;

        if ($again) {
            return;
        }
        $again = true;

        $pcf = $plugin_cf['codeeditor'];
        $ptx = $plugin_tx['codeeditor'];
        $dir = $pth['folder']['plugins'] . 'codeeditor/';

        $css = tag(
            'link rel="stylesheet" type="text/css" href="' . $dir
            . 'codemirror/codemirror-combined.css"'
        );
        $fn = $dir . 'codemirror/theme/' . $pcf['theme'] . '.css';
        if (file_exists($fn)) {
            $css .= tag('link rel="stylesheet" type="text/css" href="' . $fn . '"');
        }
        $text = array('confirmLeave' => $ptx['confirm_leave']);
        $text = json_encode($text);
        $filebrowser = self::filebrowser();

        $hjs .= <<<EOS
$css
<script type="text/javascript" src="{$dir}codemirror/codemirror-compressed.js">
</script>
<script type="text/javascript" src="{$dir}codeeditor.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
codeeditor.text = $text;
/* ]]> */
$filebrowser
</script>
EOS;
    }

    /**
     * Returns the JavaScript to actually instantiate a single editor a
     * `textarea' element.
     *
     * To actually create the editor, the caller has to write the the return value
     * to the (X)HTML output, properly enclosed as `script' element,
     * after the according `textarea' element,
     * or execute the return value by other means.
     *
     * @param string $elementId The id of the `textarea' element that should become
     *                          an editor instance.
     * @param string $config    The configuration string.
     *
     * @return string The JavaScript to actually create the editor.
     */
    static function replace($elementId, $config = '')
    {
        $config = self::config('php', $config);
        return "codeeditor.instantiate('$elementId', $config, true);";
    }

    /**
     * Instantiates the editor(s) on the textarea(s) given by $classes.
     * $config is exactly the same as for EDITOR_replace().
     *
     * @param string $classes The classes of the textarea(s) that should become
     *                        an editor instance.
     * @param string $config  The configuration string.
     * @param string $mode    The highlighting mode ('php' or 'css').
     *
     * @return void
     *
     * global string (X)HTML to insert at the bottom of the `body' element.
     */
    static function init($classes = array(), $config = false, $mode = 'php')
    {
        global $bjs;

        self::doInclude();
        if (empty($classes)) {
            $classes = array('xh-editor');
        }
        $classes = json_encode($classes);
        $config = self::config($mode, $config);
        $bjs .= <<<EOS
<script type="text/javascript">
/* <![CDATA[ */
CodeMirror.on(window, "load", function() {
    codeeditor.instantiateByClasses($classes, $config, true);
})
/* ]]> */
</script>

EOS;
    }

    /**
     * Returns all available themes.
     *
     * @return array
     *
     * @global array The paths of system files and folders.
     */
    static function getThemes()
    {
        global $pth;

        $themes = array('', 'default');
        $foldername = $pth['folder']['plugins'] . 'codeeditor/codemirror/theme';
        if ($dir = opendir($foldername)) {
            while (($entry = readdir($dir)) !== false) {
                if (pathinfo($entry, PATHINFO_EXTENSION) == 'css') {
                    $themes[] = basename($entry, '.css');
                }
            }
        }
        return $themes;
    }
}

?>
