<?php
declare(strict_types = 1);
namespace Pluf\Test;

use Pluf\FileUtil;
use GuzzleHttp\Psr7\Response;
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

        $tmp_path = 'tests/tmp';
        FileUtil::removedir($tmp_path);
        if (! mkdir($tmp_path, 0777, true)) {
            die('Failed to create temp folder...');
        }
    }

    /**
     * Check if this is a Pluf_Model
     *
     * @param Response $response
     * @param string $message
     */
    public static function assertResponseAsModel(Response $response, $message = '')
    {
        static::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        static::assertArrayHasKey('id', $actual, $message);
        static::assertTrue($actual['id'] > 0, $message);
    }

    /**
     *
     * @param Response $response
     * @param int $code
     * @param string $message
     */
    public static function assertResponseStatusCode(Response $response, $code, $message = 'Status code is not fit')
    {
        static::assertEquals($response->status_code, $code, $message);
    }

    /**
     *
     * @param Response $response
     * @param string $message
     */
    public static function assertResponseNotNull(Response $response, $message = 'Response is null')
    {
        static::assertNotNull($response, $message);
        static::assertNotNull($response->content, $message);
    }

    /**
     *
     * @param Response $response
     * @param string $message
     */
    public static function assertResponsePaginateList(Response $response, $message = '')
    {
        static::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        static::assertArrayHasKey('items', $actual, $message);
        static::assertArrayHasKey('current_page', $actual, $message);
        static::assertArrayHasKey('page_number', $actual, $message);
    }

    /**
     *
     * @param Response $response
     * @param string $message
     */
    public static function assertResponseEmptyPaginateList(Response $response, $message = '')
    {
        static::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        static::assertArrayHasKey('items', $actual, $message);
        static::assertArrayHasKey('current_page', $actual, $message);
        static::assertArrayHasKey('page_number', $actual, $message);
        static::assertTrue(count($actual['items']) == 0, $message);
    }

    /**
     *
     * @param Response $response
     * @param string $message
     */
    public static function assertResponseNonEmptyPaginateList(Response $response, $message = '')
    {
        static::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        static::assertArrayHasKey('items', $actual, $message);
        static::assertArrayHasKey('current_page', $actual, $message);
        static::assertArrayHasKey('page_number', $actual, $message);
        static::assertTrue(count($actual['items']) > 0, $message);
    }

    /**
     *
     * @param Response $response
     * @param string $message
     */
    public static function assertResponseNotAnonymousModel(Response $response, $message = '')
    {
        static::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        static::assertArrayHasKey('id', $actual, $message);
        static::assertTrue($actual['id'] > 0, $message);
    }
}