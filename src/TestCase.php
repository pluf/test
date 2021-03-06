<?php
declare(strict_types = 1);
namespace Pluf\Test;

use Pluf_HTTP_Response;
use Pluf_Model;
define("IN_UNIT_TESTS", true);

require_once 'Pluf.php';

class TestCase extends \PHPUnit\Framework\TestCase
{

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $GLOBALS['_PX_starttime'] = microtime(true);
        $GLOBALS['_PX_uniqid'] = uniqid('pluf-test-time-', true);
        $GLOBALS['_PX_signal'] = array();
        $GLOBALS['_PX_locale'] = array();
    }

    /**
     * Check if this is a Pluf_Model
     *
     * @param Pluf_HTTP_Response $response
     * @param string $message
     */
    public static function assertResponseAsModel($response, ?string $message = ''): void
    {
        if ($response->content instanceof Pluf_Model) {
            self::assertFalse($response->content->isAnonymous());
            return;
        }
        self::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        self::assertArrayHasKey('id', $actual, $message);
        self::assertTrue($actual['id'] > 0, $message);
    }

    /**
     *
     * @param Pluf_HTTP_Response $response
     * @param int $code
     * @param string $message
     */
    public static function assertResponseStatusCode(Pluf_HTTP_Response $response, $code, $message = 'Status code is not fit'): void
    {
        static::assertEquals($response->status_code, $code, $message);
    }

    /**
     *
     * @param Pluf_HTTP_Response $response
     * @param string $message
     */
    public static function assertResponseNotNull(Pluf_HTTP_Response $response, $message = 'Response is null'): void
    {
        static::assertNotNull($response, $message);
        static::assertNotNull($response->content, $message);
    }

    /**
     *
     * @param Pluf_HTTP_Response $response
     * @param string $message
     */
    public static function assertResponsePaginateList(Pluf_HTTP_Response $response, $message = ''): void
    {
        static::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        static::assertArrayHasKey('items', $actual, $message);
        static::assertArrayHasKey('current_page', $actual, $message);
        static::assertArrayHasKey('page_number', $actual, $message);
    }

    /**
     *
     * @param Pluf_HTTP_Response $response
     * @param string $message
     */
    public static function assertResponseEmptyPaginateList(Pluf_HTTP_Response $response, $message = ''): void
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
     * @param Pluf_HTTP_Response $response
     * @param string $message
     */
    public static function assertResponseNonEmptyPaginateList(Pluf_HTTP_Response $response, $message = ''): void
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
     * @param Pluf_HTTP_Response $response
     * @param string $message
     */
    public static function assertResponseNotAnonymousModel(Pluf_HTTP_Response $response, $message = ''): void
    {
        static::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        static::assertArrayHasKey('id', $actual, $message);
        static::assertTrue($actual['id'] > 0, $message);
    }
}