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

class Pluf_Tests_Model_CompressedField_Model extends Pluf_Model
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
            'compressed' => array(
                'type' => 'Pluf_DB_Field_Compressed'
            )
        );
    }
}

class Pluf_Tests_Model_CompressedField extends TestCase
{

    function __construct()
    {
        parent::__construct('Test the compressed field.');
    }

    function testCreate()
    {
        $db = Pluf::db();
        $schema = new Pluf_DB_Schema($db);
        $m = new Pluf_Tests_Model_CompressedField_Model();
        $schema->model = $m;
        $schema->createTables();
        $m->compressed = 'Youplaboum';
        $m->create();
        $this->assertEqual(1, $m->id);
        $m = new Pluf_Tests_Model_CompressedField_Model(1);
        $this->assertEqual('Youplaboum', $m->compressed);
        $schema->dropTables();
    }
}