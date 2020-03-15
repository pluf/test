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

use Pluf;
use Exception;

/**
 * The fixture class is used to prepopulate your database with data.
 *
 * Load a fixture file in the database:
 * array = Pluf_Test_Fixture::load('fixturefile.json');
 *
 * Dump the data of a model as a fixture string:
 * $json = \Pluf\Test\Fixture::dump('YourApp_Model');
 * $json = \Pluf\Test\Fixture::dump($model);
 */
class Fixture
{

    public static function loadFile($file)
    {
        if (false === ($ffile = Pluf::fileExists($file))) {
            throw new Exception(sprintf(__('Fixture file not found: %s.'), $file));
        }
        return self::load(file_get_contents($ffile));
    }

    public static function load($json, $deserialize = true)
    {
        $created = array();
        $data = ($deserialize) ? json_decode($json, true) : $json;
        unset($json);
        foreach ($data as $model) {
            if ((int) $model['pk'] > 0) {
                $item = new $model['model']($model['pk']);
                if ($item->id == $model['pk']) {
                    throw new Exception(sprintf(__('Cannot load existing model <%1$s(%2$s)>.'), $model['model'], $model['pk']));
                }
            }
            $m = new $model['model']();
            $m->setFromFormData($model['fields']);
            $m->create(true); // we load in raw mode
            $created[] = array(
                $model['model'],
                $model['pk']
            );
        }
        return $created;
    }

    /**
     * Given a model or model name, dump the content.
     *
     * If the object is given, only this single object is dumped else
     * the complete table.
     *
     * @param
     *            mixed Model object or model name
     * @param
     *            bool Serialize as JSON (true)
     * @return mixed Array or JSON string
     */
    public static function dump($model, $serialize = true)
    {
        if (is_object($model)) {
            return ($serialize) ? json_encode(array(
                self::prepare($model)
            )) : array(
                self::prepare($model)
            );
        }
        $out = array();
        foreach (Pluf::factory($model)->getList(array(
            'order' => 'id ASC'
        )) as $item) {
            $out[] = self::prepare($item);
        }
        return ($serialize) ? json_encode($out) : $out;
    }

    /**
     * Return an array, ready to be serialized as json.
     */
    public static function prepare($model)
    {
        $out = array(
            'model' => $model->_a['model'],
            'pk' => $model->id,
            'fields' => array()
        );
        foreach ($model->_a['cols'] as $col => $val) {
            $field = new $val['type']();
            if ($field->type != 'manytomany') {
                $out['fields'][$col] = $model->$col;
            } else {
                $func = 'get_' . $col . '_list';
                $out['fields'][$col] = array();
                foreach ($model->$func() as $item) {
                    $out['fields'][$col][] = $item->id;
                }
            }
        }
        return $out;
    }
}