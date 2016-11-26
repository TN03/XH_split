<?php

/**
 * @version $Id: ucfirst.php 4 2012-08-07 21:08:48Z cmb69 $
 * @package utf8
 * @subpackage strings
 */


/**
 * UTF-8 aware alternative to ucfirst
 * 
 * Make a string's first character uppercase
 * Note: requires utf8_strtoupper
 * 
 * @param   string
 * @return  string with first character as upper case (if applicable)
 * @link    http://www.php.net/ucfirst
 * @see     utf8_strtoupper()
 */
function utf8_ucfirst($str){
    switch ( utf8_strlen($str) ) {
        case 0:
            return '';
        break;
        case 1:
            return utf8_strtoupper($str);
        break;
        default:
            preg_match('/^(.{1})(.*)$/us', $str, $matches);
            return utf8_strtoupper($matches[1]).$matches[2];
        break;
    }
}

?>
