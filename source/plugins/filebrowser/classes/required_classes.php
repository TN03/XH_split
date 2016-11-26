<?php

/**
 * Internal Filebrowser -- required_classes.php
 *
 * PHP versions 4 and 5
 *
 * @category  CMSimple_XH
 * @package   Filebrowser
 * @author    Martin Damken <kontakt@zeichenkombinat.de>
 * @author    The CMSimple_XH developers <devs@cmsimple-xh.org>
 * @copyright 2009-2015 The CMSimple_XH developers <http://cmsimple-xh.org/?The_Team>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version   SVN: $Id: required_classes.php 1479 2015-01-25 20:05:20Z cmb69 $
 * @link      http://cmsimple-xh.org/
 */

/*
 * Prevent direct access.
 */
if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * The controller class.
 */
require_once $pth['folder']['plugin_classes'] . 'Filebrowser_Controller.php';

/**
 * The view class.
 */
require_once $pth['folder']['plugin_classes'] . 'Filebrowser_View.php';

?>
