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
use PHPUnit\Framework\TestCase;

class Pluf_Tests_Log_TestRemote extends TestCase
{

    function __construct()
    {
        parent::__construct('Test the remote logger.');
    }

    function setUp()
    {
        $GLOBALS['_PX_config']['log_delayed'] = true;
        $GLOBALS['_PX_config']['log_handler'] = 'Pluf_Log_Remote';
        $GLOBALS['_PX_config']['log_remote_server'] = '127.0.0.1';
        Pluf_Log::$stack = array();
    }

    function tearDown()
    {
        $GLOBALS['_PX_config']['log_handler'] = 'Pluf_Log_File';
        $GLOBALS['_PX_config']['log_delayed'] = false;
    }

    function testSimple()
    {
        if (Pluf::f('test_log_testremote', false) == false) {
            return;
        }
        $GLOBALS['_PX_config']['log_delayed'] = true;
        Pluf_Log::log('hello');
        $this->assertEqual(count(Pluf_Log::$stack), 1);
        $GLOBALS['_PX_config']['log_delayed'] = false;
        Pluf_Log::log('hello');
        $this->assertEqual(count(Pluf_Log::$stack), 0);
    }

    function testAssertLog()
    {
        if (Pluf::f('test_log_testremote', false) == false) {
            return;
        }
        Pluf_Log::activeAssert();
        $GLOBALS['_PX_config']['log_delayed'] = true;
        assert('Pluf_Log::alog("hello")');
        $this->assertEqual(count(Pluf_Log::$stack), 1);
        $GLOBALS['_PX_config']['log_delayed'] = false;
        assert('Pluf_Log::alog("hello")');
        $this->assertEqual(count(Pluf_Log::$stack), 0);
    }

/**
 * function testPerformance()
 * {
 * $start = microtime(true);
 * $GLOBALS['_PX_config']['log_delayed'] = false;
 * for ($i=0;$i<100;$i++) {
 * Pluf_Log::log('hello'.$i);
 * }
 * $end = microtime(true);
 * print "Remote: ".($end-$start)."s\n";
 * $start = microtime(true);
 * $GLOBALS['_PX_config']['log_delayed'] = true;
 * for ($i=0;$i<100;$i++) {
 * Pluf_Log::log('hello'.$i);
 * }
 * Pluf_Log::flush();
 * $end = microtime(true);
 * print "Remote delayed: ".($end-$start)."s\n";
 * }
 */
}