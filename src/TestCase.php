<?php
declare(strict_types = 1);
namespace Pluf\Test;

use Pluf_FileUtil;
define("IN_UNIT_TESTS", true);

class TestCase extends \PHPUnit\Framework\TestCase
{

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $GLOBALS['_PX_starttime'] = microtime(true);
        $GLOBALS['_PX_uniqid'] = uniqid($GLOBALS['_PX_starttime'] . '-time', true);
        $GLOBALS['_PX_signal'] = array();
        $GLOBALS['_PX_locale'] = array();

        require_once 'Pluf.php';
        $tmp_path = 'tests/tmp';
        Pluf_FileUtil::removedir($tmp_path);
        if (! mkdir($tmp_path, 0777, true)) {
            die('Failed to create temp folder...');
        }
    }
}