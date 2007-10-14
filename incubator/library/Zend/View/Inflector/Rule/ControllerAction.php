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
 * @package    Zend_View
 * @subpackage Inflector
 * @copyright  Copyright (c) 2005-2007 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/** Zend_View_Inflector_Rule_Abstract */
require_once 'Zend/View/Inflector/Rule/Abstract.php';

/**
 * Inflect controller/action into view script path
 *
 * @package    Zend_View
 * @subpackage Inflector
 * @copyright  Copyright (c) 2005-2007 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_View_Inflector_Rule_ControllerAction extends Zend_View_Inflector_Rule_Abstract
{
    /**
     * View script path specification string
     * @var string
     */
    protected $_pathSpec = ':controller/:action.:suffix';

    /**
     * View script suffix
     * @var string
     */
    protected $_suffix   = 'phtml';

    /**
     * Get parameters for inflection
     * 
     * @param  string $path 
     * @param  array $params 
     * @return array
     */
    public function getParams($path, array $params = array())
    {
        $request    = $this->getRequest();
        $controller = $request->getControllerName();
        $action     = $path;
        $suffix     = $this->getSuffix();

        foreach ($params as $key => $value) {
            switch ($key) {
                case 'controller':
                case 'action':
                case 'suffix':
                    $$key = (string) $value;
                    break;
                default:
                    break;
            }
        }

        $params = compact('controller', 'action', 'suffix');
        return $params;
    }

    /**
     * Retrieve script suffix
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->_suffix;
    }

    /**
     * Inflect suffix
     *
     * Does nothing
     * 
     * @return string
     */
    public function inflectSuffix($suffix)
    {
        return $suffix;
    }

    /**
     * Set script suffix
     *
     * @param  string $value
     * @return Zend_View_Inflector_Rule_ControllerAction
     */
    public function setSuffix($suffix)
    {
        $this->_suffix = (string) $suffix;
        return $this;
    }

}
