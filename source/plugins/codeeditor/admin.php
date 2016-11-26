<?php

/**
 * Administration of Codeeditor_XH.
 *
 * PHP version and 5
 *
 * @category  CMSimple_XH
 * @package   Codeeditor
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2011-2015 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Codeeditor_XH
 */

/*
 * Prevent direct access and usage from unsupported CMSimple_XH versions.
 */
if (!defined('CMSIMPLE_XH_VERSION')
    || strpos(CMSIMPLE_XH_VERSION, 'CMSimple_XH') !== 0
    || version_compare(CMSIMPLE_XH_VERSION, 'CMSimple_XH 1.6', 'lt')
) {
    header('HTTP/1.1 403 Forbidden');
    header('Content-Type: text/plain; charset=UTF-8');
    die(<<<EOT
Codeeditor_XH detected an unsupported CMSimple_XH version.
Uninstall Codeeditor_XH or upgrade to a supported CMSimple_XH version!
EOT
    );
}

/**
 * The version number.
 */
define('CODEEDITOR_VERSION', '1.1');

/**
 * Returns all available themes.
 *
 * @return array
 */
function Codeeditor_getThemes()
{
    return Codeeditor_Controller::getThemes();
}

Codeeditor_Controller::dispatch();

?>
