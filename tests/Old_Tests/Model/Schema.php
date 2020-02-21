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

class Pluf_Tests_Model_Schema_Model extends Pluf_Model
{

    public $_model = __CLASS__;

    function init()
    {
        $this->_a['verbose'] = 'compressed';
        $this->_a['table'] = 'compressed';
        $this->_a['model'] = __CLASS__;
        $this->_a['cols'] = array(
            // It is mandatory to have an "id" column.
            'id' => array(
                'type' => 'Pluf_DB_Field_Sequence',
                // It is automatically added.
                'blank' => true
            ),
            'column1' => array(
                'type' => 'Pluf_DB_Field_Varchar'
            ),
            'column2' => array(
                'type' => 'Pluf_DB_Field_Varchar'
            ),
            'column3' => array(
                'type' => 'Pluf_DB_Field_Varchar'
            )
        );
        $this->_a['idx'] = array(
            'test_idx' => array(
                'col' => 'column1, column2, column3',
                'type' => 'unique'
            )
        );
    }
}

class Pluf_Tests_Model_Schema extends TestCase
{

    function __construct()
    {
        parent::__construct('Test the compressed field.');
    }

    function testCreate()
    {
        $db = Pluf::db();
        $schema = new Pluf_DB_Schema($db);
        $m = new Pluf_Tests_Model_Schema_Model();
        $schema->model = $m;
        $schema->createTables();
        $m->column1 = 'Youplaboum';
        $m->column2 = 'Youplaboum';
        $m->column3 = 'Youplaboum';
        $m->create();
        $this->assertEqual(1, $m->id);
        $m = new Pluf_Tests_Model_Schema_Model();
        $m->column1 = 'Youplaboum';
        $m->column2 = 'Youplaboum';
        $m->column3 = 'Youplaboum';
        try {
            $m->create();
            $this->assertNotEqual(2, $m->id, 'Should not be able to create.');
        } catch (Exception $e) {
            // do nothing
        }
        $schema->dropTables();
    }
}