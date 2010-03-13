<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category  Zend
 * @package   Zend_Text_Table
 * @copyright Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd     New BSD License
 * @version   $Id: Unicode.php 12529 2008-11-10 21:05:43Z dasprid $
 */

/**
 * @see Zend_Text_Table_Border_Interface
 */
require_once 'Zend/Text/Table/Border/Interface.php';

/**
 * Unicode border for Zend_Text_Table.
 *
 * @category  Zend
 * @package   Zend_Text_Table
 * @uses      Zend_Text_Table_Border_Interface
 * @copyright Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Text_Table_Border_Unicode implements Zend_Text_Table_Border_Interface
{
    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getTopLeft()
    {
        return $this->_getUnicodeCharacter(0x250C);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getTopRight()
    {
        return $this->_getUnicodeCharacter(0x2510);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getBottomLeft()
    {
        return $this->_getUnicodeCharacter(0x2514);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getBottomRight()
    {
        return $this->_getUnicodeCharacter(0x2518);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getVertical()
    {
        return $this->_getUnicodeCharacter(0x2502);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getHorizontal()
    {
        return $this->_getUnicodeCharacter(0x2500);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getCross()
    {
        return $this->_getUnicodeCharacter(0x253C);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getVerticalRight()
    {
        return $this->_getUnicodeCharacter(0x251C);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getVerticalLeft()
    {
        return $this->_getUnicodeCharacter(0x2524);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getHorizontalDown()
    {
        return $this->_getUnicodeCharacter(0x252C);
    }

    /**
     * Defined by Zend_Text_Table_Border_Interface
     *
     * @return string
     */
    public function getHorizontalUp()
    {
        return $this->_getUnicodeCharacter(0x2534);
    }

    /**
     * Convert a unicode character code to a character
     *
     * @param  integer $code
     * @return string|false
     */
    protected function _getUnicodeCharacter($code)
    {
        switch (true) {
            case ($code <= 0x7F):
                return chr($code);

            case ($code <= 0x7FF):
                return chr(0xC0 | $code >> 6)
                     . chr(0x80 | $code & 0x3F);
            
            case ($code <= 0xFFFF):
                return chr(0xE0 | $code >> 12)
                     . chr(0x80 | $code >> 6 & 0x3F)
                     . chr(0x80 | $code & 0x3F);
            
            case ($code <= 0x10FFFF):
                return chr(0xF0 | $code >> 18)
                     . chr(0x80 | $code >> 12 & 0x3F)
                     . chr(0x80 | $code >> 6 & 0x3F)
                     . chr(0x80 | $code & 0x3F);
            
            default:
                return false;
        }
    }
}