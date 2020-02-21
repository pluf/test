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

class Pluf_Tests_Templatetags_Now extends TestCase
{

    protected $tag_class = 'Pluf_Template_Tag_Now';

    protected $tag_name = 'now';

    public function testSimpleCase()
    {
        $to_parse = '{now "j n Y"}';
        $expected = date("j n Y");
        $tpl = $this->getNewTemplate($to_parse);
        $this->assertEqual($expected, $tpl->render());
    }

    public function testParsingEscapedCharaters()
    {
        $to_parse = '{now "j \"n\" Y"}';
        $expected = date("j \"n\" Y");
        $tpl = $this->getNewTemplate($to_parse);
        $this->assertEqual($expected, $tpl->render());

        $to_parse = '{now "j \nn\n Y"}';
        $tpl = $this->getNewTemplate($to_parse);
        $expected = date("j \nn\n Y");
        $this->assertEqual($expected, $tpl->render());
    }
}
