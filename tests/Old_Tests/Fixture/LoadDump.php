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

class Pluf_Tests_Fixture_LoadDump extends TestCase
{

    function __construct()
    {
        parent::__construct('Test fixture load/dump.');
    }

//     function setUp()
//     {
//         $db = Pluf::db();
//         $schema = Pluf::factory('Pluf_DB_Schema', $db);
//         $m = new Role();
//         $schema->model = $m;
//         $schema->dropTables();
//         $schema->createTables();
//     }

//     function tearDown()
//     {
//         $db = Pluf::db();
//         $schema = Pluf::factory('Pluf_DB_Schema', $db);
//         $m = new Role();
//         $schema->model = $m;
//         $schema->dropTables();
//     }

//     function testDump()
//     {
//         $p = new Role();
//         $p->name = 'test permission';
//         $p->code_name = 'test';
//         $p->description = 'Simple test permission.';
//         $p->application = 'Pluf';
//         $p->create();
//         $json = Pluf_Test_Fixture::dump('Role');
//         $this->assertEqual('[{"model":"Role","pk":1,"fields":{"id":1,"name":"test permission","code_name":"test","description":"Simple test permission.","application":"Pluf"}}]', $json);
//     }

//     function testLoad()
//     {
//         $created = Pluf_Test_Fixture::load('[{"model":"Role","pk":1,"fields":{"id":1,"name":"test permission","code_name":"test","description":"Simple test permission.","application":"Pluf"}}]');
//         $this->assertEqual(array(
//             array(
//                 'Role',
//                 '1'
//             )
//         ), $created);
//         $p = new Role(1);
//         $this->assertEqual(1, $p->id);
//     }
}