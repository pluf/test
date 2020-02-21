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

class Pluf_Tests_TemplateCompiler_BlockTrans extends TestCase
{

    function __construct()
    {
        parent::__construct('Test the compilation of a template.');
    }

    function testCompileSimpleBlock()
    {
        $block = '<li>{blocktrans}This email <em>{$email}</em> is already registered. If you forgot your password, you can recover it easily.{/blocktrans}</li>';
        $compiler = new Pluf_Template_Compiler('dummy', array(), false);
        $compiler->templateContent = $block;
        $this->assertEqual('<li><?php ob_start(); ?>This email <em>%%email%%</em> is already registered. If you forgot your password, you can recover it easily.<?php $_b_t_s=ob_get_contents(); ob_end_clean(); echo(Pluf_Translation::sprintf(__($_b_t_s), array(\'email\' => Pluf_Template_safeEcho($t->_vars->email, false)))); ?></li>', $compiler->getCompiledTemplate());
    }
}