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
 * @package    Zend_Reflection
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * @see Zend_Reflection_Class
 */
require_once 'Zend/Reflection/Class.php';

/**
 * @see Zend_Reflection_Function
 */
require_once 'Zend/Reflection/Function.php';

require_once 'Zend/Reflection/Factory.php';

/**
 * @category   Zend
 * @package    Zend_Reflection
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Reflection_Extension extends ReflectionExtension
{
    protected $_factory;
    
    function __construct($name, $factory) {
        $this->_factory = $factory;
        parent::__construct($name);
    }
    
    /**
     * getFunctions()
     *
     * @return array Array of Zend_Reflection_Function
     */
    public function getFunctions()
    {
        $phpReflections = parent::getFunctions();
        $zendReflections = array();
        while ($phpReflections && ($phpReflection = array_shift($phpReflections))) {
            $zendReflections[] = $this->_factory->createFunction($phpReflection->getName());
            unset($phpReflection);
        }
        unset($phpReflections);
        return $zendReflections;
    }
    
    /**
     * getClasses()
     *
     * @return array Array of Zend_Reflection_Class
     */
    public function getClasses()
    {
        $phpReflections = parent::getClasses();
        $zendReflections = array();
        while ($phpReflections && ($phpReflection = array_shift($phpReflections))) {
            $zendReflections[] = $this->_factory->createClass($phpReflection->getName());
            unset($phpReflection);
        }
        unset($phpReflections);
        return $zendReflections;
    }
}