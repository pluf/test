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

class Pluf_Tests_Templatetags_Firstof extends TestCase
{

    protected $tag_class = 'Pluf_Template_Tag_Firstof';

    protected $tag_name = 'firstof';

    public function testNoArguments()
    {
        $tpl = $this->getNewTemplate('{firstof}');
        try {
            $tpl->render();
            $this->fail();
        } catch (InvalidArgumentException $e) {
            $this->pass();
        }
    }

    public function testOutputsNothing()
    {
        $context = new Pluf_Template_Context(array(
            'a' => 0,
            'b' => 0,
            'c' => 0
        ));
        $to_parse = '{firstof array($a, $b, $c)}';
        $expected = '';
        $tpl = $this->getNewTemplate($to_parse);
        $this->assertEqual($expected, $tpl->render($context));
    }

    public function testOutputsMatched()
    {
        $to_parse = '{firstof array($a, $b, $c)}';

        $context = new Pluf_Template_Context(array(
            'a' => 1,
            'b' => 0,
            'c' => 0
        ));
        $expected = '1';
        $tpl = $this->getNewTemplate($to_parse);
        $this->assertEqual($expected, $tpl->render($context));

        $context = new Pluf_Template_Context(array(
            'a' => 0,
            'b' => 2,
            'c' => 0
        ));
        $expected = '2';
        $tpl = $this->getNewTemplate($to_parse);
        $this->assertEqual($expected, $tpl->render($context));

        $context = new Pluf_Template_Context(array(
            'a' => 0,
            'b' => 0,
            'c' => 3
        ));
        $expected = '3';
        $tpl = $this->getNewTemplate($to_parse);
        $this->assertEqual($expected, $tpl->render($context));
    }

    public function testOutputsFirstMatch()
    {
        $context = new Pluf_Template_Context(array(
            'a' => 1,
            'b' => 2,
            'c' => 3
        ));
        $to_parse = '{firstof array($a, $b, $c)}';
        $expected = '1';
        $tpl = $this->getNewTemplate($to_parse);
        $this->assertEqual($expected, $tpl->render($context));
    }

    public function testOutputsFallback()
    {
        $context = new Pluf_Template_Context(array(
            'a' => 0,
            'b' => 0,
            'c' => 0
        ));
        $to_parse = '{firstof array($a, $b, $c), "my fallback"}';
        $expected = 'my fallback';
        $tpl = $this->getNewTemplate($to_parse);
        $this->assertEqual($expected, $tpl->render($context));
    }
}
