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

/**
 * Create File fixtuer in unit testing
 * 
 * @author maso
 * @author hadi
 */
class File
{

    /**
     * Create a file upload structure
     *
     * The global $_FILES will contain all the uploaded file information.
     * Its contents from the example form is as follows. Note that this assumes the use of the file upload name userfile, as used in the example script above. This can be any name.
     *
     * $_FILES['userfile']['name']
     * The original name of the file on the client machine.
     *
     * $_FILES['userfile']['type']
     * The mime type of the file, if the browser provided this information. An example would be "image/gif". This mime type is however not checked on the PHP side and therefore don't take its value for granted.
     *
     * $_FILES['userfile']['size']
     * The size, in bytes, of the uploaded file.
     *
     * $_FILES['userfile']['tmp_name']
     * The temporary filename of the file in which the uploaded file was stored on the server.
     *
     * $_FILES['userfile']['error']
     * The error code associated with this file upload.
     *
     * @param string $file
     * @return array file structer
     */
    public static function loadFile($file)
    {
        
        return array(
            'name' => '',
            'type' => '',
            'size' => '',
            'tmp_name' => '',
            'error' => 0
        );
    }
}