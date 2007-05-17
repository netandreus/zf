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
 * @package    Zend_Gdata
 * @copyright  Copyright (c) 2005-2007 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * @see Zend_Gdata_App_Entry
 */
require_once 'Zend/Gdata/App/Entry.php';

/**
 * @see Zend_Gdata_App_NoSuchMethodException
 */
require_once 'Zend/Gdata/App/NoSuchMethodException.php';

/**
 * Represents the GData flavor of an Atom entry
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @copyright  Copyright (c) 2005-2007 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata_Entry extends Zend_Gdata_App_Entry
{

    public function __construct($uri = null, $element = null)
    {
        parent::__construct($uri, $element);
        foreach (Zend_Gdata::$namespaces as $nsPrefix => $nsUri) {
            $this->registerNamespace($nsPrefix, $nsUri); 
        }
    }

    public function getDOM($doc = null)
    {
        $element = parent::getDOM($doc);
        if (! $element->hasAttributeNS('http://www.w3.org/2000/xmlns/', 'gd') ) {
            $element->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:'.'gd','http://schemas.google.com/g/2005');
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        default:
          parent::takeChildFromDOM($child);
        }
    }

}
