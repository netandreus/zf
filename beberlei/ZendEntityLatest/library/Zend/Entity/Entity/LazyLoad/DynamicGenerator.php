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
 * @package    Zend_Entity
 * @subpackage LazyLoad
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * Dynamic creation of proxies using eval()
 *
 * @uses       Zend_Entity_LazyLoad_GeneratorAbstract
 * @category   Zend
 * @package    Zend_Entity
 * @subpackage LazyLoad
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Entity_LazyLoad_DynamicGenerator extends Zend_Entity_LazyLoad_GeneratorAbstract
{
    public function generate()
    {
        foreach($this->_classes AS $class) {
            if(class_exists($class->getName(), false)) {
                continue;
            }

            $file = new Zend_CodeGenerator_Php_File();
            $classFile = sys_get_temp_dir()."/ZendProxy_".$class->getName().".php";
            $file->setFilename($classFile);
            $file->setClass($class);
            $file->write();

            require_once($classFile);
        }
    }
}