<?php
// Call Zend_Controller_Request_Apache404Test::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "Zend_Controller_Request_Apache404Test::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'Zend/Controller/Request/Apache404.php';

/**
 * Test class for Zend_Controller_Request_Apache404.
 * Generated by PHPUnit_Util_Skeleton on 2007-06-25 at 08:20:40.
 */
class Zend_Controller_Request_Apache404Test extends PHPUnit_Framework_TestCase 
{
    /**
     * Copy of $_SERVER
     * @var array
     */
    protected $_server;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main()
    {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("Zend_Controller_Request_Apache404Test");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function setUp()
    {
        $this->_server = $_SERVER;
    }

    public function tearDown()
    {
        $_SERVER = $this->_server;
    }

    public function testRedirectUrlSelectedOverRequestUri()
    {
        $_SERVER['REDIRECT_URL'] = '/foo/bar';
        $_SERVER['REQUEST_URI']  = '/baz/bat';

        $request = new Zend_Controller_Request_Apache404();
        $requestUri = $request->getRequestUri();
        $this->assertEquals('/foo/bar', $requestUri);
    }

    /**
     * @group ZF-3057
     */
    public function testRedirectQueryStringShouldBeParsedIntoGetVars()
    {
        $_SERVER['REDIRECT_URL']         = '/foo/bar';
        $_SERVER['REDIRECT_QUERYSTRING'] = 'baz=bat&bat=delta';
        $_SERVER['REQUEST_URI']          = '/baz/bat';

        $request = new Zend_Controller_Request_Apache404();
        $requestUri = $request->getRequestUri();
        $this->assertEquals('/foo/bar', $requestUri);
        $this->assertSame(array('baz' => 'bat', 'bat' => 'delta'), $request->getQuery());
    }
}

// Call Zend_Controller_Request_Apache404Test::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "Zend_Controller_Request_Apache404Test::main") {
    Zend_Controller_Request_Apache404Test::main();
}
