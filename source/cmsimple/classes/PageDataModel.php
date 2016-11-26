<?php

/**
 * The page data model.
 *
 * PHP versions 4 and 5
 *
 * @category  CMSimple_XH
 * @package   XH
 * @author    Martin Damken <kontakt@zeichenkombinat.de>
 * @author    The CMSimple_XH developers <devs@cmsimple-xh.org>
 * @copyright 1999-2009 Peter Harteg
 * @copyright 2009-2015 The CMSimple_XH developers <http://cmsimple-xh.org/?The_Team>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version   SVN: $Id: PageDataModel.php 1479 2015-01-25 20:05:20Z cmb69 $
 * @link      http://cmsimple-xh.org/
 */

/**
 * Handles the page-data-array including reading and writing of the files.
 *
 * @category CMSimple_XH
 * @package  XH
 * @author   Martin Damken <kontakt@zeichenkombinat.de>
 * @author   The CMSimple_XH developers <devs@cmsimple-xh.org>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://cmsimple-xh.org/
 *
 * @access public
 */
class XH_PageDataModel
{
    /**
     * The page headings (a copy of $h).
     *
     * @var array
     *
     * @access protected
     */
    var $headings;

    /**
     * The list of page data fields.
     *
     * @var array
     *
     * @access protected
     */
    var $params;

    /**
     * The page data.
     *
     * @var array
     *
     * @access protected
     */
    var $data;

    /**
     * The page data of the latest deleted page (recycle bin).
     *
     * @var array
     *
     * @access protected
     */
    var $temp_data;

    /**
     * The filenames of the views of page data tabs.
     *
     * @var array
     *
     * @access protected
     */
    var $tabs;

    /**
     * Constructs an instance.
     *
     * @param array $h              The page headings.
     * @param array $pageDataFields The page data fields.
     * @param array $tempData       The most recently deleted page data.
     * @param array $pageData       The page data.
     *
     * @return void
     *
     * @access public
     */
    function XH_PageDataModel($h, $pageDataFields, $tempData, $pageData)
    {
        $this->headings = $h;
        $this->params = !empty($pageDataFields)
            ? $pageDataFields
            : array('url', 'last_edit');
        $this->temp_data = $tempData;
        $this->data = $pageData;
        $this->fixUp();
    }

    /**
     * Returns all fields that are stored in the page data.
     *
     * @return array
     *
     * @since 1.6
     */
    function storedFields()
    {
        $fields = $this->params;
        $fields = array_merge($fields, array_keys($this->temp_data));
        foreach ($this->data as $page) {
            $fields = array_merge($fields, array_keys($page));
        }
        $fields = array_values(array_unique($fields));
        return $fields;
    }

    /**
     * Fixes the page data after reading.
     *
     * @return void
     *
     * @global int   The index of the current page.
     * @global array The page data of the current page.
     *
     * @access protected
     */
    function fixUp()
    {
        global $pd_s, $pd_current;

        foreach ($this->headings as $id => $value) {
            foreach ($this->params as $param) {
                if (!isset($this->data[$id][$param])) {
                    switch ($param) {
                    case 'url':
                        $this->data[$id][$param] = uenc(strip_tags($value));
                        break;
                    default:
                        $this->data[$id][$param] = '';
                    }
                }
            }
        }
        if (isset($pd_current)) {
            $pd_current = $this->data[$pd_s];
        }
    }

    /**
     * Replaces the existing page data.
     *
     * @param array $data The new page data.
     *
     * @return bool Whether the page data have been refreshed.
     *
     * @access public
     */
    function refresh($data = null)
    {
        if (isset($data)) {
            $this->data = $data;
            return $this->save();
        }
        return false;
    }

    /**
     * Registers a page data field.
     *
     * @param string $field The page data field to add.
     *
     * @return void
     *
     * @access public
     */
    function addParam($field)
    {
        $this->params[] = $field;
        $this->fixUp();
    }

    /**
     * Removes a page data field.
     *
     * @param string $field A page data field to remove.
     *
     * @return void
     *
     * @access public
     */
    function removeParam($field)
    {
        $n = array_search($field, $this->params);
        array_splice($this->params, $n, 1);
        foreach ($this->headings as $id => $value) {
            unset($this->data[$id][$field]);
        }
        unset($this->temp_data[$field]);
    }

    /**
     * Registers a page data tab.
     *
     * @param string $title     The title of the tab.
     * @param string $view_file The filename of the view.
     *
     * @return void
     *
     * @access public
     */
    function addTab($title, $view_file)
    {
        $this->tabs[$title] = $view_file;
    }

    /**
     * Returns the page data of a single page.
     *
     * @param int $key The index of the page.
     *
     * @return array
     *
     * @access public
     */
    function findKey($key)
    {
        return $key >= 0 && $key < count($this->data)
            ? $this->data[$key] : null;
    }

    /**
     * Returns the page data of all pages which contain a value in a field.
     *
     * @param string $field The name of the field.
     * @param mixed  $value The value to look for.
     *
     * @return array
     *
     * @access public
     */
    function findFieldValue($field, $value)
    {
        $results = array();
        foreach ($this->data as $id => $page) {
            if (isset($page[$field])
                && strpos($page[$field], $value) !== false
            ) {
                $results[$id] = $page;
            }
        }
        return $results;
    }

    /**
     * Returns the page data of all pages which contain a value in a list field.
     *
     * @param string $field     The name of the field.
     * @param string $value     The value to look for.
     * @param string $separator The list item separator.
     *
     * @return array
     *
     * @access public
     */
    function findArrayfieldValue($field, $value, $separator)
    {
        $results = array();
        foreach ($this->data as $id => $page) {
            $array = explode($separator, $page[$field]);

            foreach ($array as $page_data) {
                if ($value == trim($page_data)) {
                    $results[$id] = $page;
                }
            }
        }
        return $results;
    }

    /**
     * Returns the sorted page data of all pages,
     * which contain a value in a (list) field.
     *
     * @param string $field    The name of the field.
     * @param string $value    The value to look for.
     * @param string $sortKey  The name of the field to sort by.
     * @param int    $sortFlag The sort options as for array_multisort().
     * @param string $sep      The list item separator.
     *
     * @return array
     *
     * @access public
     */
    function findFieldValueSortkey($field, $value, $sortKey, $sortFlag, $sep)
    {
        if ($sep) {
            $results = $this->findArrayfieldValue($field, $value, $sep);
        } else {
            $results = $this->findFieldValue($field, $value);
        }
        $temp = array();
        $ids = array();
        foreach ($results as $key => $value) {
            $temp[] = $value[$sortKey];
            $ids[] = $key;
        }
        array_multisort($temp, $sortFlag, $ids);
        $results = array();
        if (is_array($ids) && count($ids) > 0) {
            foreach ($ids as $id) {
                $results[$id] = $this->data[$id];
            }
        }
        return $results;
    }


    /**
     * Returns the page data for a new page, without actually creating the page.
     *
     * @param array $params Default page data.
     *
     * @return array
     *
     * @access public
     */
    function create($params = array())
    {
        $clean = array();
        foreach ($this->params as $field) {
            $clean[$field] = '';
        }
        $page = array_merge($clean, $params);
        return $page;
    }

    /**
     * Appends a new page.
     *
     * @param array $params Page data of the page.
     *
     * @return void
     *
     * @access public
     *
     * @since 1.6
     */
    function appendPage($params)
    {
        $this->data[] = $params;
    }

    /**
     * Replaces the page data of a single page. Returns whether that succeeded.
     *
     * @param array $pages The new page data.
     * @param int   $index The index of the page.
     *
     * @return bool
     *
     * @access public
     */
    function replace($pages, $index)
    {
        array_splice($this->data, $index, 1, $pages);
        return $this->save();
    }


    /**
     * Stores page data in the recycle bin.
     *
     * @param array $page The page data.
     *
     * @return void
     *
     * @access protected
     */
    function storeTemp($page)
    {
        foreach ($page as $field => $value) {
            if (in_array($field, $this -> params)) {
                $this->temp_data[$field] = $value;
            }
        }
    }

    /**
     * Deletes the page data of a single page. Returns whether that succeeded.
     *
     * @param int $key The index of the page.
     *
     * @return bool
     *
     * @access public
     */
    function delete($key)
    {
        array_splice($this->data, $key, 1);
        return $this->save();
    }

    /**
     * Updates the page data of a single page and returns whether that succeeded.
     *
     * @param int   $key    The index of the page.
     * @param array $params The dictionary of fields to update.
     *
     * @return bool
     *
     * @access public
     */
    function updateKey($key, $params)
    {
        foreach ($params as $field => $value) {
            $this->data[$key][$field] = $value;
        }
        return $this->save();
    }

    /**
     * Saves the page data and returns whether that succeeded.
     *
     * @return bool
     *
     * @access public
     */
    function save()
    {
        return XH_saveContents();
    }
}

?>
