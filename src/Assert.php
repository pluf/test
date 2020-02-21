<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace Pluf\Test;

use Pluf_HTTP_Response;

/**
 * Essensial Pluf assertions
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 */
class Test_Assert extends \PHPUnit\Framework\Assert
{

    /**
     * Check if this is a Pluf_Model
     *
     * @param Pluf_HTTP_Response $response
     * @param string $message
     */
    public static function assertResponseAsModel($response, $message = '')
    {
        static::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        static::assertArrayHasKey('id', $actual, $message);
        static::assertTrue($actual['id'] > 0, $message);
    }

    /**
     *
     * @param Pluf_HTTP_Response $response
     * @param int $code
     * @param string $message
     */
    public static function assertResponseStatusCode($response, $code, $message = 'Status code is not fit')
    {
        static::assertEquals($response->status_code, $code, $message);
    }

    /**
     *
     * @param Pluf_HTTP_Response $response
     * @param string $message
     */
    public static function assertResponseNotNull($response, $message = 'Response is null')
    {
        static::assertNotNull($response, $message);
        static::assertNotNull($response->content, $message);
    }

    /**
     *
     * @param Pluf_HTTP_Response $response
     * @param string $message
     */
    public static function assertResponsePaginateList($response, $message = '')
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
    public static function assertResponseEmptyPaginateList($response, $message = '')
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
    public static function assertResponseNonEmptyPaginateList($response, $message = '')
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
    public static function assertResponseNotAnonymousModel($response, $message = '')
    {
        static::assertJson($response->content, $message);
        $actual = json_decode($response->content, true);
        static::assertArrayHasKey('id', $actual, $message);
        static::assertTrue($actual['id'] > 0, $message);
    }
}