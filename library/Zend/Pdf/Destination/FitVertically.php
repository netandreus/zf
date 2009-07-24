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
 * @category   Zend
 * @package    Zend_Pdf
 * @subpackage Destination
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/** Zend_Pdf_Destination */
require_once 'Zend/Pdf/Destination.php';


/**
 * Destination array: [page /FitV left]
 *
 * Display the page designated by page, with the horizontal coordinate left positioned
 * at the left edge of the window and the contents of the page magnified
 * just enough to fit the entire height of the page within the window.
 *
 * @package    Zend_Pdf
 * @subpackage Destination
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Pdf_Destination_FitVertically extends Zend_Pdf_Destination
{
    /**
     * Create destination object
     *
     * @param Zend_Pdf_Page|Zend_Pdf_Element|integer $page  Page object,
     *                                                      page number (integer or Zend_Pdf_Element_Numeric object) or
     *                                                      page dictionary object
     * @param float $left  Left edge of displayed page
     * @return Zend_Pdf_Destination_FitVertically
     * @throws Zend_Pdf_Exception
     */
    public static function create($page, $left)
    {
        $destinationArray = new Zend_Pdf_Element_Array();

        if ($page instanceof Zend_Pdf_Element) {
            if ($page->getType() == Zend_Pdf_Element::TYPE_NUMERIC  ||  $page->getType() == Zend_Pdf_Element::TYPE_DICTIONARY) {
                // Page destination entry is a page number or page dictionary object
                $destinationArray->items[] = $page;
            } else {
                require_once 'Zend/Pdf/Exception.php';
                throw new Zend_Pdf_Exception('Page entry must be a Zend_Pdf_Page object, page number or page dictionary reference.');
            }
        } else if ($page instanceof Zend_Pdf_Page) {
            $destinationArray->items[] = $page->getPageDictionary();
        } else if (is_integer($page)) {
            $destinationArray->items[] = new Zend_Pdf_Element_Numeric($page);
        } else {
            require_once 'Zend/Pdf/Exception.php';
            throw new Zend_Pdf_Exception('Page entry must be a Zend_Pdf_Page object, page number or page dictionary reference.');
        }

        $destinationArray->items[] = new Zend_Pdf_Element_Name('FitV');
        $destinationArray->items[] = new Zend_Pdf_Element_Numeric($left);

        return new Zend_Pdf_Destination_FitVertically($destinationArray);
    }

    /**
     * Get left edge of the displayed page
     *
     * @return float
     */
    public function getLeftEdge()
    {
        return $this->_destinationArray->items[2]->value;
    }

    /**
     * Set left edge of the displayed page
     *
     * @param float $left
     * @return Zend_Pdf_Action_FitVertically
     */
    public function setLeftEdge($left)
    {
        $this->_destinationArray->items[2] = new Zend_Pdf_Element_Numeric($left);

        return $this;
    }
}