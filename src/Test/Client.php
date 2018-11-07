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

/**
 * Emulates a client to call your views during unit testing.
 * 
 * There are several assumption in Pluf_Dispatcher which must fill befor
 * calling a view. This Methodd init system to call view functions.
 * 
 * Usage:
 * <code>
 * $client = new Pluf_Test_Client('./path/to/app-views.php');
 * $response = $client->get('/the/page/', array('var'=>'toto'));
 * </code>
 * 
 * In this example $response is the view response.
 * 
 *
 */

define ( "IN_UNIT_TESTS", true);

class Test_Client
{
    public $views = '';
    public $dispatcher = '';
    public $cookies = array();

    public function __construct($views)
    {
        $this->views = $views;
        $this->dispatcher = new Pluf_Dispatcher();
        $this->clean(false);
    }

    /**
     * Clean client connection
     * 
     * @param boolean $keepcookies
     */
    protected function clean($keepcookies=true)
    {
        $_REQUEST = array();
        if (!$keepcookies) {
            $_COOKIE = array();
            $this->cookies = array();
        }
//         $_SERVER = array();
        $_GET = array();
        $_POST = array();
        $_FILES = array();
        $_SERVER['REQUEST_METHOD'] = '';
        $_SERVER['REQUEST_URI'] = '';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['HTTP_USER_AGENT'] = 'pluf/test-Embed PHP Library';
        
        $req = new Pluf_HTTP_Request('');
        $GLOBALS['_PX_request'] = $req;
    }

    /**
     * Dispatch a url
     * 
     * @param string $page
     * @return Object
     */
    protected function dispatch($page)
    {
        $GLOBALS['_PX_tests_templates'] = array();
        $_SERVER['REQUEST_URI'] = $page;
        foreach ($this->cookies as $cookie => $data) {
            $_COOKIE[$cookie] = $data;
        }
        ob_implicit_flush(False);
        list($request, $response) = $this->dispatcher->dispatch($page, $this->views);
        ob_start();
        $response->render();
        $content = ob_get_contents(); 
        ob_end_clean();
        $response->content = $content;
        $response->request = $request;
        if (isset($GLOBALS['_PX_tests_templates'])) {
            if (count($GLOBALS['_PX_tests_templates']) == 1) {
                $response->template = $GLOBALS['_PX_tests_templates'][0];
            } else {
                $response->template = $GLOBALS['_PX_tests_templates'];
            }
        }
        foreach ($response->cookies as $cookie => $data) {
            $_COOKIE[$cookie] = $data;
            $this->cookies[$cookie] = $data;
        }
        return $response;
    }

    /**
     * Calling a get function
     * 
     * @param string $page the view url
     * @param array $params
     * @return object
     */
    public function get($page, $params=array()) 
    {
        $this->clean();
        $_GET = $params;
        $_REQUEST = $params;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $response = $this->dispatch($page);
        $code = $response->status_code;
        if ($code == 302) {
            list($page, $params) = $this->parseRedirect($response->headers['Location']);
            $response = $this->get($page, $params);
        }
        return $response;
    }

    
    /**
     * Calling a post fuction
     *
     * @param string $page the view url
     * @param array $params
     * @param files list of attached files
     * @return object
     */
    public function post($page, $params=array(), $files=array()) 
    {
        $this->clean();
        $_POST = $params;
        $_REQUEST = $params;
        $_FILES = $files; //FIXME need to match the correct array structure
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $response = $this->dispatch($page);
        if ($response->status_code == 302) {
            list($page, $params) = $this->parseRedirect($response->headers['Location']);
            return $this->get($page, $params);
        }
        return $response;
    }

    
    /**
     * Calling a delete fuction
     *
     * @param string $page the view url
     * @param array $params
     * @return object
     */
    public function delete($page, $params=array()) 
    {
        $this->clean();
        $_POST = $params;
        $_REQUEST = $params;
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $response = $this->dispatch($page);
        if ($response->status_code == 302) {
            list($page, $params) = $this->parseRedirect($response->headers['Location']);
            return $this->get($page, $params);
        }
        return $response;
    }

    public function parseRedirect($location)
    {
        $page = parse_url($location, PHP_URL_PATH);
        $query = parse_url($location, PHP_URL_QUERY);
        $params = array();
        if (strlen($query)) {
            parse_str($query, $params);
        }
        return array($page, $params);
    }
}

