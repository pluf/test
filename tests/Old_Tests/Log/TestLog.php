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

class Pluf_Tests_Log_TestLog extends TestCase
{

    protected $logfile = '';

    function __construct()
    {
        parent::__construct('Test the logger.');
    }

    function setUp()
    {
        $GLOBALS['_PX_config']['log_delayed'] = false;
        Pluf_Log::$level = Pluf_Log::ALL;
        Pluf_Log::$stack = array();
        $this->logfile = Pluf::f('pluf_log_file', Pluf::f('tmp_folder', '/tmp') . '/pluf.log');
        @unlink($this->logfile);
    }

    function tearDown()
    {
        @unlink($this->logfile);
    }

    function testSimple()
    {
        $GLOBALS['_PX_config']['log_delayed'] = true;
        Pluf_Log::log('hello');
        $this->assertEqual(count(Pluf_Log::$stack), 1);
        $GLOBALS['_PX_config']['log_delayed'] = false;
        Pluf_Log::log('hello');
        $this->assertEqual(count(Pluf_Log::$stack), 0);
        $this->assertEqual(2, count(file($this->logfile)));
    }

    function testAssertLog()
    {
        Pluf_Log::activeAssert();
        $GLOBALS['_PX_config']['log_delayed'] = true;
        assert('Pluf_Log::alog("hello")');
        $this->assertEqual(count(Pluf_Log::$stack), 1);
        $GLOBALS['_PX_config']['log_delayed'] = false;
        assert('Pluf_Log::alog("hello")');
        $this->assertEqual(count(Pluf_Log::$stack), 0);
        $this->assertEqual(2, count(file($this->logfile)));
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
 * print "File: ".($end-$start)."s\n";
 * $start = microtime(true);
 * $GLOBALS['_PX_config']['log_delayed'] = true;
 * for ($i=0;$i<100;$i++) {
 * Pluf_Log::log('hello'.$i);
 * }
 * Pluf_Log::flush();
 * $end = microtime(true);
 * print "File delayed: ".($end-$start)."s\n";
 * }
 */
}